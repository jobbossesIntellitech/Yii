<?php
class FormSave extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'form_saves';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'field'=>array(self::BELONGS_TO,'FormField','save_fieldid'),
				);	
	}
}
?>