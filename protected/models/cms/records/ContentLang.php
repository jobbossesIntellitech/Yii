<?php
class ContentLang extends LActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'cms_content_langs';
	}
	public function relations()
	{
		return array(
					'content'=>array(self::BELONGS_TO, 'Content', 'lng_contentid'),
				);	
	}
}
?>