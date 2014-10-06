<?php
class wBegin extends CWidget{
	
	public $headers;
	
	public function init(){
		
		parent::init();
		
		
	}
	
	public function run(){
		
		$this->render('begin');
		
	}
	
	
	
}
?>