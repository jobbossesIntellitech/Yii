<?php
class BrowserController extends VController
{
	public $layout = 'browser';
	public function actionCompatible(){
		$this->pageTitle = Jii::t('Browser Compatible');
		$this->render('compatible');
	}	
}
?>