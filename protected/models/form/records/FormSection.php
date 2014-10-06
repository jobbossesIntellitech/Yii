<?php
class FormSection extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'form_sections';
	}
	public function relations()
	{
		return array(
					'field'=>array(self::HAS_MANY,'FormField','fld_sectionid'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'form'=>array(self::BELONGS_TO,'Form','sec_formid'),
				);	
	}
	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('fld_sectionid = '.$this->sec_id);
		$list = FormField::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();
			}
		}
	}
}
?>