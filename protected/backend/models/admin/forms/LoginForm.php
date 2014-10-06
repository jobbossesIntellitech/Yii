<?php
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $language;
	private $_identity;
	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('username, password, language', 'safe'),
			array('password', 'authenticate'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'username'=>Jii::t('Username'),
			'password'=>Jii::t('Password'),
			'language'=>Jii::t('Language'),
		);
	}
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password,$this->language);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password,$this->language);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=3600*24*30; // 30 days
			Jii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
