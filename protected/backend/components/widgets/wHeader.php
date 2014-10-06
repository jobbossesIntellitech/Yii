<?php
class wHeader extends CWidget{
	public $language;
	public function init(){	
		parent::init();	
	}
	public function run(){	
		$this->render('vHeader');	
	}
}
?>