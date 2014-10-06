<?php
class DateShortCode extends JShortCode{
	
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['attr']['format']='Php date format d:day of month, Y : year, ....';
		self::$documentation[$this->getName()]['attr']['time']='Time to display as format : YYYY-MM-DD HH:MM:SS';
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().' attributes(name="value" ...)/]';
		self::$documentation[$this->getName()]['description'] = 'Display date';
	}
	
	public function process(){
		extract($this->fillDefault(array(
			'format'=>'Y-m-d H:i:s',
			'time'=>date('Y-m-d H:i:s'),
		)));
		return date($format,strtotime($time));
	}	
}
?>