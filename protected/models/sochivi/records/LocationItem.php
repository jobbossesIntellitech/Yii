<?php
class LocationItem extends JActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'_location_items';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'item'=>array(self::BELONGS_TO,'Item','lit_itemid'),
					'location'=>array(self::BELONGS_TO,'Location','lit_locationid'),
				);	
	}
}
?>