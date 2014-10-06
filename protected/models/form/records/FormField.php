<?php
class FormField extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'form_fields';
	}
	public function relations()
	{
		return array(
					'save'=>array(self::HAS_MANY,'FormSave','save_fieldid'),
					'x'=>array(self::HAS_MANY,'FormSave','save_fieldid'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),	
					'section'=>array(self::BELONGS_TO,'FormSection','fld_sectionid'),
				);	
	}
	private static $type = NULL;
	public static function type(){
		if(self::$type == NULL){
			self::$type = new Status();
			self::$type->add('hidden',0x00,Jii::t('Hidden'),'Hidden Field');
			self::$type->add('text',0x01,Jii::t('Text'),'Text Field');
			self::$type->add('password',0x02,Jii::t('Password'),'Password Field');
			self::$type->add('select',0x03,Jii::t('Select'),'Select Field');
			self::$type->add('checkbox',0x04,Jii::t('Checkbox'),'Checkbox Field');
			self::$type->add('radio',0x05,Jii::t('Radio'),'Radio Field');
			self::$type->add('date',0x06,Jii::t('Date'),'Date Field');
			self::$type->add('time',0x07,Jii::t('Time'),'Time Field');
			self::$type->add('datetime',0x08,Jii::t('Date Time'),'Date Time Field');
			self::$type->add('textarea',0x09,Jii::t('Textarea'),'Textarea Field');
			self::$type->add('email',0x0a,Jii::t('Email'),'Email Field');
			self::$type->add('number',0x0b,Jii::t('Number'),'Number Field');
			self::$type->add('editor',0x0c,Jii::t('Editor'),'Editor Field');
			self::$type->add('poll',0x0d,Jii::t('Poll'),'Poll Field');
			self::$type->add('tags',0x0e,Jii::t('Tags'),'Tags Field');
			self::$type->add('mask',0x0f,Jii::t('Mask'),'Mask Field');
		}
		return self::$type;	
	}
	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('save_fieldid = '.$this->fld_id);
		$list = FormSave::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();
			}
		}
	}
}
?>