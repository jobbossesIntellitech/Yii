<?php
class MemberForm extends CFormModel
{
	public $id;
	public $firstname;
	public $lastname;
	public $username;
	public $password;
	public $confirmpassword;
	public $saltpassword;
	
	public $gender;
	public $image;
	public $email;
	public $phone;
	public $locationid;
	public $country;
	public $city;
	public $area;
	public $address;
	public $status;

	
	public function rules()
	{
		return array(
			array('firstname, lastname, username, email, phone', 'required'),
			array('password, confirmpassword',  'required', 'on' => 'create'),
			array('password','length','max'=>25),
            array('password','length','min'=>6),
			array('confirmpassword', 'compare', 'compareAttribute'=>'password', 'message' => 'Retype Password is incorrect.'),
			array('id, firstname, lastname, username, password, confirmpassword, image, saltpassword, gender, email, phone, locationid,country,city,area, address, status', 'safe'),
			array('email','email'),
			array('username','validateUsernameOnCreate','on'=>'create'),
			array('username','validateUsernameOnUpdate','on'=>'update'),
			array('image', 'file', 
				  'types'=>'jpg, gif, png, jpeg',
				  'maxSize'=>1024 * 100,
				  'tooLarge'=>'{attribute} '.Jii::t("was larger than 100 KB. Please upload a smaller image."),
				  'allowEmpty'=>true),
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
			'saltpassword'=>Jii::t('Salt Password'),
			'gender'=>Jii::t('Gender'),
			'image'=>Jii::t('Image (100 KB)'),
			'email'=>Jii::t('Email'),
			'phone'=>Jii::t('Phone'),
			'locationid'=>Jii::t('Location'),
			'country'=>Jii::t('Country'),
			'city'=>Jii::t('City'),
			'area'=>Jii::t('Area'),
			'address'=>Jii::t('Address'),
			'status'=>Jii::t('Status'),
		);
	}
	
	public function validateUsernameOnCreate($attribute,$params){
		$stocks = Member::model()->findAll();
		if(isset($stocks) && is_array($stocks) && !empty($stocks)){
			foreach($stocks AS $s){
				if($s->mbr_username == $this->username){
					$this->addError('username',Jii::t('Username Already Exist.'));
					break;
				}
			}
		}
	}
	public function validateUsernameOnUpdate($attribute,$params){
		$stocks = Member::model()->findAll();
		$member = Member::model()->findByPk($this->id);
		if(isset($stocks) && is_array($stocks) && !empty($stocks)){
			foreach($stocks AS $s){
				if($s->mbr_username == $this->username && $s->mbr_username != $member->mbr_username){
					$this->addError('username',Jii::t('Username Already Exist.'));
					break;
				}
			}
		}	
	}
}