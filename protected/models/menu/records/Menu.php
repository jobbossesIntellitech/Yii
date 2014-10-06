<?php
class Menu extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'menu_menus';
	}
	public function relations()
	{
		return array(
					'field'=>array(self::HAS_MANY,'MenuField','fld_menuid'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('draft',0x00,Jii::t('Draft'),'Draft Menu');
			self::$status->add('publish',0x01,Jii::t('Publish'),'Publish Menu');
			self::$status->add('primary',0x02,Jii::t('Primary'),'Primary Menu');
			self::$status->add('delete',0x03,Jii::t('Delete'),'Delete Menu');
		}
		return self::$status;	
	}
	
	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('fld_menuid = '.$this->menu_id);
		$list = MenuField::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();
			}
		}
	}
	
	public static function hook(){
		$hook = Setting::get('menu','hook');
		$list = array('main'=>'Main');
		if(!empty($hook)){
			$list = array();
			$hook = explode(',',$hook);
			if(!empty($hook) && is_array($hook)){
				foreach($hook AS $h){
					$list[$h] = ucfirst($h);
				}
			}
		}
		return $list;	
	}
	
	public static function get($hook = 'main',$status = 'primary'){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('menu_hook = "'.$hook.'"');
		$criteria->addCondition('menu_status = '.self::status()->getItem($status)->getValue());
		$menu = self::model()->find($criteria);
		if(isset($menu->menu_id)){
			$list['name'] = $menu->menu_name;
			$list['hook'] = $menu->menu_hook;
			$list['id'] = $menu->menu_id;
			$list['status'] = $menu->menu_status;
			$list['items'] = MenuField::get($menu->menu_id);	
		}
		return $list;
	} 
}
?>