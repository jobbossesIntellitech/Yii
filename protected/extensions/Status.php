<?php
class Status{
	private $items;
	public function __construct(){
		$this->items = array();	
	}
	public function add($key,$value,$label,$comment = ''){
		$this->items[$key] = new StatusItem($key,$value,$label,$comment);
		return $this;		
	}
	public function getList( ){
		$list = array();
		if(!empty($this->items) && is_array($this->items)){
			foreach($this->items AS $item){
				$list[$item->getValue()] = $item->getLabel();		
			}	
		}
		return $list;	
	}
	public function getItems( ){
		return (count($this->items) > 0)?$this->items:false;	
	}
	public function getItem( $k ){
		return isset($this->items[$k])?$this->items[$k]:false;			
	}
	public function getLabelByValue($v){
		$list = $this->getList();
		return isset($list[$v])?$list[$v]:'';
	}
	public function getKeyByValue($v){
		if(!empty($this->items) && is_array($this->items)){
			foreach($this->items AS $k=>$item){
				if($item->getValue() == $v){
					return $k;
				}
			}
		}
		return false;
	}

	public function equal( $k,$v ){
		$me = $this->getItem( $k );
		return ( $me->getValue() == $v );	
	}	
}

class StatusItem{
	
	private $_key;
	private $_value;
	private $_label;
	private $_comment;
	
	public function __construct($key,$value,$label,$comment = ''){
		$this->_key = $key;
		$this->_value = $value;
		$this->_label = $label;	
		$this->_comment = $comment;
	}
	
	public function getKey(){
		return $this->_key;	
	}
	
	public function getValue(){
		return $this->_value;	
	}
	
	public function getLabel(){
		return $this->_label;	
	}
	
	public function getComment(){
		return $this->_comment;	
	}
		
}
?>