<?php
class UserForm extends CFormModel
{
	public $id;
	public $firstname;
	public $lastname;
	public $username;
	public $password;
	public $confirmpassword;
	public $image;
	
	/* ============ */
	
	public $saltpassword;
	public $lastlogin;
	public $color;
	public $status;
	public $parent;

	
	public function rules()
	{
		return array(
			array('firstname, lastname, username', 'required'),
			array('password, confirmpassword',  'required', 'on' => 'create'),
			array('password','length','max'=>25),
            array('password','length','min'=>6),
			array('confirmpassword', 'compare', 'compareAttribute'=>'password', 'message' => 'Retype Password is incorrect.'),
			array('id, firstname, lastname, username, password, confirmpassword, image, saltpassword, lastlogin, color, status, parent', 'safe'),
			array('username','validateUsernameOnCreate','on'=>'create'),
			array('username','validateUsernameOnUpdate','on'=>'update'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'firstname'=>Jii::t('Firstname'),
			'lastname'=>Jii::t('Lastname'),
			'username'=>Jii::t('Username'),
			'password'=>Jii::t('Password'),
			'confirmpassword'=>Jii::t('Confirm Password'),
			'image'=>Jii::t('Image'),
			'saltpassword'=>Jii::t('Salt Password'),
			'lastlogin'=>Jii::t('Last Login'),
			'color'=>Jii::t('Theme Color'),
			'status'=>Jii::t('Status'),
			'parent'=>Jii::t('Parent'),
		);
	}
	
	public function validateUsernameOnCreate($attribute,$params){
		$stocks = User::model()->findAll();
		if(isset($stocks) && is_array($stocks) && !empty($stocks)){
			foreach($stocks AS $s){
				if($s->usr_username == $this->username){
					$this->addError('username',Jii::t('Username Already Exist.'));
					break;
				}
			}
		}
	}
	public function validateUsernameOnUpdate($attribute,$params){
		$stocks = User::model()->findAll();
		$user = User::model()->findByPk($this->id);
		if(isset($stocks) && is_array($stocks) && !empty($stocks)){
			foreach($stocks AS $s){
				if($s->usr_username == $this->username && $s->usr_username != $user->usr_username){
					$this->addError('username',Jii::t('Username Already Exist.'));
					break;
				}
			}
		}	
	}
}