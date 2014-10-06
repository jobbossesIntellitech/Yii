<?php
class Translate extends CActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'sys_translations';
	}
	public function relations()
	{
		return array(
					'language'=>array(self::BELONGS_TO, 'Language', 'trs_languageid'),
				);	
	}
	public static function get(){
		$criteria = new CDbCriteria;
		$criteria->addCondition('trs_languageid = "'.Jii::app()->language.'"');
		$criteria->addCondition('trs_application = "'.Jii::application().'"');
		$data = self::model()->findAll($criteria);
		$gets = CHtml::listData($data,'trs_key','trs_value');
		return $gets;
	}
	
	public static function applications(){
		$criteria = new CDbCriteria;
		$criteria->group = 'trs_application';
		$criteria->order = 'trs_application ASC';
		return CHtml::listData(self::model()->findAll($criteria),'trs_application','trs_application');
	}
	public static function keys($application){
		$criteria = new CDbCriteria;
		$criteria->addCondition('trs_application = "'.$application.'"');
		$criteria->group = 'trs_key';
		$criteria->order = 'trs_key ASC';
		return CHtml::listData(self::model()->findAll($criteria),'trs_key','trs_key');
	}
	
	public static function getKeyValues($application,$key){
		$criteria = new CDbCriteria;
		$criteria->addCondition('trs_application = "'.$application.'"');
		$criteria->addCondition('trs_key = "'.$key.'"');
		$records = self::model()->findAll($criteria);
		return CHtml::listData($records,'trs_languageid','trs_value');	
	}
}
?> 