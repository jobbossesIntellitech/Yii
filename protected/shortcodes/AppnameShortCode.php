<?php 
class AppnameShortCode extends JShortCode{
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().'/]';
		self::$documentation[$this->getName()]['description'] = 'app name';	
	}
	
	public function process(){
		return Jii::app()->name;	
	}
}
?>