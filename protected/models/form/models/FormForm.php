<?php
class FormForm extends CFormModel{
	public $id;
	public $title;
	public $sendto;
	public $email;
	public $status;
	public function rules()
	{
		return array(
			array('title', 'required'),
			array('id,title,sendto,email,status', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'title'=>Jii::t('Title'),
			'sendto'=>Jii::t('Send To'),
			'email'=>Jii::t('Email'),
			'status'=>Jii::t('Status'),
		);
	}
}