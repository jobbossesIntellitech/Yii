<?php
class DashboardController extends SController{
	public function actionIndex(){
		$this->pageTitle = Jii::t('Dashboard');
		Log::trace('Access Dashboard');
		$cs = Jii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/ui.js');
		$this->render('index');
	}
	public function actionChangeLanguage(){
		$l = Language::model()->findByPk(Jii::app()->language);
		Jii::app()->user->setState('direction',$l->lng_direction);
		Jii::app()->user->setState('language',$l->lng_id);
		Log::success('change language');
		$this->redirect(Jii::app()->getRequest()->urlReferrer);	
	}
	public function actionChangeColor(){
		$user = User::model()->findByPk(Jii::app()->user->id);
		$user->usr_color = Jii::app()->user->color;
		$user->save();
		Log::success('change theme color');
	   	$this->redirect(Yii::app()->getRequest()->urlReferrer);	
	}
	
	public function actionSaveUserCookie(){
		if(Jii::isAjax()){
			Log::trace('Save User Cookie Access');
			echo UserCookie::set(Jii::param('k'),Jii::param('v'));
		}else{
			Log::trace('Save User Cookie Access Without Ajax Call, so redirect to referrer url');
			$this->redirect(Jii::app()->getRequest()->urlReferrer);
		}
	}
	
	public function actionSaveUserCookies(){
		if(Jii::isAjax()){
			Log::trace('Save User Cookies Access');
			return UserCookie::sets(Jii::param('data'));
		}else{
			Log::trace('Save User Cookies Access Without Ajax Call, so redirect to referrer url');
			$this->redirect(Jii::app()->getRequest()->urlReferrer);
		}
	}
}
?>