<?php
class LocationForm extends CFormModel{
	public $id;
	public $name;
	public $status;
	public $parentid;
	public $type;
	public $types;
	public $priority;
	public $logo;
	public $position;
	public $translate = array();
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id,name,status,parentid,type,types,priority,logo,position,translate', 'safe'),
			array('position,priority','numerical','integerOnly'=>true),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'name'=>Jii::t('Name'),
			'status'=>Jii::t('Status'),
			'parentid'=>Jii::t('Belong To'),
			'type'=>Jii::t('Type'),
			'types'=>Jii::t('Types'),
			'priority'=>Jii::t('Priority'),
			'logo'=>Jii::t('Logo'),
			'position'=>Jii::t('Position'),
			'translate'=>Jii::t('Translate'),
			'translate[1]'=>Jii::t('Arabic'),
			'translate[2]'=>Jii::t('English'),
			'translate[3]'=>Jii::t('Frensh'),
		);
	}
}