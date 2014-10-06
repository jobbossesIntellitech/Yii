<?php
class wEnd extends  CWidget{
	
	public $pages;
	
	public function init(){
		
		parent::init();
		
		
	}
	
	public function run(){
		
		$this->render('end');
		
	}
	
	
	
}
?>