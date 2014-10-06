<?php
class MenuController extends SController{
	
	public function actionIndex(){
		if(Jii::isAjax()){
			Log::trace('Access Menus list');
			$criteria = new JDbGridView();
			$criteria->with = array('field');
			echo $criteria->execute($this,'Menu',array(),'list');	
		}else{
			$this->pageTitle = Jii::t('Manage Menu');
			Log::trace('Access menus');
			$this->render('index');
		}
	}
	
	public function actionAdd(){
		$this->pageTitle = Jii::t('Add new menu');
		$model = new MenuForm;
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$f = new Menu;
				$f->menu_name = $model->name;
				$f->menu_status = $model->status;
				$f->menu_hook = $model->hook;
				if($f->save()){
					Log::success('The menu has been created succesfully');	
				}else{
					Log::error('The menu has not been created');	
				}
				$this->redirect(array('menu/index'));
			}else{
				Log::warning('Menu inputs error');
				$this->render('add',array('model'=>$model));	
			}
		}else{
			Log::trace('Access add new menu');
			$this->render('add',array('model'=>$model));
		}
	}
	
	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit menu');
		$model = new MenuForm;
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$f = Menu::model()->findByPk($model->id);
				$f->menu_name = $model->name;
				$f->menu_status = $model->status;
				$f->menu_hook = $model->hook;
				if($f->save()){
					Log::success('The menu has been edited succesfully');	
				}else{
					Log::error('The menu has not been edited');	
				}
				$this->redirect(array('menu/index'));
			}else{
				Log::warning('Menu inputs error');
				$this->render('edit',array('model'=>$model));	
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access edit menu');
				$f = Menu::model()->findByPk(Jii::param('id'));
				$model->id = $f->menu_id;
				$model->name = $f->menu_name;
				$model->status = $f->menu_status;
				$model->hook = $f->menu_hook;
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('menu/index'));
			}
		}
	}
	
	public function actionStatus(){
		Log::trace('Access change status of menu');
		$this->pageTitle = Jii::t('Change status of menu');
		$f = Menu::model()->findByPk(Jii::param('id'));
		if(isset($f->menu_id)){
			if(Menu::status()->equal('primary',Jii::param('status'))){
				$l = Menu::model()->findByAttributes(array('menu_status'=>Menu::status()->getItem('primary')->getValue(),
				'menu_hook'=>Jii::param('hook')));
				if(isset($l->menu_id)){
					$l->menu_status = Menu::status()->getItem('publish')->getValue();
					$l->save();
				}
			}
			$f->menu_status = Jii::param('status');
			if($f->save()){
				Log::success('The menu has been changed status successfully');	
			}else{
				Log::error('The menu hasnt been changed status');	
			}	
		}else{
			Log::warning('Menu not found');	
		}
		$this->redirect(array('menu/index'));	
	}
	
	public function actionDelete(){
		Log::trace('Access delete menu');
		$this->pageTitle = Jii::t('Delete Menu');
		$f = Menu::model()->findByPk(Jii::param('id'));
		if(isset($f->menu_id)){
			$res = $f->delete();
			if($res){
				Log::success('The menu has been deleted successfully');	
			}else{
				Log::error('The menu hasnt been deleted');	
			}	
		}else{
			Log::warning('Menu not found');
		}
		$this->redirect(array('menu/index'));	
	}
	
	public function actionManage(){
		if(Jii::param('id')){
			$cs=Jii::app()->clientScript;
			$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/ui.js');
			$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/jquery.mjs.nestedSortable.js');
			$criteria = new CDbCriteria;
			$criteria->addCondition('menu_id = '.Jii::param('id'));
			$criteria->with = array('field');
			$menu = Menu::model()->find($criteria);
			Log::trace('Access manage items of '.$menu->menu_name);
			$this->pageTitle = Jii::t('Manage items of').' '.$menu->menu_name;
			$this->render('manage',array('menu'=>$menu));
		}else{
			Log::warning('Request lost required arguments, please try again');
			$this->redirect(array('menu/index'));
		}	
	}
	
	public function actionSave(){
		Jii::print_r( Jii::param() );
		if(Jii::param('id') && Jii::param('menu_item')){
			$this->pageTitle = Jii::t('Save menu items');
			Log::trace('Save menu items of menu id #'.Jii::param('id'));
			// remove old items
			$olds = MenuField::model()->findAllByAttributes(array('fld_parentid'=>0,'fld_menuid'=>Jii::param('id')));
			if(!empty($olds) && is_array($olds)){
				foreach($olds AS $old){
					$old->delete();
				}
			}
			// insert new items
			$map = array();
			$map['0'] = 0;
			foreach(Jii::param('menu_item') AS $k=>$v){
				$f = new MenuField;
				$f->fld_label = $v['label'];
				$f->fld_link = $v['url'];
				$f->fld_target = $v['target'];
				$f->fld_parentid = $map[$v['parent']];
				$f->fld_position = $v['position'];
				$f->fld_status = MenuField::status()->getItem('on')->getValue();
				$f->fld_menuid = Jii::param('id');
				$res = $f->save();
				$map[$k] = $f->fld_id;
			}
			if($res){
				Log::success('The menu items has been saved successfully');
			}else{
				Log::error('The menu items has not been saved');
			}
		}else{
			Log::warning('Request lost required arguments, please try again');
		}
		$this->redirect(array('menu/manage','id'=>Jii::param('id')));
	}
	
}
?>