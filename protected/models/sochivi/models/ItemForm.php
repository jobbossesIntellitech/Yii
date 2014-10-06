<?php
class ItemForm extends CFormModel{
	public $id;
	public $name;
	public $status;
	public $parentid;
	public $position;
	public $translate = array();
	public $options;
	public $type;
	public $formid;
	public function rules()
	{
		return array(
			array('name,type', 'required'),
			array('id,name,status,parentid,position,translate,options,type,formid', 'safe'),
			array('position','numerical','integerOnly'=>true),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('Item Type'),
			'name'=>Jii::t('Name'),
			'status'=>Jii::t('Status'),
			'parentid'=>Jii::t('Belong To'),
			'position'=>Jii::t('Position'),
			'options'=>Jii::t('Options'),
			'translate'=>Jii::t('Translate'),
			'translate[1]'=>Jii::t('Arabic'),
			'translate[2]'=>Jii::t('English'),
			'translate[3]'=>Jii::t('Frensh'),
			'type'=>Jii::t('Type of this Item'),
			'formid'=>Jii::t('Form of this Item'),
		);
	}
}