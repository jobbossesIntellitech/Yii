<?php
class Search extends JActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'form_search';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'item'=>array(self::BELONGS_TO,'Item','fse_itemid'),
					'field'=>array(self::BELONGS_TO,'FormField','fse_fieldid'),
				);	
	}
	
	
	private static $type = NULL;
	public static function type(){
		if(self::$type == NULL){
			self::$type = new Status();
			self::$type->add('textbox',0x01,Jii::t('Text Box'),'Text Box');
			self::$type->add('numberbox',0x002,Jii::t('Number Box'),'Number Box');
			self::$type->add('numberfromto',0x03,Jii::t('Number From To'),'Number From To');
			self::$type->add('datefromto',0x04,Jii::t('Date From To'),'Date From To');
			self::$type->add('checkbox',0x05,Jii::t('Checkbox'),'CheckBox');
			self::$type->add('radiobutton',0x06,Jii::t('Radio Button'),'Radio Button');
			self::$type->add('dropdownlist',0x07,Jii::t('Drop Down List'),'Drop Down List');
		}
		return self::$type;	
	}
	
	public function afterDelete(){
		parent::afterDelete();
	}

	
	
}
?>


