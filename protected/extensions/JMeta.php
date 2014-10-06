<?php 
class JMeta extends CComponent{
	
	private $title;
	private $keywords;
	private $description;
	
	private static $self = NULL;
	
	private function __construct($title,$keywords = '',$description = ''){
		$this->title = substr($title.' | '.Setting::get('meta','title'),0,70);
		$this->keywords = substr($keywords.', '.Setting::get('meta','keywords'),0,120);
		$this->description = substr($description.', '.Setting::get('meta','description'),0,159);
	}
	
	public static function set($title,$keywords = '',$description = ''){
		if(self::$self == NULL){
			self::$self = new self($title,$keywords,$description);
		}
		return self::$self;
	}
	
	public static function title(){
		return isset(self::$self->title)?self::$self->title:Setting::get('meta','title');
	}
	
	public static function keywords(){
		return isset(self::$self->keywords)?self::$self->keywords:Setting::get('meta','keywords');
	}
	
	public static function description(){
		return isset(self::$self->description)?self::$self->description:Setting::get('meta','description');
	}
	
}