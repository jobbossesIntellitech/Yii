<?php
class ExceptionController extends VController{
	public $layout = "exception";
	public function actionError(){
		$this->pageTitle = Jii::t("Error");
		Log::trace('Exception page error');	
		$this->render("error");
	}
}
?>