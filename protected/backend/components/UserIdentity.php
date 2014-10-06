<?php
class UserIdentity extends CUserIdentity
{
	public $language;
	
	public function __construct($username,$password,$language)
	{
		parent::__construct($username,$password);
		$this->language = $language;
	}
	
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array("usr_username"=>$this->username,'usr_status'=>User::status()->getItem('enable')->getValue()));
		if(!isset($user->usr_username))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!Password::validate($this->password,$user->usr_password,$user->usr_saltpassword))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->errorCode=self::ERROR_NONE;
			$this->setState("firstname",$user->usr_firstname);
			$this->setState("lastname",$user->usr_lastname);
			$this->setState("fullname",$user->usr_firstname."&nbsp;".$user->usr_lastname);
			$this->setState("username",$user->usr_username);
			$this->setState("id",$user->usr_id);
			$last = '';
			if($user->usr_lastlogin == "0000-00-00 00:00:00"){
				$last = Jii::t("First Time");
				$this->setState("isfirst",true);
			}else{
				$last = date("F d, Y H:i");
				$this->setState("isfirst",false);
			}
			$this->setState("lastlogin",$last);
			$this->setState("parent",$user->usr_parent);
			$this->setState("image",$user->usr_image);
			$this->setState("status",$user->usr_status);
			$user->usr_lastlogin = date("Y-m-d H:i:s");
			$user->save();
			Jii::app()->setLanguage($this->language);
			Jii::app()->session['_lang'] = Jii::app()->language;
			$l = Language::model()->findByPk(Jii::app()->session['_lang']);
			$this->setState("language",$l->lng_id);
			$this->setState("direction",$l->lng_direction);
			$this->setState("color",$user->usr_color);
		}
		return !$this->errorCode;
	}
}