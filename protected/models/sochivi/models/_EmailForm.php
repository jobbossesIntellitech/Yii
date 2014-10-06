<?php
class EmailForm extends CFormModel{
	public $email;
	public $name;
	public $phone;
	public $message;
	public function rules()
	{
		return array(
			array('email,name,phone,message', 'required'),
			array('email,name,phone,message', 'safe'),
			array('email','email'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'email'=>Jii::t('Your Email'),
			'name'=>Jii::t('Your Name'),
			'phone'=>Jii::t('Your Phone'),
			'message'=>Jii::t('Your Message'),
		);
	}
}