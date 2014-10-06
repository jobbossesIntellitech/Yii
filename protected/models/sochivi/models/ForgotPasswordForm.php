<?php
class ForgotPasswordForm extends CFormModel{
	public $email;
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'safe'),
			array('email', 'email'),
			array('email', 'emailExist'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'email'=>Jii::t('Email'),
		);
	}
	
	public function emailExist(){
		$criteria = new CDbCriteria;
		$criteria->addCondition('mbr_email="'.$this->email.'"');
		$m = Member::model()->find($criteria);
		if(!isset($m->mbr_id)){
			$this->addError('email',Jii::t('Email Not Found'));
		}
	}
}