<?php
class SettingForm extends CFormModel{
	public $id;
	public $key;
	public $value;
	public $sections;
	public $section;
	public $options;
	public function rules()
	{
		return array(
			array('key,value,section', 'required'),
			array('id,key,value,section,sections,options', 'safe'),
			array('section','validateOnCreate','on'=>'create'),
			array('section','validateOnUpdate','on'=>'update'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'key'=>Jii::t('Key'),
			'value'=>Jii::t('Value'),
			'section'=>Jii::t('Section'),
			'sections'=>Jii::t('Sections'),
			'options'=>Jii::t('Options'),
		);
	}
	
	public function validateOnCreate($attribute,$params){
		$criteria = new CDbCriteria;
		$criteria->addCondition('set_key = "'.$this->key.'"');
		$criteria->addCondition('set_section = "'.$this->section.'"');
		$setting = Setting::model()->find($criteria);
		if(isset($setting->set_id)){
			$this->addError('section',Jii::t('Setting key and section Already Exist.'));
		}
	}
	
	public function validateOnUpdate($attribute,$params){
		$criteria = new CDbCriteria;
		$criteria->addCondition('set_key = "'.$this->key.'"');
		$criteria->addCondition('set_section = "'.$this->section.'"');
		$setting = Setting::model()->find($criteria);
		$me = Setting::model()->findByPk($this->id);
		if(isset($setting->set_id) && isset($me->set_id) && $setting->set_id != $me->set_id){
			$this->addError('section',Jii::t('Setting key and section Already Exist.'));
		}
	}
}