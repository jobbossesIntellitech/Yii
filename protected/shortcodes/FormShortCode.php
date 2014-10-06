<?php
class FormShortCode extends JShortCode{
	
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['attr']['id']='form generator id(1|2|...)';
		self::$documentation[$this->getName()]['attr']['title']='Display form title 1:yes | 0:no';
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().' attributes(name="value" ...)/]';
		self::$documentation[$this->getName()]['description'] = 'Display form generator';
	}
	
	public function process(){
		extract($this->fillDefault(array(
			'id'=>NULL,
			'title'=>false,
			'itemid'=>null,
			'type'=>false,
		)));
		if(!empty($id)){
			$controller = Jii::app()->getController();
			return $controller->widget('wFormGenerator',array('id'=>$id,'title'=>$title,'itemid'=>$itemid,'type'=>$type),true);
		}
		return '';
	}
	
}
?>