<?php
class LanguageController extends SController{
	
	public function actionIndex(){
		if(Jii::isAjax()){
			Log::trace('Access Languages List');
			$criteria = new JDbGridView;
			echo $criteria->execute($this,'Language',array(),'list');	
		}else{
			Log::trace('Access Languages Page');
			$this->pageTitle = Jii::t('Manage Languages');
			$this->render('index');	
		}		
	}
	
	public function actionAdd(){
		$this->pageTitle = Jii::t('Add new language');
		$model = new LanguageForm;
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$l = new Language;
				$l->lng_iso = $model->iso;
				$l->lng_name = $model->name;
				$l->lng_status = $model->status;
				$l->lng_direction = $model->direction;
				$res = $l->save();
				Log::trace('Save new language record');
				if($res){
					Log::success('The language has been added successfully');	
				}else{
					Log::success('The language hasnt been added');	
				}
				$this->redirect(array('language/index'));	
			}else{
				Log::warning('Language form inputs error');
				$this->render('add',array('model'=>$model));		
			}
		}else{
			Log::trace('Access language form');
			$this->render('add',array('model'=>$model));	
		}
	}
	
	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit language');
		$model = new LanguageForm;
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$l = Language::model()->findByPk($model->id);
				$l->lng_iso = $model->iso;
				$l->lng_name = $model->name;
				$l->lng_status = $model->status;
				$l->lng_direction = $model->direction;
				$res = $l->save();
				Log::trace('Save language record');
				if($res){
					Log::success('The language has been edited successfully');	
				}else{
					Log::success('The language hasnt been edited');	
				}
				$this->redirect(array('language/index'));	
			}else{
				Log::warning('Language form inputs error');
				$this->render('edit',array('model'=>$model));		
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access language form');
				$l = Language::model()->findByPk(Jii::param('id'));
				$model->id = $l->lng_id;
				$model->iso = $l->lng_iso;
				$model->name = $l->lng_name;
				$model->status = $l->lng_status;
				$model->direction = $l->lng_direction;
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('language/index'));	
			}
		}	
	}
	
	public function actionDelete(){
		Log::trace('Access delete langauge');
		$this->pageTitle = Jii::t('Delete Language');
		$l = Language::model()->findByPk(Jii::param('id'));
		if(isset($l->lng_id)){
			$res = $l->delete();
			if($res){
				Log::success('The language has been deleted successfully');	
			}else{
				Log::error('The language hasnt been deleted');	
			}	
		}else{
			Log::warning('Language not found');	
		}
		$this->redirect(array('language/index'));		
	}
	
	public function actionStatus(){
		Log::trace('Access change status of language');
		$this->pageTitle = Jii::t('Change status of language');
		$l = Language::model()->findByPk(Jii::param('id'));
		if(isset($l->lng_id)){
			$l->lng_status = Jii::param('status');
			$res = $l->save();
			if($res){
				Log::success('The language has been changed status successfully');	
			}else{
				Log::error('The language hasnt been changed status');	
			}	
		}else{
			Log::warning('Language not found');	
		}
		$this->redirect(array('language/index'));	
	}
			
}
?>