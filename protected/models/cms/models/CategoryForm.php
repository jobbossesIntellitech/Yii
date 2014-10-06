<?php
class CategoryForm extends CFormModel{
	public $id;
	public $name;
	public $description;
	public $status;
	public $parentid;
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id,name,description,status,parentid', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'name'=>Jii::t('Name'),
			'description'=>Jii::t('Description'),
			'status'=>Jii::t('Status'),
			'parentid'=>Jii::t('Belong To'),
		);
	}
}