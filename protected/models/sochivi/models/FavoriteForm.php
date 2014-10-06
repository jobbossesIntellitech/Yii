<?php
class FavoriteForm extends CFormModel{
	public $id;
	public $adid;
	public $memberid;
	
	public function rules()
	{
		return array(
			array('', 'required'),
			array('id, adid, memberid', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'adid'=>Jii::t('Ad Id'),
			'memberid'=>Jii::t('Member Id'),
		);
	}
}