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
	public $country_code;
	public $mobile_code;
	public $mobile_number;
	
	public $locationid;
	public $country;
	public $city;
	public $area;
	public $address;
	public $status;

	
	public function rules()
	{
		return array(
			array('firstname, lastname, username, email, country_code, mobile_code, mobile_number', 'required'),
			array('password, confirmpassword',  'required', 'on' => 'create'),
			array('password','length','max'=>25),
            array('password','length','min'=>6),
			array('phone','length','min'=>13),
			
			array('country_code','length','min'=>1),
			array('country_code','length','max'=>5),
			
			array('mobile_code','length','min'=>1),
			array('mobile_code','length','max'=>2),
			
			array('mobile_number','length','min'=>6),
			array('mobile_number','length','max'=>10),
			
			array('confirmpassword', 'compare', 'compareAttribute'=>'password', 'message' => 'Retype Password is incorrect.'),
			array('id, firstname, lastname, username, password, confirmpassword, image, saltpassword, gender, email, phone, locationid,country,city,area, address, status, country_code, mobile_code, mobile_number', 'safe'),
			array('email','email'),
			array('country','validateCountry'),
			array('city','validateCity'),
			array('gender','validateGender'),
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
			'image'=>Jii::t('Upload your photo profile (100 KB, 100x100)'),
			'email'=>Jii::t('Email'),
			'phone'=>Jii::t('Phone (Country code - Mobile code - Mobile number)'),
			'locationid'=>Jii::t('Location'),
			'country'=>Jii::t('Country'),
			'city'=>Jii::t('City'),
			'area'=>Jii::t('Area'),
			'address'=>Jii::t('Address'),
			'status'=>Jii::t('Status'),
		);
	}
	
	public function validateCountry($attribute,$params){
		if($this->country == ''){
			$this->addError('country',Jii::t('Please select a Country.'));
		}
	}
	
	public function validateCity($attribute,$params){
		if($this->city == ''){
			$this->addError('city',Jii::t('Please select a City.'));
		}
	}
	
	public function validateGender($attribute,$params){
		if($this->gender == ''){
			$this->addError('gender',Jii::t('Please select a Gender.'));
		}
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