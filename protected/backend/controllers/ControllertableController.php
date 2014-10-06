<?php

class ControllertableController extends SController{
	public function actionIndex(){
		$this->pageTitle = Jii::t("Manage Controllers");
		Log::trace('Access Controllers/Actions list');
		$criteria = new CDbCriteria;
		$criteria->with = array('controllertable');
		$criteria->order = 'controller_name ASC , action_name ASC';
		$actions = ActionTable::model()->findAll($criteria);
		$this->render('index',array('actions'=>$actions));
	}
	public function actionSynchronize(){
		$this->pageTitle = Jii::t("Manage Synchronize Controllers & Actions");
		$path = Yii::app()->basePath.'/controllers/';
		$dir_handle = @opendir($path) or die("Unable to open folder");
		$i = 0;
		while (false !== ($file = readdir($dir_handle))) {
			if($file == "index.php")
				continue;
			if($file == ".")
				continue;
			if($file == "..")
				continue;
			if($file == "AuthenticationController.php")
				continue;
			if($file == "BrowserController.php")
				continue;	
			if($file == "ExceptionController.php")
				continue;	
			if(is_dir($path.$file)){
				continue;
			}else{
				$di = explode('.',$file);
				$last = count($di)-1;
				if(in_array($di[$last],array("php"))){
					$controllersfolder[$i] = $file;
					$i++;
				}
			}
		}
		closedir($dir_handle);
		foreach($controllersfolder AS $k=>$v){
			$len = strlen($v);
			$filename = substr($v, 0 , $len - 14 );
			$controller = 	ControllerTable::model()->findByAttributes(array('controller_name'=>$filename));
			if(!isset($controller->controller_id)){
				$controller = new ControllerTable;
				$controller->controller_name = $filename;
				$controller->save();
				Log::trace("The controller #".$controller->controller_id.'&laquo;'.$controller->controller_name.'&raquo; has been saved successfully');
			}
			$class = explode(".",$v);
			$actionsfile = $this->getActionsFile($class[0]);
			foreach($actionsfile AS $a){
				$action = ActionTable::model()->findByAttributes(array('action_name'=>$a,'action_controllerid'=>$controller->controller_id));
				if(!isset($action->action_id)){
					$action = new ActionTable;
					$action->action_name = $a;
					$action->action_controllerid = $controller->controller_id;
					$action->save();
					Log::trace("The action #".$action->action_id.'&laquo;'.$action->action_name.'&raquo; has been saved successfully');
				}	
			}
		}
		Log::success("The Contollers &amp; Actions has been synchronized successfully");
		$this->redirect(array('controllertable/index'));
	}
	public function getActionsFile($class){
		$result = array();
		Yii::import("application.controllers." . $class, true);
		$reflection = new ReflectionClass($class); 
  		$methods = $reflection->getMethods();
		$i = 0;
		foreach($methods As $k=>$v){
			$name = substr($v->name,0,6);
			$func = substr($v->name,6,strlen($v->name)-1);
			if($name == 'action' && $func != 's'){
				$result[$i] = $func;
				$i++;
			}
		}
		return $result;
	}
	public function actionRemoveAction(){
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$action = ActionTable::model()->findByPk($_GET['id']);
			$res = ActionTable::model()->deleteByPk($_GET['id']);
			if($res){
				PermissionTable::model()->deleteAllByAttributes(array('permission_actionid'=>$_GET['id']));
				Log::success("The action has been deleted successfully");
				Log::trace("The action #".$action->action_id.'&laquo;'.$action->action_name.'&raquo; has been deleted successfully');
			}else{
				Log::error("The action hasn't been deleted successfully");
			}
			$this->redirect(array("controllertable/index"));
		}else{
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}
	public function actionRemoveController(){
		if(isset($_GET['id']) && $_GET['id'] > 0){
			$controller = ControllerTable::model()->findByPk($_GET['id']);
			$res = ControllerTable::model()->deleteByPk($_GET['id']);
			if($res){
				ActionTable::model()->deleteAllByAttributes(array('action_controllerid'=>$_GET['id']));
				PermissionTable::model()->deleteAllByAttributes(array('permission_controllerid'=>$_GET['id']));
				Log::success("The controller has been deleted successfully");
				Log::trace("The action #".$controller->controller_id.'&laquo;'.$controller->controller_name.'&raquo; has been deleted successfully');
			}else{
				Yii::app()->user->setFlash('error', Jii::t("The controller hasn't been deleted successfully"));
			}
			$this->redirect(array("controllertable/index"));
		}else{
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}
}
?>