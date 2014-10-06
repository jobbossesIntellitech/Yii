<?php
class LocationController extends SController{
	public $family;
	public function init(){
		parent::init();
		$this->family = 0;
		if(Jii::param('f') && Jii::param('f') > 0){
			$this->family = Jii::param('f');
		}
	}

	public function actionIndex(){
		if(Jii::isAjax()){
			$criteria = new JDbGridView();
			$criteria->addCondition('loc_parentid = '.$this->family);
			echo $criteria->execute($this,'Location',array('f'=>$this->family,'uws'=>Jii::param('uws')),'list');
		}else{
			$this->pageTitle = Jii::t('Locations');
			Log::trace('Access Locations');
			$this->render('index');
		}
	}

	public function actionAdd(){
		$this->pageTitle = Jii::t('Add New Location');
		$model = new LocationForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = new Location;
				$c->loc_name = $model->name;
				$c->loc_status = $model->status;
				$c->loc_parentid = $model->parentid;
				$c->loc_type = $model->type;
				$c->loc_logo = isset($model->logo[0])?$model->logo[0]:Jii::notfound();
				$c->loc_priority = $model->priority;
				$c->loc_position = $model->position;
				$c->loc_translate = json_encode($model->translate);
				$res = $c->save();
				Log::trace('Save new location record');
				if($res){
					Log::success('The location has been added successfully');	
				}else{
					Log::success('The location hasnt been added');	
				}
				$this->redirect(array('location/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
			}else{
				Log::warning('Location form inputs error');
				$this->render('add',array('model'=>$model,'uws'=>Jii::param('uws')));		
			}
		}else{
			Log::trace('Access location form');
			$model->parentid = $this->family;
			$this->render('add',array('model'=>$model));	
		}
	}

	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit Location');
		$model = new LocationForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = Location::model()->findByPk($model->id);
				$c->loc_name = $model->name;
				$c->loc_status = $model->status;
				$c->loc_parentid = $model->parentid;
				$c->loc_type = $model->type;
				$c->loc_logo = isset($model->logo[0])?$model->logo[0]:Jii::notfound();
				$c->loc_priority = $model->priority;
				$c->loc_position = $model->position;
				$c->loc_translate = json_encode($model->translate);
				$res = $c->save();
				Log::trace('Saved location record');
				if($res){
					Log::success('The location has been edited successfully');	
				}else{
					Log::success('The location hasnt been edited');	
				}
				$this->redirect(array('location/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
			}else{
				Log::warning('Location form inputs error');
				$this->render('edit',array('model'=>$model));		
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access location form');
				$c = Location::model()->findByPk(Jii::param('id'));
				$model->id = $c->loc_id;
				$model->name = $c->loc_name;
				$model->status = $c->loc_status;
				$model->parentid = $c->loc_parentid;
				$model->type = $c->loc_type;
				$model->types = $c->loc_type;
				$model->logo = array($c->loc_logo);
				$model->priority = $c->loc_priority;
				$model->position = $c->loc_position;
				$model->translate = (array)json_decode($c->loc_translate);
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('location/index','f'=>$this->family,'uws'=>Jii::param('uws')));		
			}	
		}
	}

	public function actionDelete(){
		Log::trace('Access delete location');
		$this->pageTitle = Jii::t('Delete Location');
		$c = Location::model()->findByPk(Jii::param('id'));
		if(isset($c->loc_id)){
			$res = $c->delete();
			if($res){
				Log::success('The location has been deleted successfully');	
			}else{
				Log::error('The location hasnt been deleted');	
			}	
		}else{
			Log::warning('Location not found');	
		}
		$this->redirect(array('location/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
	}

	public function actionStatus(){
		Log::trace('Access change status of location');
		$this->pageTitle = Jii::t('Change status of location');
		$c = Location::model()->findByPk(Jii::param('id'));
		if(isset($c->loc_id)){
			$c->loc_status = Jii::param('status');
			$res = $c->save();
			if($res){
				Log::success('The location has been changed status successfully');	
			}else{
				Log::error('The location hasnt been changed status');	
			}	
		}else{
			Log::warning('Location not found');	
		}
		$this->redirect(array('location/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
	}
	
}
?>