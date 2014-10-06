<?php
class wTreeAdminUsers extends CWidget{
	public $dashboard;
	public function init(){	
		parent::init();	
	}
	public function run(){
		$list = User::getArrayAsTree();
		$this->render('vTreeAdminUsers',array('list'=>$list));	
	}
}
?>