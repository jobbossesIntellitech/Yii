<?php
class Controller extends CController{
	public $layout='main';
	public $data = array();
	public function init(){
		parent::init();
		if(Setting::get('maintenance','mode') == 'on' && strtolower(Jii::app()->getController()->id) != 'maintenance'){
			$this->redirect(array('maintenance/index'));
		}
		Jii::initParam();
		Jii::changeLanguage(Jii::param('lang'));
		Jii::loadTranslation();	
		Jii::app()->clientScript->scriptMap['jquery.js'] = false;
		Jii::app()->clientScript->scriptMap['jquery.min.js'] = false;
		
		/*if(!Jii::app()->user->hasState('location') && isset(Yii::app()->request->cookies['location'])){
			//Yii::app()->request->cookies['location'] = new CHttpCookie('location', Jii::app()->user->location);
			Jii::app()->user->setState('location',Yii::app()->request->cookies['location']);
		}*/
		//echo Yii::app()->request->cookies['location']->value;
		
		if(!Jii::app()->user->hasState('location')){
			if(Jii::app()->user->isGuest){
				if(isset(Yii::app()->request->cookies['location'])){
					Jii::app()->user->setState('location',Yii::app()->request->cookies['location']->value);
				}else{
					Jii::app()->user->setState('location',0);
				}
			}else{
				$member = Member::model()->findByPk(Jii::app()->user->id);
				Jii::app()->user->setState('location',$member->mbr_locationid);
			}
			//Yii::app()->request->cookies['location'] = new CHttpCookie('location', Jii::app()->user->location);
		}
	}
	protected function ajaxValidation($model){
		if(Jii::param('ajax')){
			echo CActiveForm::validate($model);
			Jii::app()->end();
		}
	}

}