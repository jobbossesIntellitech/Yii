<?php 
class BaseurlShortCode extends JShortCode{
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().'/]';
		self::$documentation[$this->getName()]['description'] = 'web app url';	
	}
	
	public function process(){
		return Jii::app()->getBaseUrl(true);	
	}
}
?>