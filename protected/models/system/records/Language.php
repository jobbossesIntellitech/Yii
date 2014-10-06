<?php
class Language extends JActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'sys_languages';
	}
	
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	
	public static function get($k = NULL)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('lng_status = '.self::status()->getItem('enable')->getValue());
		$list = CHtml::listData(Language::model()->findAll($criteria),'lng_id','lng_name');
		if($k == NULL)
		{
			return $list;	
		}
		else
		{
			return (isset($list[$k]))?$list[$k]:'-undefined-';	
		}
	}
	
	public static function without($lang = NULL)
	{
		if($lang == NULL){ $lang = Jii::app()->language; }
		$languages = self::get();
		if(!empty($languages) && is_array($languages)){
			foreach($languages AS $k=>$v){
				if($k == $lang){
					unset($languages[$k]);
				}
			}
		}
		return $languages;
	}
	
	public static function isRTL($id)
	{
		$language = self::model()->findByPk($id);
		return ($language->lng_direction == 'rtl');
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable User');
			self::$status->add('disable',0x00,Jii::t('Disable'),'Disable User');
		}
		return self::$status;	
	}
	
	private static $direction = NULL;
	public static function direction(){
		if(self::$direction == NULL){
			self::$direction = new Status();
			self::$direction->add('ltr','ltr',Jii::t('Left To Right'),'Left To Right Direction');
			self::$direction->add('rtl','rtl',Jii::t('Right To Left'),'Right To Left Direction');
		}
		return self::$direction;	
	}
}
?>