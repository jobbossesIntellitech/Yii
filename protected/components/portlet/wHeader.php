<?php
class wHeader extends CWidget{
	public $country = 0;
	public $city = 0;
	public function init(){
		parent::init();
	}
	public function run(){
		$header_ads = Content::model()->findByPk('2');
		
		if(Jii::app()->user->isGuest){
			//$this->pageTitle = Jii::t('Authentication Panel');
			$model = new LoginForm;
			Jii::ajaxValidation($model);
			if(Jii::param('LoginForm')){
				$model->attributes = Jii::param('LoginForm');
				if($model->validate() && $model->login()){
					Log::success('Visitor has been authenticated, redirect to home page');
					//$this->redirect(array('web/index'));
					$this->render('vHeader',array('model'=>$model,'header_ads'=>$header_ads,'country'=>$this->country));
					header('Location:'.Jii::app()->createUrl('web/index'));
				}else{
					Log::error('login fields not valid');
					$this->render('vHeader',array('model'=>$model,'header_ads'=>$header_ads,'country'=>$this->country));	
				}
			}else{
				Log::trace('Display login form');
				$this->render('vHeader',array('model'=>$model,'header_ads'=>$header_ads,'country'=>$this->country));		
			}
		}else{
			//$this->render('index',array());		
			$this->render('vHeader',array('header_ads'=>$header_ads,'country'=>$this->country));
		}
		
		//$this->render('vHeader',array('header_ads'=>$header_ads));
	}

}
?>