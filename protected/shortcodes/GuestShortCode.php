<?php
class GuestShortCode extends JShortCode{
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().']...[/'.$this->getName().']';
		self::$documentation[$this->getName()]['description'] = 'Writing certain content appears only when the visitor is guest';	
	}
	
	public function process(){
		return (Jii::app()->user->isGuest)?$this->getContent():'';	
	}
}
?>