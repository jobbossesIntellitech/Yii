<?php
class Category extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'cms_categories';
	}
	public function relations()
	{
		return array(
					'content'=>array(self::HAS_MANY, 'Content', 'con_categoryid','together'=>false),
					'children'=>array(self::HAS_MANY, 'Category', 'cat_parentid','together'=>false),
					'category_lang'=>array(self::HAS_ONE, 'CategoryLang', 'lng_categoryid'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable Category');
			self::$status->add('disable',0x00,Jii::t('Disable'),'Disable Category');
		}
		return self::$status;	
	}
	
	public static function get($id = NULL){
		$criteria = new CDbCriteria;
		$criteria->with = array('category_lang:'.Jii::app()->language);
		if(!empty($id)){
			$criteria->addCondition('cat_id = '.$id);
		}
		$list = CHtml::listData(self::model()->findAll($criteria),'cat_id','category_lang.lng_name');
		if($id == NULL){
			return $list;
		}else{
			return isset($list[$id])?$list[$id]:'';
		}
	}
	
	public static function breadcrumb($id, $first = true){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('cat_id = '.$id);
		$criteria->with = array('category_lang:'.Jii::app()->language);
		$category = self::model()->find($criteria);
		if(isset($category->cat_id)){
			$breadcrumb .= self::breadcrumb($category->cat_parentid, false).' * ';
			if($first){
				$breadcrumb .= $category->category_lang->lng_name;	
			}else{
				$breadcrumb .= CHtml::link($category->category_lang->lng_name,Jii::app()->createUrl('category/index',array('f'=>$category->cat_id)));	
			}
		}else{
			if($first){
				$breadcrumb .= Jii::t('Root');	
			}else{
				$breadcrumb .= CHtml::link(Jii::t('Root'),Jii::app()->createUrl('category/index',array('f'=>$id)));
			}
		}
		return $breadcrumb;		
	}
	
	public static function breadcrumbpage($id, $first = true){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('cat_id = '.$id);
		$criteria->with = array('category_lang:'.Jii::app()->language);
		$category = self::model()->find($criteria);
		if(isset($category->cat_id)){
			$breadcrumb .= self::breadcrumbpage($category->cat_parentid, false);
			if($first){
				$breadcrumb .= $category->category_lang->lng_name;	
			}else{
				$breadcrumb .= CHtml::link($category->category_lang->lng_name,Jii::app()->createUrl('cms/category',array('id'=>$category->cat_id))).' * ';	
			}
		}
		return $breadcrumb;		
	}
	
	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('cat_parentid = '.$this->cat_id);
		$list = self::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();	
			}	
		}
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('lng_categoryid = '.$this->cat_id);
		$list = CategoryLang::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();	
			}	
		}
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('con_categoryid = '.$this->cat_id);
		$list = Content::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();	
			}	
		}
	}
	
	public static function tree($parent = 0, $prefix = '', $sep = ''){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('cat_parentid = '.$parent);
		$criteria->addCondition('cat_status = '.self::status()->getItem('enable')->getValue());
		$criteria->with = array('category_lang:'.Jii::app()->language);
		$data = self::model()->findAll($criteria);
		if(!empty($data) && is_array($data)){
			foreach($data AS $d){
				$list[$d->cat_id] = $prefix.$sep.$d->category_lang->lng_name;
				$list += self::tree($d->cat_id,$prefix.'|---',' ');	
			}
		}
		return $list;
	}
}
?>