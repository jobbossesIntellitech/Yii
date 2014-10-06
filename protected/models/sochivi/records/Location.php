<?php
class Location extends JActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'_locations';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'ad'=>array(self::HAS_MANY,'Ad','ads_locationid'),
					'locationitem'=>array(self::HAS_MANY,'LocationItem','lit_locationid'),
					'member'=>array(self::HAS_MANY,'Member','mbr_locationid'),
					'children'=>array(self::HAS_MANY,'Location','loc_parentid')
				);	
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable Location');
			self::$status->add('disable',0x00,Jii::t('Disable'),'Disable Location');
		}
		return self::$status;	
	}
	
	private static $type = NULL;
	public static function type(){
		if(self::$type == NULL){
			self::$type = new Status();
			$criteria = new CDbCriteria;
			$criteria->group = 'loc_type';
			$data = self::model()->findAll($criteria);
			if(!empty($data) && is_array($data)){
				foreach($data AS $d){
					self::$type->add(strtolower($d->loc_type),$d->loc_type,Jii::t($d->loc_type),$d->loc_type.' Type');		
				}
			}
		}
		return self::$type;	
	}
	
	public static function get($id = NULL){
		$criteria = new CDbCriteria;
		if(!empty($id)){
			$criteria->addCondition('loc_id = '.$id);
		}
		$list = CHtml::listData(self::model()->findAll($criteria),'loc_id','loc_name');
		if($id == NULL){
			return $list;
		}else{
			return isset($list[$id])?$list[$id]:'';
		}
	}
	
	public static function getCountry($id = NULL){
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_parentid = 0');
		$criteria->order = 'loc_name ASC';
		$criteria->addCondition('loc_status = '.self::status()->getItem('enable')->getValue());
		if(!empty($id)){
			$criteria->addCondition('loc_id = '.$id);
		}
		$list = CHtml::listData(self::model()->findAll($criteria),'loc_id','loc_name');
		if($id == NULL){
			return $list;
		}else{
			return isset($list[$id])?$list[$id]:'';
		}
	}
	
	public static function breadcrumb($id, $first = true){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_id = '.$id);
		$location = self::model()->find($criteria);
		if(isset($location->loc_id)){
			$breadcrumb .= self::breadcrumb($location->loc_parentid, false).' * ';
			if($first){
				$breadcrumb .= $location->loc_name;	
			}else{
				$breadcrumb .= CHtml::link($location->loc_name,Jii::app()->createUrl('location/index',array('f'=>$location->loc_id)));	
			}
		}else{
			if($first){
				$breadcrumb .= Jii::t('Root');	
			}else{
				$breadcrumb .= CHtml::link(Jii::t('Root'),Jii::app()->createUrl('location/index',array('f'=>$id)));
			}
		}
		return $breadcrumb;		
	}
	
	public static function breadcrumblocation($id, $first = true, $map = ''){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_id = '.$id);
		$location = self::model()->find($criteria);
		if(isset($location->loc_id)){
			$breadcrumb .= self::breadcrumblocation($location->loc_parentid, false, $map);
			if($first){
				$breadcrumb .= $location->loc_name;
				if(!empty($map)){
					$val = explode(',',$map);
					$breadcrumb .= '  ('.CHtml::link('Locate map','https://maps.google.com.lb/maps?q='.$val[0].','.$val[1],array('target'=>'_blank','class'=>'googlemap_link')).')';	
				}
			}else{
				//$breadcrumb .= CHtml::link($location->loc_name,Jii::app()->createUrl('location/index',array('f'=>$location->loc_id))).' > ';
				$breadcrumb .= $location->loc_name.' > ';				
			}
		}else{
			if($first){
				//$breadcrumb .= Jii::t('Root');	
			}else{
				//$breadcrumb .= CHtml::link(Jii::t('Root'),Jii::app()->createUrl('location/index',array('f'=>$id)));
			}
		}
		return $breadcrumb;		
	}

	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_parentid = '.$this->loc_id);
		$list = self::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();	
			}	
		}
	}
	
	public static function tree($parent = 0, $prefix = '', $sep = ''){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_parentid = '.$parent);
		$criteria->addCondition('loc_status = '.self::status()->getItem('enable')->getValue());
		$data = self::model()->findAll($criteria);
		if(!empty($data) && is_array($data)){
			foreach($data AS $d){
				$list[$d->loc_id] = $prefix.$sep.$d->loc_name;
				$list += self::tree($d->loc_id,$prefix.'|---',' ');	
			}
		}
		return $list;
	}
	
	private static $sublevel = 1;
	public static function getSubcountry($parent = 0, $prefix = '', $sep = '', $level){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_parentid = '.$parent);
		$criteria->addCondition('loc_status = '.self::status()->getItem('enable')->getValue());
		$data = self::model()->findAll($criteria);
		if(!empty($data) && is_array($data) && $level <= self::$sublevel){
			foreach($data AS $d){
				$list[$d->loc_id] = $prefix.$sep.$d->loc_name;
				$list += self::getSubcountry($d->loc_id,$prefix.'|---',' ', $level = $level+1);	
			}
		}
		return $list;
	}
	
	public static function getchildren($parent = 0){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_parentid = '.$parent);
		$criteria->addCondition('loc_status = '.self::status()->getItem('enable')->getValue());
		$data = self::model()->findAll($criteria);
		if(!empty($data) && is_array($data)){
			foreach($data AS $d){
				$list[$d->loc_id] = $d->loc_id;
				$list += self::getchildren($d->loc_id);	
			}
		}
		return $list;
	}
	
	public static function completelocation($locations, $idp = -1){
		if($idp > -1 ){
			$res = '';
		}else{
			$res = array();
		}
		if(!empty($locations) && is_array($locations)){
			foreach($locations as $location){
				if($idp > -1 && $idp == $location->loc_id){
					$res .= self::completelocation($locations, $location->loc_parentid);
					if(!empty($res)){
						$res .= ', '.$location->loc_name;
					}else{
						$res = $location->loc_name;
					}
					
				}else
				if($idp == -1){
					$res[$location->loc_id] = self::completelocation($locations, $location->loc_parentid);
					if(!empty($res[$location->loc_id])){
						$res[$location->loc_id] .= ', '.$location->loc_name;
					}else{
						$res[$location->loc_id] = $location->loc_name;
					}
				}
			}
		}
		return $res;
	}
}
?>


