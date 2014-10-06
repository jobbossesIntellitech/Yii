<?php
class wGridView extends  CWidget{
	
	public $ID = '';
	public $baseUrl;
	public $parameters;
	public $headers;
	public $pageSize = 10;
	public $orderBy;
	public $orderPosition;
	
	public function init(){
		
		parent::init();
		
		
	}
	
	public function run(){
		
		$this->ID = $this->generateKey();
		
		$this->registrationScript();
		
		$this->render('gridView',array());
		
	}
	
	public function registrationScript(){
		
		$cs=Yii::app()->clientScript;
		
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/js/b/gridview.js');

	}
	
	private function generateKey(){
		
		$k = '';
		
		$min = rand(65,75);
		$max = rand(76,90);
		
		for($i=$min; $i<=$max; $i++){
			
			$j = rand(rand($min,$i),rand($i,$max));
			
			$k.= chr($j);
			
		}
		
		return 'JS'.strtolower($k).'CODEnDOT';
		
	}
	
}
?>