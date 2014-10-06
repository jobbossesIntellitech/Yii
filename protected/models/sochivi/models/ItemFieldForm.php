<?php
class ItemForm extends CFormModel{
	public $id;
	public $name;
	public $default;
	public $itemid;
	public $position;
	public $translate = array();
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id,name,default,itemid,position,translate,options', 'safe'),
			array('position','numerical','integerOnly'=>true),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'name'=>Jii::t('Name'),
			'default'=>Jii::t('Default Value'),
			'itemid'=>Jii::t('Belong To'),
			'position'=>Jii::t('Position'),
			'translate'=>Jii::t('Translate'),
			'translate[1]'=>Jii::t('Arabic'),
			'translate[2]'=>Jii::t('English'),
			'translate[3]'=>Jii::t('Frensh'),
		);
	}
}