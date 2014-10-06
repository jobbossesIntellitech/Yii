<?php
class ProfileController extends SController{
	
	public function actionIndex(){
		$this->pageTitle = Jii::t('My Profile');
		$model = new UserForm;
		$model->setScenario('update');
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$u = User::model()->findByPk($model->id);
				$u->usr_image = isset($model->image[0])?$model->image[0]:Jii::notfound();
				$u->usr_firstname = $model->firstname;
				$u->usr_lastname = $model->lastname;
				$u->usr_username = $model->username;
				if(!empty($model->password)){
					$password = new Password($model->password);
					$u->usr_password = $password->getHash();
					$u->usr_saltpassword = $password->getSalt();
				}
				$u->usr_status = $model->status;
				$u->usr_color = $model->color;
				$res = $u->save();
				$u->setPrimaryKey($u->primaryKey);
				Log::trace('Save User');
				if($res){
					Jii::app()->user->setState('image',$u->usr_image);
					Jii::app()->user->setState('color',$u->usr_color);
					Log::success('The user has been edited successfully');
				}else{
					Log::error('The user hasnt been edited');	
				}
				$this->redirect(array('profile/index'));		
			}else{
				$this->render('index',array('model'=>$model));	
			}
 		}else{
			Log::trace('Open user form');
			$u = User::model()->findByPk(Jii::app()->user->id);
			$model->id = $u->usr_id;
			$model->username = $u->usr_username;
			$model->firstname = $u->usr_firstname;
			$model->lastname = $u->usr_lastname;
			$model->status = $u->usr_status;
			$model->color = $u->usr_color;
			$model->parent = $u->usr_parent;
			$model->image = array($u->usr_image);
			$this->render('index',array('model'=>$model));
		}	
	}
			
}
?>