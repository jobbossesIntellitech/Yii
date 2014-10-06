<?php
class wHelp extends CWidget{
	public $c;
	public $a;
	public $title;
	public function init(){	
		parent::init();	
		$this->registerScript();
	}
	public function run(){	
		$this->render('vHelp',array('c'=>$this->c,'a'=>$this->a,'title'=>$this->title));	
	}
	
	private function registerScript(){
		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/behave.js');	
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/countLines.js');
	}
}
?>