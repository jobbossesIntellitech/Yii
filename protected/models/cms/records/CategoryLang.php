<?php
class CategoryLang extends LActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'cms_category_langs';
	}
	public function relations()
	{
		return array(
					'category'=>array(self::BELONGS_TO, 'Category', 'lng_categoryid'),
				);	
	}
}
?>