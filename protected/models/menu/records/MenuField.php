<?php
class MenuField extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'menu_fields';
	}
	public function relations()
	{
		return array(
					'menu'=>array(self::BELONGS_TO,'Menu','fld_menuid'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('on',0x01,Jii::t('On'),'Item on');
			self::$status->add('off',0x00,Jii::t('Off'),'Item off');
		}
		return self::$status;	
	}
	
	private static $target = NULL;
	public static function target(){
		if(self::$target == NULL){
			self::$target = new Status();
			self::$target->add('no',0x00,Jii::t('No'),'No Target');
			self::$target->add('_blank',0x01,Jii::t('New Window (_blank)'),'New Window (_blank) Target');
			self::$target->add('_top',0x02,Jii::t('Topmost Window (_top)'),'Topmost Window (_top) Target');
			self::$target->add('_self',0x03,Jii::t('Same Window (_self)'),'Same Window (_self) Target');
			self::$target->add('_parent',0x04,Jii::t('Parent Window (_parent)'),'Parent Window (_parent) Target');
		}
		return self::$target;	
	}
	
	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('fld_parentid = '.$this->fld_id);
		$list = self::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();
			}
		}
	}
	
	public function get($id,$parent = 0){
		$list = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('fld_menuid = '.$id);
		$criteria->addCondition('fld_parentid = '.$parent);
		$list = self::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $i=>$item){
				$list[$i] = array();
				$list[$i]['label'] = $item->fld_label;
				$list[$i]['url'] = $item->fld_link;
				$list[$i]['parent'] = $item->fld_parentid;
				$list[$i]['id'] = $item->fld_id;
				$list[$i]['menu'] = $item->fld_menuid;
				$list[$i]['position'] = $item->fld_position;
				$list[$i]['target'] = $item->fld_target;
				$list[$i]['status'] = $item->fld_status;
				$list[$i]['children'] = self::get($id,$item->fld_id);
			}
		}
		return $list;
	}
}
?>