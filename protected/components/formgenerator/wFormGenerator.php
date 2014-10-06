<?php
class wFormGenerator extends CWidget{
	public $id;
	public $title = false;
	public $type;
	public $itemid;
	
	public function init(){
		parent::init();
	}
	public function run(){
		$form = Form::get($this->id,'save');
		if(isset($form[$this->id]) && Form::status()->equal('publish',$form[$this->id]['status']) && $this->itemid == 0){
			$this->render('vFormGenerator',array('form'=>$form[$this->id]));
		}elseif($this->type == "ads"){
			$this->render('vAdsFormGenerator',array('form'=>$form[$this->id],'itemid'=>$this->itemid));
		}elseif($this->type == "edit_ads"){
			$this->render('vEditAdsFormGenerator',array('form'=>$form[$this->id],'itemid'=>$this->itemid));
		}
	}
	
	public function template($name,$args = array()){
		ob_start();
		$this->render($name,$args);
		return ob_get_clean();	
	}
}
?>