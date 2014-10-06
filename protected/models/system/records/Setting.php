<?php
class Setting extends JActiveRecord{
	
	private static $list = NULL;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'sys_settings';
	}
	
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	
	private static $section = NULL;
	public static function section(){
		if(self::$section == NULL){
			self::$section = new Status();
			$criteria = new CDbCriteria;
			$criteria->group = 'set_section';
			$data = self::model()->findAll($criteria);
			if(!empty($data) && is_array($data)){
				foreach($data AS $d){
					self::$section->add($d->set_section,$d->set_section,Jii::t($d->set_section),$d->set_section.' Section');		
				}
			}
		}
		return self::$section;	
	}
	public static function get($section = NULL,$key = NULL){
		if(self::$list == NULL){
			self::$list = array();
			$data = self::model()->findAll();
			if(!empty($data) && is_array($data)){
				foreach($data AS $d){
					if(!isset(self::$list[$d->set_section])){ $list[$d->set_section] = array(); }
					self::$list[$d->set_section][$d->set_key] = $d->set_value;
				}
			}
		}
		if($section == NULL && $key == NULL){
			return self::$list;	
		}else if($section != NULL && $key == NULL){
			return isset(self::$list[$section])?self::$list[$section]:array();
		}else{
			return (isset(self::$list[$section][$key]))?self::$list[$section][$key]:NULL;	
		}		
	}
}
?> 