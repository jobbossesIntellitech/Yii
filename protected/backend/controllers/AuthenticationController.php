<?php
class AuthenticationController extends VController{
	public function actionIndex(){
		Log::trace('Access authentication');
		if(Jii::app()->user->isGuest){
			Log::trace('Visitor not authenticated , redirect to login form');
			$this->redirect(array('authentication/login'));		
		}else{
			Log::trace('User already signed in, redirect to dashboard page');
			$this->redirect(array('dashboard/index'));	
		}	
	}
	public function actionLogin(){
		if(Jii::app()->user->isGuest){
			$this->pageTitle = Jii::t('Authentication Panel');
			$model = new LoginForm;
			Jii::ajaxValidation($model);
			if(Jii::param('LoginForm')){
				$model->attributes = Jii::param('LoginForm');
				if($model->validate() && $model->login()){
					Log::trace('Visitor has been authenticated, redirect to dashboard page');
					$this->redirect(array('dashboard/index'));
				}else{
					Log::error('login fields not valid');
					$this->render('login',array('model'=>$model));	
				}
			}else{
				Log::trace('Display login form');
				$this->render('login',array('model'=>$model));		
			}
		}else{
			$this->redirect(array('dashboard/index'));		
		}
	}
	public function actionLogout(){
		Log::trace('User loged out');
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);	
	}		
}
?>