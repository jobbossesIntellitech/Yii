<?php
class UserIdentity extends CUserIdentity
{
	public function __construct($username,$password)
	{
		parent::__construct($username,$password);
	}
	
	public function authenticate()
	{
		$user = Member::model()->findByAttributes(array("mbr_username"=>$this->username,'mbr_status'=>Member::status()->getItem('enable')->getValue()));
		if(!isset($user->mbr_username))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!Password::validate($this->password,$user->mbr_hashpassword,$user->mbr_saltpassword))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->errorCode=self::ERROR_NONE;
			$this->setState("firstname",$user->mbr_firstname);
			$this->setState("lastname",$user->mbr_lastname);
			$this->setState("fullname",$user->mbr_firstname."&nbsp;".$user->mbr_lastname);
			$this->setState("username",$user->mbr_username);
			$this->setState("id",$user->mbr_id);
			$this->setState("status",$user->mbr_status);
			$this->setState("location",$user->mbr_locationid);
			$user->save();
			
			$cookie = new CHttpCookie('location', $user->mbr_locationid);
			$cookie->expire = time()+60*60*24*180; 
			Yii::app()->request->cookies['location'] = $cookie;
		}
		return !$this->errorCode;
	}
}