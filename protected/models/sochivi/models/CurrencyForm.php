<?php
class CurrencyForm extends CFormModel{
	public $id;
	public $name;
	public $sign;
	public $locations;
	public function rules()
	{
		return array(
			array('name,sign,locations', 'required'),
			array('id,name,sign,locations', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'name'=>Jii::t('Name'),
			'sign'=>Jii::t('Sign'),
			'locations'=>Jii::t('Locations'),
		);
	}
}