<?php
class JsShortCode extends JShortCode{
	
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().'][/'.$this->getName().']';
		self::$documentation[$this->getName()]['description'] = 'Write Javascript code';
	}
	
	public function process(){
		return '<script type="text/javascript">'.strip_tags($this->getContent()).'</script>';
	}
}
?>