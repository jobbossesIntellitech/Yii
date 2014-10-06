<?php
class SearchForm extends CFormModel{
	public $id;
	public $itemid;
	public $sectionid;
	public $fieldid;
	public $type;
	public $label;
	public $options;
	public $position;
	public $view;
	public function rules()
	{
		return array(
			array('formid', 'required'),
			array('id,itemid,sectionid,fieldid,type,label,options,position,view', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'itemid'=>Jii::t('Item id'),
			'sectionid'=>Jii::t('Section id'),
			'fieldid'=>Jii::t('Field id'),
			'type'=>Jii::t('Type'),
			'label'=>Jii::t('Label'),
			'options'=>Jii::t('Options'),
			'position'=>Jii::t('Position'),
			'view'=>Jii::t('View'),
		);
	}
}