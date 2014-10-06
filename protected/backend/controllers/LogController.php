<?php
class LogController extends SController{
	
	public function actionIndex(){
		if(Jii::isAjax()){
			$criteria = new JDbGridView;
			$criteria->addCondition("log_userid = ".Yii::app()->user->id);
			echo $criteria->execute($this,'Log',array(),'list');
		}else{
			$this->pageTitle = Jii::t("Logs");
			$this->render("index");
		}	
	}
			
}
?>