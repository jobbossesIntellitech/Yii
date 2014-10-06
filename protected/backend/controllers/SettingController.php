<?php
class SettingController extends SController{
	
	public function actionIndex(){
		if(Jii::isAjax()){
			Log::trace('Access Settings List');
			$criteria = new JDbGridView;
			echo $criteria->execute($this,'Setting',array(),'list');	
		}else{
			Log::trace('Access Settings Page');
			$this->pageTitle = Jii::t('Settings');
			$this->render('index');
		}
	}
	
	public function actionAdd(){
		$this->pageTitle = Jii::t('Add new setting');
		$model = new SettingForm;
		$model->setScenario('create');
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$s = new Setting;
				$s->set_key = $model->key;
				$s->set_value = $model->value;
				$s->set_options = $model->options;
				$s->set_section = str_replace('-','_',Jii::slug($model->section));
				$res = $s->save();
				Log::trace('Save new setting record');
				if($res){
					Log::success('The setting has been added successfully');	
				}else{
					Log::success('The setting hasnt been added');	
				}
				$this->redirect(array('setting/index'));	
			}else{
				Log::warning('Setting form inputs error');
				$this->render('add',array('model'=>$model));		
			}
		}else{
			Log::trace('Access setting form');
			$this->render('add',array('model'=>$model));	
		}
	}
	
	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit setting');
		$model = new SettingForm;
		$model->setScenario('update');
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$s = Setting::model()->findByPk($model->id);
				$s->set_key = $model->key;
				$s->set_value = $model->value;
				$s->set_options = $model->options;
				$s->set_section = str_replace('-','_',Jii::slug($model->section));
				$res = $s->save();
				Log::trace('Save setting record');
				if($res){
					Log::success('The setting has been edited successfully');	
				}else{
					Log::success('The setting hasnt been edited');	
				}
				$this->redirect(array('setting/index'));	
			}else{
				Log::warning('Setting form inputs error');
				$this->render('edit',array('model'=>$model));		
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access setting form');
				$s = Setting::model()->findByPk(Jii::param('id'));
				$model->id = $s->set_id;
				$model->key = $s->set_key;
				$model->value = $s->set_value;
				$model->options = $s->set_options;
				$model->section = $s->set_section;
				$model->sections = $s->set_section;
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('setting/index'));
			}	
		}
	}
	
	public function actionDelete(){
		Log::trace('Access delete setting');
		$this->pageTitle = Jii::t('Delete Setting');
		$s = Setting::model()->findByPk(Jii::param('id'));
		if(isset($s->set_id)){
			$res = $s->delete();
			if($res){
				Log::success('The setting has been deleted successfully');	
			}else{
				Log::error('The setting hasnt been deleted');	
			}	
		}else{
			Log::warning('Setting not found');	
		}
		$this->redirect(array('setting/index'));
	}
	
}
?>