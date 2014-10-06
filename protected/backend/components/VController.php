<?php
class VController extends CController{
	public $layout = 'authentication';
	public function init(){
		parent::init();
		Jii::app()->clientScript->scriptMap['jquery.js'] = false;
		Jii::app()->clientScript->scriptMap['jquery.min.js'] = false;
		if(!Jii::valideBrowser() && strtolower(Jii::app()->getController()->id) != 'browser'){
			$this->redirect(array('browser/compatible'));
		}
		if(!isset($_GET['uws']) || !isset($_POST['uws'])){
			$_GET['uws'] = md5(Jii::app()->baseUrl);
		}
		Jii::initParam();
		Jii::changeLanguage(Jii::param('lang'));
		Jii::changeColor(Jii::param('color'));
		Jii::loadTranslation();	
	}
	protected function ajaxValidation($model){
		if(Jii::param('ajax')){
			echo CActiveForm::validate($model);
			Jii::app()->end();
		}
	}
			
}
?>