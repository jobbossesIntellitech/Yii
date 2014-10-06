<?php
class Item extends JActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'_items';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'field'=>array(self::HAS_MANY,'ItemField','ifl_itemid'),
					'locationitem'=>array(self::HAS_MANY,'LocationItem','lit_itemid'),
					'form'=>array(self::BELONGS_TO,'Form','itm_formid'),
					'adscount' => array(self::STAT,'Ads','ads_itemid')
				);	
	}

	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable Item');
			self::$status->add('disable',0x00,Jii::t('Disable'),'Disable Item');
		}
		return self::$status;	
	}
	
	private static $type = NULL;
	public static function type(){
		if(self::$type == NULL){
			self::$type = new Status();
			self::$type->add('item',0x01,Jii::t('Item'),'Item');
			self::$type->add('category',0x00,Jii::t('Category'),'Category');
		}
		return self::$type;	
	}

	public static function breadcrumb($id, $first = true){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('itm_id = '.$id);
		$item = self::model()->find($criteria);
		if(isset($item->itm_id)){
			$breadcrumb .= self::breadcrumb($item->itm_parentid, false).' * ';
			if($first){
				$breadcrumb .= $item->itm_name;	
			}else{
				$breadcrumb .= CHtml::link($item->itm_name,Jii::app()->createUrl('item/index',array('f'=>$item->itm_id)));	
			}
		}else{
			if($first){
				$breadcrumb .= Jii::t('Root');	
			}else{
				$breadcrumb .= CHtml::link(Jii::t('Root'),Jii::app()->createUrl('item/index',array('f'=>$id)));
			}
		}
		return $breadcrumb;		
	}
	
	public static function breadcrumbitem($id, $first = true){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('itm_id = '.$id);
		$item = self::model()->find($criteria);
		if(isset($item->itm_id)){
			$breadcrumb .= self::breadcrumbitem($item->itm_parentid, false);
			if($first){
				$breadcrumb .= $item->itm_name;	
			}else{
				//$breadcrumb .= CHtml::link($item->itm_name,Jii::app()->createUrl('item/index',array('f'=>$item->itm_id)));	
				$breadcrumb .= $item->itm_name.' > ';
			}
		}else{
			if($first){
				//$breadcrumb .= Jii::t('Root');	
			}else{
				//$breadcrumb .= CHtml::link(Jii::t('Root'),Jii::app()->createUrl('item/index',array('f'=>$id)));
			}
		}
		return $breadcrumb;		
	}
	
	public static function tree($parent = 0, $prefix = '', $sep = '', $level = 0){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('itm_parentid = '.$parent);
		$criteria->addCondition('itm_status = '.self::status()->getItem('enable')->getValue());
		$data = self::model()->findAll($criteria);
		if(!empty($data) && is_array($data)){
			foreach($data AS $d){
				$list[$d->itm_id] = $prefix.$sep.$d->itm_name;
				if($level == 0) $list += self::tree($d->itm_id,$prefix.'|---',' ');	
			}
		}
		return $list;
	}
	
	public static function detect_items($parentid,$tab,$index){
		$criteria = new CDbCriteria;
		$criteria->addCondition('itm_parentid = '.$parentid);
		$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
		$subcat = Item::model()->findAll($criteria);
		if(!empty($subcat) && is_array($subcat)){
			foreach($subcat as $sub){
				$tab = array_unique(array_merge($tab,self::detect_items($sub->itm_id,$tab,$index++)));
			}
		}else{
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_itemid = '.$parentid);
			$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
			$ads = Ads::model()->findAll($criteria);
			
			if(!empty($ads) && is_array($ads)){
				foreach($ads as $a){
					$tab[$index] = $a->ads_id;
					//echo $index.',';
					$index++;
				}
			}
		}
		//Jii::print_r($tab);
		return $tab;
	}
	
	public static function getchildren($parent = 0){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('itm_parentid = '.$parent);
		$criteria->addCondition('itm_status = '.self::status()->getItem('enable')->getValue());
		$data = self::model()->findAll($criteria);
		if(!empty($data) && is_array($data)){
			foreach($data AS $d){
				$list[$d->itm_id] = $d->itm_id;
				$list += self::getchildren($d->itm_id);	
			}
		}
		return $list;
	}
	
	public static function urlOptions($id, $title,$foreTitle = false,$isMenu = false){
		$title = str_replace(array(' ','/','#','!','@','$','%','^','&','*','(',')','[',']','{','}','\\','.'),'_',$title);
		$list = array();
		$list['itemid'] = $id;
		$find = false;
		$last = '';
		if(Jii::param('_l1') && !$isMenu){
			$list['_l1'] = Jii::param('_l1');
			$last = '_l1';
		}else{
			if(!$find && !empty($title)){
				$list['_l1'] = $title;
				$find = true;
			}
		}
		
		if(Jii::param('_l2') && !$isMenu){
			$list['_l2'] = Jii::param('_l2');
			$last = '_l2';
		}else{
			if(!$find && !empty($title)){
				$list['_l2'] = $title;
				$find = true;
			}
		}
		
		if(Jii::param('_l3') && !$isMenu){
			$list['_l3'] = Jii::param('_l3');
			$last = '_l3';
		}else{
			if(!$find && !empty($title)){
				$list['_l3'] = $title;
				$find = true;
			}
		}
		
		if(Jii::param('_l4') && !$isMenu){
			$list['_l4'] = Jii::param('_l4');
			$last = '_l4';
		}else{
			if(!$find && !empty($title)){
				$list['_l4'] = $title;
				$find = true;
			}
		}
		if(!empty($last) && $foreTitle){
			$list[$last] = $title;
		}
		
		return $list;
	}
}
?>