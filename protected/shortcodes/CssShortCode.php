<?php
class CssShortCode extends JShortCode{
	
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().'][/'.$this->getName().']';
		self::$documentation[$this->getName()]['description'] = 'Write Css style';
	}
	
	public function process(){
		return '<style type="text/css">'.strip_tags($this->getContent()).'</style>';
	}
}
?>