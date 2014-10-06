<?php
class Member extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'_members';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'ad'=>array(self::HAS_MANY,'Ads','ads_memberid'),
					'location'=>array(self::BELONGS_TO,'Location','mbr_locationid'),
				);	
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable Member');
			self::$status->add('disable',0x00,Jii::t('Disable'),'Disable Member');
		}
		return self::$status;	
	}
	
	private static $gender = NULL;
	public static function gender(){
		if(self::$gender == NULL){
			self::$gender = new Status();
			self::$gender->add('male',0x01,Jii::t('Male'),'Male');
			self::$gender->add('female',0x02,Jii::t('Female'),'Female');
		}
		return self::$gender;	
	}
	
	
	
	public function afterDelete(){
		parent::afterDelete();
	}

}
?>