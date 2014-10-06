<?php 
class CreateurlShortCode extends JShortCode{
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['attr']['r'] = 'controller/action';
		self::$documentation[$this->getName()]['attr']['params'] = 'params string as n1:v1,n2:v2,n3:v3,...';
		self::$documentation[$this->getName()]['attr']['url'] = 'web page url';
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().'/]';
		self::$documentation[$this->getName()]['description'] = 'create web url';	
	}
	
	public function process(){
		extract($this->fillDefault(array(
			'r'=>NULL,
			'url'=>NULL,
			'params'=>NULL,
		)));
		if($url != NULL){
			return Jii::app()->createUrl($url);
		}
		if($r != NULL){
			$p = array();
			if($params != NULL){
				$params = explode(',',$params);
				if(!empty($params) && is_array($params)){
					foreach($params AS $param){
						$pp = explode(':',$param);
						$p[$pp[0]] = isset($pp[1])?$pp[1]:'';
					}
				}
			}
			return Jii::app()->createAbsoluteUrl($r,$p);
		}
	}
}
?>