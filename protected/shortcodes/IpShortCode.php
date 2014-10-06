<?php
class IpShortCode extends JShortCode{
	
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().' /]';
		self::$documentation[$this->getName()]['description'] = 'Write Client IP';
	}
	
	public function process(){
		return $_SERVER['REMOTE_ADDR'];
	}
}
?>