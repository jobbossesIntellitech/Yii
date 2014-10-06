<?php
class MenuForm extends CFormModel{
	public $id;
	public $name;
	public $status;
	public $hook;
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id,name,status,hook', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'name'=>Jii::t('Name'),
			'status'=>Jii::t('Status'),
			'hook'=>Jii::t('Hook'),
		);
	}
}