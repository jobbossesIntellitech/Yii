<?php
class Favorite extends JActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'_favorites';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'ads'=>array(self::BELONGS_TO,'Ads','fav_adid'),
					'member'=>array(self::BELONGS_TO,'Member','fav_memberid'),
				);	
	}
	
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('draft',0x00,Jii::t('Disable'),'Disable Fav');
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable Fav');
		}
		return self::$status;	
	}
}
?>