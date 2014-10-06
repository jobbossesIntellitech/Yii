<?php
class EmailfriendForm extends CFormModel{
	public $email_from;
	public $name_from;
	public $email_to;
	public $name_to;
	public $message;
	public function rules()
	{
		return array(
			array('email_from,name_from,email_to,name_to,message', 'required'),
			array('email_from,name_from,email_to,name_to,message', 'safe'),
			array('email_from,email_to','email'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'email_from'=>Jii::t('Your Email'),
			'name_from'=>Jii::t('Your Name'),
			'email_to'=>Jii::t('Destination Email'),
			'name_to'=>Jii::t('Destination Name'),
			'message'=>Jii::t('Your Message'),
		);
	}
}