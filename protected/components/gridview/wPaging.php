<?php
class wPaging extends CWidget{
	
	public $pages;
	
	public function init(){
		
		parent::init();
		
		
	}
	
	public function run(){
		
		$this->render('paging');
		
	}
	
	
	
}
?>