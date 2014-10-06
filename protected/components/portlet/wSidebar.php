<?php
class wSidebar extends CWidget{
	public function init(){
		parent::init();
		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/searchformbuilder/SearchFormBuilderFieldsType.js');
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/searchformbuilder/SearchFormBuilderPreview.js');
	}
	public function run(){
		$sidebar = Content::model()->findByPk('1');
		
		$this->render('vSidebar',array('sidebar'=>$sidebar));
	}

}
?>