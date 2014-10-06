<?php
class LanguageForm extends CFormModel{
	public $id;
	public $iso;
	public $name;
	public $direction;
	public $status;
	public function rules()
	{
		return array(
			array('iso,name', 'required'),
			array('id,iso,name,direction,status', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'iso'=>Jii::t('Iso'),
			'name'=>Jii::t('Name'),
			'direction'=>Jii::t('Direction'),
			'status'=>Jii::t('Status'),
		);
	}
}