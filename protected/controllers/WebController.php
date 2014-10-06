<?php
class WebController extends Controller
{
	public function actionIndex()
	{
		/*$criteria = new CDbCriteria;
		$criteria->addCondition('con_id = 48');
		$criteria->addCondition('con_status = '.Content::status()->getItem('publish')->getValue());
		$criteria->with = array('content_lang:'.Jii::app()->language);
		$lists = Content::model()->find($criteria);
		if(Jii::param('location_log_id')){
			Jii::app()->user->setState('location',Jii::param('location_log_id'));
		}*/
		
		$meta = Content::model()->findByPk(14);
		if(isset($meta) && !empty($meta)){
			$meta_title = '';
			$meta_description = '';
			$meta_keywords = '';
			
			if(!empty($meta->con_metatitle))$meta_title = strip_tags($meta->con_metatitle);
			if(!empty($meta->con_metakeywords))$meta_keywords = strip_tags($meta->con_metakeywords);
			if(!empty($meta->con_metadescription))$meta_description = strip_tags($meta->con_metadescription);
			JMeta::set($meta_title,$meta_keywords,$meta_description);
		}	
		
		$this->pageTitle = Jii::t('HOME PAGE');
		$this->render('index',array());
	}
	
	public function actionExpirydate(){
		$date_limit = 60*60*24*30*3;
		$date_now = time();
		
		$criteria = new CDbCriteria;
		$criteria->with = array('dates'=>array('condition'=>'dates.dat_creation < DATE_SUB(NOW(), INTERVAL 90 DAY)'));
		$criteria->addCondition('ads_status in ('.Ads::status()->getItem('enable')->getValue().')');
		$list = Ads::model()->findAll($criteria);
		
		if(!empty($list) && is_array($list)){
			foreach($list as $l){
				//$ads_time = strtotime($l->dates->dat_creation);
				//if(($date_now - $ads_time) > $date_limit){
					$l->ads_status = Ads::status()->getItem('draft')->getValue();
					$l->save();
				//}
			}
		}
	}
	
	public function actionFacebooklogin(){
		
		/*$facebook = new FacebookLogin('324865007656035', '329533a5085ac2cf6dae3e59877beff3');
		$user = $facebook->doLogin();
		echo 'User\'s URL: ', $user->link, '<br />';
		echo 'User\'s name: ', $user->name, '<br />';
		echo 'Full details:<br /><pre>', print_r($user, true), '</ pre>';
		$this->render('index',array());*/
		$app_id = '324865007656035';
		$app_secret = '329533a5085ac2cf6dae3e59877beff3';
		$config = array(
					'appId'      => $app_id,
					'secret'     => $app_secret,
					'cookie'     => true,
					'fileUpload' => false,
				);
		$facebook = new Facebook($config);
		$uid = $facebook->getUser();
		$profile = NULL;
		if($uid){
			$profile = $facebook->api('/me','GET');
			
			$username = $profile['username'];
			$firstname = $profile['first_name'];
			$lastname = $profile['last_name'];
			$location = $profile['location']['name'];
			if($profile['gender'] == 'male'){
				$gender = 1;
			}else if($profile['gender'] == 'female'){
				$gender = 2;
			}
			//$gender = $profile['gender'];
			$email = $profile['email'];
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('mbr_username = "'.$username.'"');
			$member = Member::model()->find($criteria);
			
			$model = new LoginfaceForm;
			$model->username = $username;
			
			if(!empty($member) && isset($member)){
				if($model->validate() && $model->login()){
					if(!empty($member->mbr_locationid) && isset($member->mbr_locationid)){
						$this->redirect(array('web/index'));
					}else{
						$this->redirect(array('web/editprofile','id'=>$member->mbr_id));
					}
				}
			}else{
				$u = new Member;
				$u->mbr_firstname = $firstname;
				$u->mbr_lastname = $lastname;
				$u->mbr_username = $username;
				$u->mbr_email = $email;
				$u->mbr_gender = $gender;
				//$password = new Password($username);
				//$u->mbr_hashpassword = $password->getHash();
				//$u->mbr_saltpassword = $password->getSalt();
				//$u->mbr_gender = $model->gender;
				//$u->mbr_phone = $model->phone;
				//$u->mbr_locationid = $model->locationid;
				$u->mbr_status = 1;
				$res = $u->save();
				if($model->validate() && $model->login()){
					$this->redirect(array('web/editprofile','id'=>$u->mbr_id));
				}
			}
			
			//echo $username.'<br>'.$firstname.'<br>'.$lastname.'<br>'.$location.'<br>'.$gender.'<br>'.$email.'<br>';
			//echo 'Full details:<br /><pre>', print_r($profile, true), '</ pre>';
			$this->redirect(array('web/index'));
		}else{
			$loginUrl = $facebook->getLoginUrl(array('scope'=>'email,user_photos,friends_photos'));
			header('location:'.$loginUrl);
			exit(0);
			//$this->redirect(array('web/index'));
		}
	}
	
	public function actionRegister(){
		if(Jii::app()->user->isGuest){
			$this->pageTitle = Jii::t('Add new Member');
			$model = new MemberForm;
			$model->setScenario('create');
			$this->ajaxValidation($model);
			if(Jii::param(get_class($model))){
				$model->attributes = Jii::param(get_class($model));
				if($model->validate()){
					$u = new Member;
					//$u->mbr_image = isset($model->image[0])?$model->image[0]:Jii::notfound();
					$u->mbr_firstname = $model->firstname;
					$u->mbr_lastname = $model->lastname;
					$u->mbr_username = $model->username;
					$u->mbr_email = $model->email;
					$password = new Password($model->password);
					$u->mbr_hashpassword = $password->getHash();
					$u->mbr_saltpassword = $password->getSalt();
					$u->mbr_gender = $model->gender;
					$u->mbr_phone = implode('-',array($model->country_code,$model->mobile_code,$model->mobile_number));
					$u->mbr_address = $model->address;
					
					if(isset($model->area) && !empty($model->area)){
						$u->mbr_locationid = $model->area;
					}else if(isset($model->city) && !empty($model->city)){
						$u->mbr_locationid = $model->city;
					}else if(isset($model->country) && !empty($model->country)){
						$u->mbr_locationid = $model->country;
					}
					//$u->mbr_locationid = $model->locationid;
					$u->mbr_status = 1;
					$res = $u->save();
					$u->setPrimaryKey($u->primaryKey);
					if(!is_dir(Jii::app()->basePath.'/../assets/uploads/')){
						mkdir(Jii::app()->basePath.'/../assets/uploads/',0777);	
					}
					if(!is_dir(Jii::app()->basePath.'/../assets/uploads/members/')){
						mkdir(Jii::app()->basePath.'/../assets/uploads/members/',0777);	
					}
					Log::trace('Save Member');
					if($res){
						if(isset($_FILES["MemberForm"]["name"]["image"]) && !empty($_FILES["MemberForm"]["name"]["image"])){
							$info = pathinfo($_FILES["MemberForm"]["name"]["image"]);
							$newname = time().'_'.round(rand()*10000).'.'.$info['extension'];
							$success = move_uploaded_file($_FILES["MemberForm"]["tmp_name"]["image"], Jii::app()->basePath.'/../assets/uploads/members/'.$newname);
							if($success){
								$u->mbr_image = $newname;
								$res = $u->save();
								Log::success('The member has been added successfully');
							}
						}
						
						$subject = 'Thank you for your registration on SoChivi!';
				
						$line1 = 'Thank you '.$u->mbr_firstname.' '.$u->mbr_lastname.' for your registration on SoChivi.<br><br> ';
						
						$line2 ='';
						//$line2 = 'If you wish to view or edit your profile, please go to the following link:<br> <a href="http://sochivi.com/'.Jii::app()->createUrl('web/editprofile',array('mbrid'=>$u->mbr_id)).'">http://sochivi.com/'.Jii::app()->createUrl('web/editprofile').'</a><br /><br />';
						
						$line3 = 'Your username is: '.$model->username.'<br /><br />';
						
						$line4 = 'Your password is: '.$model->password.'<br /><br />';
						
						$line5 = 'Kindly refrain from disclosing your personal or financial information - do not proceed with any type of payment unless when meeting the seller face-to-face and receiving the goods or services you are paying for.
						<br><br>At SoChivi, we work hard to ensure you have a secure experience, therefore please report any suspicious activity immediately.
						<br><br>In the meantime, enjoy trading and stay safe!
						<br><br>The SoChivi Team';
						
						$message = $line1.$line2.$line3.$line4.$line5;
						
						$email_from = 'info@sochivi.com';
						// Is the OS Windows or Mac or Linux 
						if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
							$eol="\r\n"; 
						} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
							$eol="\r"; 
						} else { 
							$eol="\n"; 
						}
						// Common Headers 
						$headers  = '';
						$headers .= 'From: '.$email_from.''.$eol; 
						$headers .= 'Cc: info@sochivi.com'.$eol;
						$headers .= 'Reply-To: '.$email_from.' <'.$email_from.'>'.$eol; 
						$headers .= 'Return-Path: '.$email_from.' <'.$email_from.'>'.$eol;     // these two to set reply address 
						$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
						$headers .= "X-Mailer: PHP/".phpversion().$eol;           // These two to help avoid spam-filters 
						// Boundry for marking the split & Multitype Headers 
						$mime_boundary = md5(time()); 
						$headers .= 'MIME-Version: 1.0'.$eol; 
						$headers .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol; 
						ini_set('sendmail_from',$email_from);  // the INI lines are to force the From Address to be used ! 
							$send = mail($u->mbr_email, $subject, $message, $headers); 
						ini_restore('sendmail_from');
				
						Log::success('The member has been added successfully');
					}else{
						Log::error('The member hasnt been added');	
					}
					$this->redirect(array('web/index'));		
				}else{
					$this->render('add',array('model'=>$model));	
				}
			}else{
				Log::trace('Open member form');
				$this->render('add',array('model'=>$model));
			}
		}else{
			$this->redirect(array('web/index'));
		}
	}
	
	public function actionEditprofile(){
		if(!Jii::app()->user->isGuest && isset(Jii::app()->user->id) && !empty(Jii::app()->user->id)){
			$this->pageTitle = Jii::t('Edit member');
			$model = new MemberForm;
			$model->setScenario('update');
			$this->ajaxValidation($model);
			if(Jii::param(get_class($model))){
				$model->attributes = Jii::param(get_class($model));
				if($model->validate()){
					$u = Member::model()->findByPk($model->id);
					//$u->mbr_image = $model->image;
					$u->mbr_firstname = $model->firstname;
					$u->mbr_lastname = $model->lastname;
					$u->mbr_username = $model->username;
					$u->mbr_email = $model->email;
					if(!empty($model->password)){
						$password = new Password($model->password);
						$u->mbr_hashpassword = $password->getHash();
						$u->mbr_saltpassword = $password->getSalt();
					}
					$u->mbr_gender = $model->gender;
					$u->mbr_phone = implode('-',array($model->country_code,$model->mobile_code,$model->mobile_number));
					$u->mbr_address = $model->address;
					if(isset($model->area) && !empty($model->area)){
						$u->mbr_locationid = $model->area;
						Jii::app()->user->setState('location',$u->mbr_locationid);
					}else if(isset($model->city) && !empty($model->city)){
						$u->mbr_locationid = $model->city;
						Jii::app()->user->setState('location',$u->mbr_locationid);
					}else if(isset($model->country) && !empty($model->country)){
						$u->mbr_locationid = $model->country;
						Jii::app()->user->setState('location',$u->mbr_locationid);
					}
					//$u->mbr_locationid = $model->locationid;
					//$u->mbr_status = $model->status;
					$res = $u->save();
					$u->setPrimaryKey($u->primaryKey);
					if(!is_dir(Jii::app()->basePath.'/../assets/uploads/')){
						mkdir(Jii::app()->basePath.'/../assets/uploads/',0777);	
					}
					if(!is_dir(Jii::app()->basePath.'/../assets/uploads/members/')){
						mkdir(Jii::app()->basePath.'/../assets/uploads/members/',0777);	
					}
					Log::trace('Save Member');
					if($res){
						if(isset($_FILES["MemberForm"]["name"]["image"]) && !empty($_FILES["MemberForm"]["name"]["image"])){
							$info = pathinfo($_FILES["MemberForm"]["name"]["image"]);
							$newname = time().'_'.round(rand()*10000).'.'.$info['extension'];
							$success = move_uploaded_file($_FILES["MemberForm"]["tmp_name"]["image"], Jii::app()->basePath.'/../assets/uploads/members/'.$newname);
							if($success){
								$u->mbr_image = $newname;
								$res = $u->save();
								Log::success('The member has been added successfully');
							}
						}
						Log::success('The member has been edited successfully');
					}else{
						Log::error('The member hasnt been edited');	
					}
					$this->redirect(array('web/index'));		
				}else{
					$this->render('edit',array('model'=>$model));	
				}
			}else{
				Log::trace('Open member form');
				if(Jii::param('id') && Jii::param('id') == Jii::app()->user->id){
					$u = Member::model()->findByPk(Jii::param('id'));
					$model->id = $u->mbr_id;
					$model->username = $u->mbr_username;
					$model->email = $u->mbr_email;
					$model->firstname = $u->mbr_firstname;
					$model->lastname = $u->mbr_lastname;
					//$model->status = $u->mbr_status;
					$model->gender = $u->mbr_gender;
					$model->phone = $u->mbr_phone;
					$model->address = $u->mbr_address;
					$model->locationid = $u->mbr_locationid;
					//$model->image = $u->mbr_image;
					$this->render('edit',array('model'=>$model));
				}else{
					$this->redirect(array('web/index'));		
				}
			}
		}else{
			$this->redirect(array('web/index'));
		}
	}
	
	public function actionViewprofile(){
		
		$this->pageTitle = Jii::t('View member profile');
		if(Jii::param('id')){
			$user = Member::model()->findByPk(Jii::param('id'));
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_status in ('.Ads::status()->getItem('enable')->getValue().')');
			$criteria->addCondition('ads_memberid = '.$user->mbr_id);
			/*if(Jii::param('locationid')){
				$subcriteria = new CDbCriteria;
				$subcriteria->addCondition('loc_parentid = '.Jii::param('locationid'));
				$locations = Location::model()->findAll($subcriteria);
				
				if(!empty($locations) && is_array($locations)){
					$lists = CHtml::ListData($locations,'loc_id','loc_id');
					$c = count($lists);
					$lists[$c++] = Jii::param('locationid');
					$criteria->addCondition('ads_locationid in ('.implode(',',$lists).')');
				}else{
					$criteria->addCondition('ads_locationid = '.Jii::param('locationid'));
				}
			}*/
			$criteria->order = 'ads_id DESC';
			if(Jii::param('sort') && Jii::param('order')){
				$criteria->order = Jii::param('sort').' '.Jii::param('order');
			}
			
			$pages = new CPagination(Ads::model()->count($criteria));
			if(isset($this->data['page']) && $this->data['page'] > 0){
				$pages -> setCurrentPage($this->data['page']-1);
			}
			$pages -> pageSize = (Jii::param('number_ads') > 0)?Jii::param('number_ads'):5;
			$pages -> applyLimit($criteria);
			$pages->params = array('id'=>Jii::param('id'),'sort'=>Jii::param('sort'),'order'=>Jii::param('order'),'number_ads'=>Jii::param('number_ads'));
			
			$listads = Ads::model()->findAll($criteria);
			
			$this->render('viewprofile',array('user'=>$user,'listads'=>$listads,'pages'=>$pages));
		}else{
			$this->redirect(array('web/index'));		
		}
	}
	
	
	public function actionAdscategory(){
		$meta_title = '';
		$meta_description = '';
		$meta_keywords = '';
		
		$meta_title = Jii::t('Place an Ad');
		//if(!empty($meta->con_metakeywords))$meta_keywords = strip_tags($meta->con_metakeywords);
		//if(!empty($meta->con_metadescription))$meta_description = strip_tags($meta->con_metadescription);
		JMeta::set($meta_title,$meta_keywords,$meta_description);
		
		if(!Jii::app()->user->isGuest){
			$this->render('adscategory',array());
		}else{
			Log::error('Please login or register to become a member!!');
			$this->redirect(array('web/register'));
		}
	}
	
	public function actionGetSubCategories(){
		if(Jii::isAjax()){
			$data = array();
			$criteria = new CDbCriteria();
			$criteria->addCondition('itm_parentid = '.Jii::param('category'));
			$criteria->order = 'itm_position DESC,itm_name ASC';
			$list = Item::model()->findAll($criteria);
			$list = CHtml::ListData($list,'itm_id','itm_name');
			
			$i = 0;
			foreach($list as $k=>$v){
				$data['list'][$i] = array();
				$data['list'][$i]['id'] = $k;
				$data['list'][$i]['name'] = $v;
				$i++;
			}
			//$data['list'] = CHtml::ListData($list,'itm_id','itm_name');
			echo json_encode($data);
		}
	}
	
	public function actionAds()
	{
		$this->pageTitle = Jii::t('Add new Item');
		
		$meta_title = '';
		$meta_description = '';
		$meta_keywords = '';
		
		$meta_title = Jii::t('Add new Item');
		//if(!empty($meta->con_metakeywords))$meta_keywords = strip_tags($meta->con_metakeywords);
		//if(!empty($meta->con_metadescription))$meta_description = strip_tags($meta->con_metadescription);
		JMeta::set($meta_title,$meta_keywords,$meta_description);
		
		
		if(Jii::param('itemid') && !Jii::param('id') && !Jii::app()->user->isGuest){
			$criteria = new CDbCriteria;
			$criteria->addCondition('itm_id = '.Jii::param('itemid'));
			$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
			$item = Item::model()->find($criteria);
			
			if(isset($item->itm_formid) && $item->itm_formid > 0){
				$this->render('adsform',array('item'=>$item));
			}else{
				Log::error('Form is not available');
				$this->redirect(array('web/index'));
			}
		}else if(Jii::param('id') && Jii::param('itemid') && !Jii::app()->user->isGuest && isset(Jii::app()->user->id) && !empty(Jii::app()->user->id)){
			$member = Member::model()->findByPk(Jii::app()->user->id);
			/*if(isset($member) && !empty($member)){
				$location = $member->mbr_locationid;
				$map = $member->mbr_address;
				if(isset($location) && !empty($location)) $u->ads_locationid = $location;
				if(isset($map) && !empty($map)) $u->ads_map = $map;
			}*/
			$user = self::Saveform();
			$u = new Ads;
			$u->ads_itemid = Jii::param('itemid');
			$u->ads_saverequestkey = $user;
			//if(isset($_POST['reference'])) $u->ads_reference = $_POST['reference'];
			//$u->ads_reference = Jii::param('itemid').''.time();
			if(isset($_POST['name'])) $u->ads_name = $_POST['name'];
			if(isset($_POST['price'])) $u->ads_price = $_POST['price'];
			
			if(isset($_POST['phone_number'])){
				if($_POST['phone_number'] == 'phone1'){
					$u->ads_phone = $member->mbr_phone;
				}else if($_POST['phone_number'] == 'phone2'){
					if(isset($_POST['newphone'])){
						$u->ads_phone = $_POST['newphone'];
					}else{
						$u->ads_phone = '';
					}
				}else{
					$u->ads_phone = '';
				}
			}
			
			if(isset($_POST['description'])) $u->ads_description = strip_tags($_POST['description'], '<br>');
			$u->ads_memberid = Jii::app()->user->id;
			
			if(isset($_POST['area']) && !empty($_POST['area'])){
				$u->ads_locationid = $_POST['area'];
			}else if(isset($_POST['city']) && !empty($_POST['city'])){
				$u->ads_locationid = $_POST['city'];
			}else if(isset($_POST['country'])  && !empty($_POST['country'])){
				$u->ads_locationid = $_POST['country'];
			}
			if(isset($_POST['address_mapping'])) $u->ads_map = $_POST['address_mapping'];
			
			if(isset($_POST['currency'])) $u->ads_currencyid = $_POST['currency'];
			$u->ads_status = Ads::status()->getItem('draft')->getValue();
			$res = $u->save();
			if(!is_dir(Jii::app()->basePath.'/../assets/uploads/')){
				mkdir(Jii::app()->basePath.'/../assets/uploads/',0777);	
			}
			if(!is_dir(Jii::app()->basePath.'/../assets/uploads/ads/')){
				mkdir(Jii::app()->basePath.'/../assets/uploads/ads/',0777);	
			}
			if(!is_dir(Jii::app()->basePath.'/../assets/uploads/ads/'.$u->ads_id)){
				mkdir(Jii::app()->basePath.'/../assets/uploads/ads/'.$u->ads_id,0777);	
			}
			$u->ads_reference = str_pad($u->ads_id, 7, "0", STR_PAD_LEFT); 
			$u->save();
			if($res){
				if(isset($_FILES["image"]) && !empty($_FILES["image"])){
					$gal = '';
					for($i=0; $i < count($_FILES['image']['name']);$i++){
						if(isset($_FILES["image"]["name"][$i]) && !empty($_FILES["image"]["name"][$i])){
							$info = pathinfo($_FILES["image"]["name"][$i]);
							$newname = time().'_'.round(rand()*10000).'.'.$info['extension'];
							$success = move_uploaded_file($_FILES["image"]["tmp_name"][$i], Jii::app()->basePath.'/../assets/uploads/ads/'.$u->ads_id.'/'.$newname);
							if($success){
								if($i == 0){
									$gal .= $newname;
								}else{
									$gal .= ','.$newname;
								}
								$u->ads_gallery = $gal;
								$res = $u->save();
							}
						}
					}
				}
				
				$subject = 'Thank you for placing your ad on SoChivi!';
				
				$line1 = 'Thank you for placing your ad for ('.$u->ads_name.') on SoChivi.<br><br> ';
				
				$line2 = 'If you wish to view, edit or delete your post, please go to the following link:<br> <a href="http://sochivi.com/'.Jii::app()->createUrl('web/adspreview',array('adsid'=>$u->ads_id)).'">http://sochivi.com/'.Jii::app()->createUrl('web/adspreview',array('adsid'=>$u->ads_id)).'</a><br /><br />';
				
				$line3 = 'Kindly refrain from disclosing your personal or financial information - do not proceed with any type of payment unless when meeting the seller face-to-face and receiving the goods or services you are paying for.
				<br><br>At SoChivi, we work hard to ensure you have a secure experience, therefore please report any suspicious activity immediately.
				<br><br>In the meantime, enjoy trading and stay safe!
				<br><br>The SoChivi Team';
				
				$message = $line1.$line2.$line3;
				
				$member = Member::model()->findByPk($u->ads_memberid);
				
				$email_from = 'info@sochivi.com';
				// Is the OS Windows or Mac or Linux 
				if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
					$eol="\r\n"; 
				} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
					$eol="\r"; 
				} else { 
					$eol="\n"; 
				}
				// Common Headers 
				$headers  = '';
				$headers .= 'From: '.$email_from.''.$eol; 
				$headers .= 'Cc: info@sochivi.com'.$eol;
				$headers .= 'Reply-To: '.$email_from.' <'.$email_from.'>'.$eol; 
				$headers .= 'Return-Path: '.$email_from.' <'.$email_from.'>'.$eol;     // these two to set reply address 
				$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
				$headers .= "X-Mailer: PHP/".phpversion().$eol;           // These two to help avoid spam-filters 
				// Boundry for marking the split & Multitype Headers 
				$mime_boundary = md5(time()); 
				$headers .= 'MIME-Version: 1.0'.$eol; 
				$headers .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol; 
				ini_set('sendmail_from',$email_from);  // the INI lines are to force the From Address to be used ! 
					//$send = mail($member->mbr_email, $subject, $message, $headers); 
				ini_restore('sendmail_from');
				
				//Log::success('The ads has been added successfully');
			}else{
				Log::error('The ads has not been added successfully');
			}
			//$this->redirect(array('web/index'),array());
			$this->redirect(array('web/adspreview','adsid'=>$u->ads_id));
		}else{
			Log::error('You must register!!');
			$this->redirect(array('web/index'));
		}
	}
	
	public function actionConfirmads(){
		if(Jii::isAjax()){
		
			$data = array();
			$ads = Ads::model()->findByPk(Jii::param('adsid'));
			if(!empty($ads)){
				$ads->ads_status = Ads::status()->getItem('pending')->getValue();
				$res = $ads->save();
				
				if($res){
					$subject = 'Thank you for placing your ad on SoChivi!';
				
					$line1 = 'Thank you for placing your ad for ('.$ads->ads_name.') on SoChivi.<br><br> ';
					
					$line2 = 'If you wish to view, edit or delete your post, please go to the following link:<br> <a href="http://sochivi.com/'.Jii::app()->createUrl('web/adspreview',array('adsid'=>$ads->ads_id)).'">http://sochivi.com/'.Jii::app()->createUrl('web/adspreview',array('adsid'=>$ads->ads_id)).'</a><br /><br />';
					
					$line3 = 'Kindly refrain from disclosing your personal or financial information - do not proceed with any type of payment unless when meeting the seller face-to-face and receiving the goods or services you are paying for.
					<br><br>At SoChivi, we work hard to ensure you have a secure experience, therefore please report any suspicious activity immediately.
					<br><br>In the meantime, enjoy trading and stay safe!
					<br><br>The SoChivi Team';
					
					$message = $line1.$line2.$line3;
					
					$member = Member::model()->findByPk($ads->ads_memberid);
					
					$email_from = 'info@sochivi.com';
					// Is the OS Windows or Mac or Linux 
					if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
						$eol="\r\n"; 
					} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
						$eol="\r"; 
					} else { 
						$eol="\n"; 
					}
					// Common Headers 
					$headers  = '';
					$headers .= 'From: '.$email_from.''.$eol; 
					$headers .= 'Cc: info@sochivi.com'.$eol;
					$headers .= 'Reply-To: '.$email_from.' <'.$email_from.'>'.$eol; 
					$headers .= 'Return-Path: '.$email_from.' <'.$email_from.'>'.$eol;     // these two to set reply address 
					$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
					$headers .= "X-Mailer: PHP/".phpversion().$eol;           // These two to help avoid spam-filters 
					// Boundry for marking the split & Multitype Headers 
					$mime_boundary = md5(time()); 
					$headers .= 'MIME-Version: 1.0'.$eol; 
					$headers .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol; 
					ini_set('sendmail_from',$email_from);  // the INI lines are to force the From Address to be used ! 
						$send = mail($member->mbr_email, $subject, $message, $headers); 
					ini_restore('sendmail_from');
				}
				
				
				$data['id'] = $ads->ads_id;
				echo json_encode($data);
			}
		}
	}
	
	public function actionDeleteads(){
		if(Jii::isAjax()){
		
			$data = array();
			$ads = Ads::model()->findByPk(Jii::param('adsid'));
			if(!empty($ads)){
				$ads->ads_status = Ads::status()->getItem('disable')->getValue();
				$ads->save();
				$data['id'] = $ads->ads_id;
				echo json_encode($data);
			}
		}
	}
	
	public function actionEditads(){
		if(Jii::param('adsid') && !Jii::param('id')){
			$ads = Ads::model()->findByPk(Jii::param('adsid'));
			
			//if(!Jii::app()->user->isGuest && isset(Jii::app()->user->id) && !empty(Jii::app()->user->id) && (Jii::app()->user->id == $ads->ads_memberid)){
				$criteria = new CDbCriteria;
				$criteria->addCondition('itm_id = '.$ads->ads_itemid);
				$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
				$item = Item::model()->find($criteria);
				
				if(isset($item->itm_formid) && $item->itm_formid > 0){
					$this->render('adsform',array('item'=>$item,'ads_id'=>Jii::param('adsid')));
				}
			/*}else{
				Log::error('Please login to edit your ad!!');
				$this->redirect(array('web/index'));
			}*/
		}else if(Jii::param('id') && Jii::param('itemid')){
			$member = Member::model()->findByPk(Jii::app()->user->id);
			/*if(isset($member) && !empty($member)){
				$location = $member->mbr_locationid;
				$map = $member->mbr_address;
				if(isset($location) && !empty($location)) $u->ads_locationid = $location;
				if(isset($map) && !empty($map)) $u->ads_map = $map;
			}*/
			//if(!Jii::app()->user->isGuest && isset(Jii::app()->user->id) && !empty(Jii::app()->user->id) && (Jii::app()->user->id == $member->mbr_id)){
				$user = self::Saveform();
				$u = Ads::model()->findByPk(Jii::param('adsid'));
				$u->ads_itemid = Jii::param('itemid');
				$u->ads_saverequestkey = $user;
				//if(isset($_POST['reference'])) $u->ads_reference = $_POST['reference'];
				if(isset($_POST['name'])) $u->ads_name = $_POST['name'];
				if(isset($_POST['price'])) $u->ads_price = $_POST['price'];
				
				if(isset($_POST['phone_number'])){
					if($_POST['phone_number'] == 'phone1'){
						$u->ads_phone = $member->mbr_phone;
					}else if($_POST['phone_number'] == 'phone2'){
						if(isset($_POST['newphone'])){
							$u->ads_phone = $_POST['newphone'];
						}else{
							$u->ads_phone = '';
						}
					}else{
						$u->ads_phone = '';
					}
				}
				
				/*if(isset($_POST['description'])) $u->ads_description = $_POST['description'];
				$u->ads_memberid = Jii::app()->user->id;*/
				
				if(isset($_POST['description'])) $u->ads_description = strip_tags($_POST['description'], '<br>');
				//$u->ads_memberid = Jii::app()->user->id;
				
				if(isset($_POST['area']) && !empty($_POST['area'])){
					$u->ads_locationid = $_POST['area'];
				}else if(isset($_POST['city']) && !empty($_POST['city'])){
					$u->ads_locationid = $_POST['city'];
				}else if(isset($_POST['country'])  && !empty($_POST['country'])){
					$u->ads_locationid = $_POST['country'];
				}
				if(isset($_POST['address_mapping'])) $u->ads_map = $_POST['address_mapping'];
				
				if(isset($_POST['currency'])) $u->ads_currencyid = $_POST['currency'];
				//$u->ads_status = Ads::status()->getItem('draft')->getValue();
				$res = $u->save();
				if(!is_dir(Jii::app()->basePath.'/../assets/uploads/')){
					mkdir(Jii::app()->basePath.'/../assets/uploads/',0777);	
				}
				if(!is_dir(Jii::app()->basePath.'/../assets/uploads/ads/')){
					mkdir(Jii::app()->basePath.'/../assets/uploads/ads/',0777);	
				}
				if(!is_dir(Jii::app()->basePath.'/../assets/uploads/ads/'.$u->ads_id)){
					mkdir(Jii::app()->basePath.'/../assets/uploads/ads/'.$u->ads_id,0777);	
				}
				if($res){
					if(isset($_FILES["image"]) && !empty($_FILES["image"])){
						$gal = '';
						for($i=0; $i < count($_FILES['image']['name']);$i++){
							if(isset($_FILES["image"]["name"][$i]) && !empty($_FILES["image"]["name"][$i])){
								$info = pathinfo($_FILES["image"]["name"][$i]);
								$newname = time().'_'.round(rand()*10000).'.'.$info['extension'];
								$success = move_uploaded_file($_FILES["image"]["tmp_name"][$i], Jii::app()->basePath.'/../assets/uploads/ads/'.$u->ads_id.'/'.$newname);
								if($success){
									if($i == 0){
										$gal .= $newname;
									}else{
										$gal .= ','.$newname;
									}
									$u->ads_gallery = $gal;
									$res = $u->save();
								}
							}
						}
					}
					//Log::success('The ads has been added successfully');
				}else{
					Log::error('The ads has not been added successfully');
				}
				//$this->redirect(array('web/index'),array());
				$this->redirect(array('web/adspreview','adsid'=>$u->ads_id));
			/*}else{
				Log::error('Please login to edit your ad!!');
				$this->redirect(array('web/index'));
			}*/
		}
	}
	
	public function actionAdspreview(){
		
		if(Jii::param('adsid')){
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_id = '.Jii::param('adsid'));
			//$criteria->addCondition('ads_status = '.Ads::status()->getItem('draft')->getValue());
			$ads = Ads::model()->find($criteria);
			
			//if(!Jii::app()->user->isGuest && isset(Jii::app()->user->id) && !empty(Jii::app()->user->id) && (Jii::app()->user->id == $ads->ads_memberid)){
				$model = new EmailForm;
				$model->setScenario('create');
				Jii::ajaxValidation($model);
				if(Jii::param(get_class($model))){
					$model->attributes = Jii::param(get_class($model));
					if($model->validate()){
						$name = $model->name;
						$email = $model->email;
						$subject = 'We have an inquiry for you on SoChivi for ('.$ads->ads_name.')';
						
						$name = (isset($model->name))? 'Name: '.$model->name.'<br />':'';
						$email = (isset($model->email))? 'Email: '.$model->email.'<br />':'';
						$phone = (isset($model->phone))? 'Business phone: '.$model->phone.'<br />':'';
						
						$line1 = 'You have received the following enquiry on your ad for ('.$ads->ads_name.') from:<br> '.$name.$email.$phone;
						$line2 = (isset($model->message))? 'Message: '.$model->message.'<br /><br />':'';
						$line3 = 'If you wish to view, edit or delete your post, please go to the following link:<br> <a href="http://sochivi.com'.Jii::app()->createUrl('web/adspreview',array('adsid'=>Jii::param('adsid'))).'">http://sochivi.com'.Jii::app()->createUrl('web/adspreview',array('adsid'=>Jii::param('adsid'))).'</a><br /><br />';
						$line4 = 'Kindly refrain from disclosing your personal or financial information - do not proceed with any type of payment unless when meeting the seller face-to-face and receiving the goods or services you are paying for.<br><br>The SoChivi Team';
						
						$message = $line1.$line2.$line3.$line4;
						
						$member = Member::model()->findByPk($ads->ads_memberid);
						
						$email_from = 'info@sochivi.com';
						// Is the OS Windows or Mac or Linux 
						if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
							$eol="\r\n"; 
						} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
							$eol="\r"; 
						} else { 
							$eol="\n"; 
						}
						// Common Headers 
						$headers  = '';
						$headers .= 'From: '.$email_from.''.$eol; 
						$headers .= 'Cc: info@sochivi.com'.$eol;
						$headers .= 'Reply-To: '.$email_from.' <'.$email_from.'>'.$eol; 
						$headers .= 'Return-Path: '.$email_from.' <'.$email_from.'>'.$eol;     // these two to set reply address 
						$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
						$headers .= "X-Mailer: PHP/".phpversion().$eol;           // These two to help avoid spam-filters 
						// Boundry for marking the split & Multitype Headers 
						$mime_boundary = md5(time()); 
						$headers .= 'MIME-Version: 1.0'.$eol; 
						$headers .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol; 
						ini_set('sendmail_from',$email_from);  // the INI lines are to force the From Address to be used ! 
							$send = mail($member->mbr_email, $subject, $message, $headers); 
						ini_restore('sendmail_from');
					}
				}
				
				$modelfriend = new EmailfriendForm;
				$modelfriend->setScenario('create');
				Jii::ajaxValidation($modelfriend);
				if(Jii::param(get_class($modelfriend))){
					$modelfriend->attributes = Jii::param(get_class($modelfriend));
					if($modelfriend->validate()){
						
						$email_from = $modelfriend->email_from;
						$name_from = $modelfriend->name_from;
						
						$email_to = $modelfriend->email_to;
						$name_to = $modelfriend->name_to;
						
						$subject = 'I found this on sochivi.com';
						
						$name = (isset($modelfriend->name_from))? 'From: '.$modelfriend->name_from.'<br />':'';
						$textmessage = (isset($modelfriend->message))? 'Hey '.$name_to.',<br />'.$modelfriend->message.'<br /><a href="http://sochivi.com/'.Jii::app()->createUrl('item/preview',array('itemid'=>Jii::param('itemid'),'adsid'=>Jii::param('adsid'))).'">Check The Ad</a>':'';
						
						$message = $name.$textmessage;
						
						
						// Is the OS Windows or Mac or Linux 
						if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
							$eol="\r\n"; 
						} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
							$eol="\r"; 
						} else { 
							$eol="\n"; 
						}
						// Common Headers 
						$headers  = '';
						$headers .= 'From: '.$email_from.''.$eol; 
						$headers .= 'Cc: info@sochivi.com'.$eol;
						$headers .= 'Reply-To: '.$name.' <'.$email_from.'>'.$eol; 
						$headers .= 'Return-Path: '.$name.' <'.$email_from.'>'.$eol;     // these two to set reply address 
						$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
						$headers .= "X-Mailer: PHP/".phpversion().$eol;           // These two to help avoid spam-filters 
						// Boundry for marking the split & Multitype Headers 
						$mime_boundary = md5(time()); 
						$headers .= 'MIME-Version: 1.0'.$eol; 
						$headers .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol; 
						ini_set('sendmail_from',$email_from);  // the INI lines are to force the From Address to be used ! 
							$send = mail($email_to, $subject, $message, $headers); 
						ini_restore('sendmail_from');
						if($send){
							// Common Headers 
							$headers2  = '';
							$headers2 .= 'From: info@sochivi.com'.$eol; 
							$headers2 .= 'Cc: info@sochivi.com'.$eol;
							$headers2 .= 'Reply-To: info@sochivi.com <info@sochivi.com>'.$eol; 
							$headers2 .= 'Return-Path: info@sochivi.com <info@sochivi.com>'.$eol;     // these two to set reply address 
							$headers2 .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
							$headers2 .= "X-Mailer: PHP/".phpversion().$eol;           // These two to help avoid spam-filters 
							// Boundry for marking the split & Multitype Headers 
							$mime_boundary = md5(time()); 
							$headers2 .= 'MIME-Version: 1.0'.$eol; 
							$headers2 .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol; 
							ini_set('sendmail_from','info@sochivi.com');  // the INI lines are to force the From Address to be used ! 
								$send2 = mail($email_from, 'Your email was successfully sent', 'Your email to '.$email_to.' was successfully sent', $headers2); 
							ini_restore('sendmail_from');
						}
						
					}
				}
				
				$this->render('preview',array('ads'=>$ads,'model'=>$model,'modelfriend'=>$modelfriend));
			/*}else{
				Log::error('Please login to view your ad!!');
				$this->redirect(array('web/index'));
			}*/
		}else{
			$this->redirect(array('web/index'));
		}
	}
	
	public function actionMyads()
	{
		$this->pageTitle = Jii::t('Item List PAGE');
		//if(Jii::param('itemid')){
		if(!Jii::app()->user->isGuest && isset(Jii::app()->user->id) && !empty(Jii::app()->user->id)){
			$member = Member::model()->findByPk(Jii::app()->user->id);
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_status in ('.Ads::status()->getItem('enable')->getValue().','.Ads::status()->getItem('pending')->getValue().','.Ads::status()->getItem('draft')->getValue().')');
			$criteria->addCondition('ads_memberid = '.$member->mbr_id);
			if(Jii::param('locationid')){
				$subcriteria = new CDbCriteria;
				$subcriteria->addCondition('loc_parentid = '.Jii::param('locationid'));
				$locations = Location::model()->findAll($subcriteria);
				
				if(!empty($locations) && is_array($locations)){
					$lists = CHtml::ListData($locations,'loc_id','loc_id');
					$c = count($lists);
					$lists[$c++] = Jii::param('locationid');
					$criteria->addCondition('ads_locationid in ('.implode(',',$lists).')');
				}else{
					$criteria->addCondition('ads_locationid = '.Jii::param('locationid'));
				}
			}
			$criteria->order = 'ads_id DESC';
			if(Jii::param('sort') && Jii::param('order')){
				$criteria->order = Jii::param('sort').' '.Jii::param('order');
			}
			
			$pages = new CPagination(Ads::model()->count($criteria));
			if(isset($this->data['page']) && $this->data['page'] > 0){
				$pages -> setCurrentPage($this->data['page']-1);
			}
			$pages -> pageSize = (Jii::param('number_ads') > 0)?Jii::param('number_ads'):5;
			$pages -> applyLimit($criteria);
			$pages->params = array('sort'=>Jii::param('sort'),'order'=>Jii::param('order'),'number_ads'=>Jii::param('number_ads'));
			
			$listads = Ads::model()->findAll($criteria);
			
			
			$this->render('mylist',array('listads'=>$listads,'pages'=>$pages));
		}else{
			Log::error('You must login or register!!');
			$this->redirect(array('web/index'));
		}
	}
	
	public function actionMyfavorites()
	{
		$this->pageTitle = Jii::t('Item List PAGE');
		//if(Jii::param('itemid')){
		if(!Jii::app()->user->isGuest && isset(Jii::app()->user->id) && !empty(Jii::app()->user->id)){
			$member = Member::model()->findByPk(Jii::app()->user->id);
			
			$criteria = new CDbCriteria();
			$criteria->addCondition('fav_memberid = '.Jii::app()->user->id);
			$fav = Favorite::model()->findAll($criteria);
			$list = CHtml::ListData($fav,'fav_adid','fav_adid');
			$list[] = 0;
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_id in ('.implode(',',$list).')');
			$criteria->addCondition('ads_status ='.Ads::status()->getItem('enable')->getValue());
			if(Jii::param('locationid')){
				$subcriteria = new CDbCriteria;
				$subcriteria->addCondition('loc_parentid = '.Jii::param('locationid'));
				$locations = Location::model()->findAll($subcriteria);
				
				if(!empty($locations) && is_array($locations)){
					$lists = CHtml::ListData($locations,'loc_id','loc_id');
					$c = count($lists);
					$lists[$c++] = Jii::param('locationid');
					$criteria->addCondition('ads_locationid in ('.implode(',',$lists).')');
				}else{
					$criteria->addCondition('ads_locationid = '.Jii::param('locationid'));
				}
			}
			$criteria->order = 'ads_id DESC';
			if(Jii::param('sort') && Jii::param('order')){
				$criteria->order = Jii::param('sort').' '.Jii::param('order');
			}
			
			$pages = new CPagination(Ads::model()->count($criteria));
			if(isset($this->data['page']) && $this->data['page'] > 0){
				$pages -> setCurrentPage($this->data['page']-1);
			}
			$pages -> pageSize = (Jii::param('number_ads') > 0)?Jii::param('number_ads'):5;
			$pages -> applyLimit($criteria);
			$pages->params = array('sort'=>Jii::param('sort'),'order'=>Jii::param('order'),'number_ads'=>Jii::param('number_ads'));
			
			$listads = Ads::model()->findAll($criteria);
			
			
			$this->render('myfavorites',array('listads'=>$listads,'pages'=>$pages));
		}else{
			$this->redirect(array('web/index'));
		}
	}
	
	public function Saveform(){
		$user = $_SERVER['REMOTE_ADDR'].'_'.$_SERVER['REQUEST_TIME'];
		$fields = Jii::param('field');
		if(Jii::param('id') && $fields && !empty($fields) && is_array($fields)){
			$criteria = new CDbCriteria;
			$criteria->addCondition('form_id = '.Jii::param('id'));
			$criteria->with = array('section'=>array('with'=>array('field')));
			$criteria->addCondition('form_status = '.Form::status()->getItem('publish')->getValue());
			$form = Form::model()->with()->find($criteria);
			if(Form::sendto()->equal('email',$form->form_sendto) && trim($form->form_email) != ''){ // send to email
				// Is the OS Windows or Mac or Linux 
				if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
					$eol="\r\n"; 
				} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
					$eol="\r"; 
				} else { 
					$eol="\n"; 
				}
				// Common Headers 
				$headers  = '';
				//$headers .= 'From: '.$email.''.$eol; 
				//$headers .= 'Reply-To: '.$name.' <'.$email.'>'.$eol; 
				//$headers .= 'Return-Path: '.$name.' <'.$email.'>'.$eol;
				$headers .= 'Cc: info@sochivi.com'.$eol;
				$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
				$headers .= "X-Mailer: PHP/".phpversion().$eol;
				$mime_boundary = md5(time()); 
				$headers .= 'MIME-Version: 1.0'.$eol; 
				$headers .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol;

				$message = '';
				if(isset($form->section) && is_array($form->section) && !empty($form->section)){
					$message .= '<table style="width:100%;">';
					foreach($form->section AS $section){
						$message .= '<tr><th colspan="2" style="background:#fabc00; color:#874700; padding:5px;">'.$section->sec_title.'</th></tr>';
						if(isset($section->field) && is_array($section->field) && !empty($section->field)){
							foreach($section->field AS $field){
								$message .= '<tr>';
									$message .= '<td style="padding:5px; border-bottom:1px solid #874700;"><b style="color:#227db6;">'.$field->fld_label.'</b></td>';
									$message .= '<td style="color:#2f2f2f; padding:5px; border-bottom:1px solid #874700;">'.$fields[$field->fld_id].'</td>';
								$message .= '</tr>';
							}
						}
					}
					$message .= '</table>';
				}
				ini_set('sendmail_from',$email);
					$send = mail($form->form_email, $form->form_title.' #'.$form->form_id, $message, $headers);
				ini_restore('sendmail_from');
			}
			foreach($fields AS $id=>$value){
				$s = new FormSave;
				$s->save_fieldid = $id;
				if(is_array($value) && !empty($value)){
					$s->save_value =  json_encode($value);
				}else{
					$s->save_value = $value;
				}
				$s->save_requestkey = $user;
				$res = $s->save();
			}			
		}
		return $user;
	}
	
	
	
	public function actionLogout(){
		Log::trace('User loged out');
		$location_log_id = Jii::app()->user->location;
		Jii::app()->user->logout();
		
		$cookie = new CHttpCookie('location', $location_log_id);
		$cookie->expire = time()+60*60*24*180; 
		Yii::app()->request->cookies['location'] = $cookie;
		//Jii::app()->user->setState('location',$location_log_id);
		$this->redirect(array('web/index'));	
	}
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionForgotPassword(){
		$this->pageTitle = Jii::t('Forgot Password','User');
		$model = new ForgotPasswordForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$user = Member::model()->findByAttributes(array('mbr_email'=>$model->email));
				if(isset($user->mbr_id)){
					$token = md5($user->mbr_id.'!@#$'.time().'%^&*'.$model->email);
					$user->mbr_token = $token;
					$res = $user->save();
					if($res){
						$mail = new PHPMailer;
						
						$mail->From = 'info@sochivi.com';
						$mail->FromName = Jii::t('SoChivi');
						$mail->addAddress($model->email);
						$mail->addReplyTo('info@sochivi.com', Jii::t('SoChivi'));
						
						$mail->isHTML(true); 
						
						$mail->Subject = 'Request to reset your password on SoChivi';
						$mail->Body    = '
							'.$user->mbr_firstname.' '.$user->mbr_lastname.',<br/><br/>

							To reset your password, click on the below link:<br/>

							<a href="'.Jii::app()->createAbsoluteUrl('web/resetpassword',array('tok'=>$token)).'">Reset Password</a><br/>

							Your password will be automatically reset, and a new password will be emailed to you.<br/><br/>

							If you did not request a password reset, click on the below link to ignore this message :<br/>
							
							<a href="'.Jii::app()->createAbsoluteUrl('web/ignorereset',array('tok'=>$token)).'">Ignore Reset Password</a><br/>

							<br/><br/>
							The SoChivi Team
						';
						
						if(!$mail->send()) {
						   $this->render('forgotPassword',array('model'=>$model));
						   exit;
						}
						$this->redirect(array('web/index'));
					}
				}else{
					$this->render('forgotPassword',array('model'=>$model));
				}
			}else{
				$this->render('forgotPassword',array('model'=>$model));
			}
		}else{
			$this->render('forgotPassword',array('model'=>$model));
		}
	}
	
	public function actionResetPassword(){
		$token = Jii::param('tok');
		$user = Member::model()->findByAttributes(array('mbr_token'=>$token));
		if(isset($user->mbr_id)){
			$newpassword = $this->randomPassword();
			$password = new Password($newpassword);
			$user->mbr_hashpassword = $password->getHash();
			$user->mbr_saltpassword = $password->getSalt();
			$user->mbr_token = "";
			$res = $user->save();
			if($res){
				$mail = new PHPMailer;
						
				$mail->From = 'info@sochivi.com';
				$mail->FromName = Jii::t('SoChivi');
				$mail->addAddress($user->mbr_email);
				$mail->addReplyTo('info@sochivi.com', Jii::t('SoChivi'));
				
				$mail->isHTML(true); 
				
				$mail->Subject = 'New Password';
				$mail->Body    = '
					'.$user->mbr_firstname.' '.$user->mbr_lastname.',<br/>

					Use this temporary password to login and change it from your profile.<br/>
					
					<br/><br/>
					<b>'.$newpassword.'</b>
					
					<br/><br/>
					The SoChivi Team
				';
				if(!$mail->send()) {
				   $this->render('notfound');
				   exit;
				}
			}
		}else{
			$this->render('notfound');
			exit;
		}
		$this->redirect(array('web/index'));
		
	}
	
	public function actionIgnoreReset(){
		$token = Jii::param('tok');
		$user = Member::model()->findByAttributes(array('mbr_token'=>$token));
		if(isset($user->mbr_id)){
			$user->mbr_token = "";
			$res = $user->save();
			if($res){
				$mail = new PHPMailer;
						
				$mail->From = 'info@sochivi.com';
				$mail->FromName = Jii::t('SoChivi');
				$mail->addAddress($user->mbr_email);
				$mail->addReplyTo('info@sochivi.com', Jii::t('SoChivi'));
				
				$mail->isHTML(true); 
				
				$mail->Subject = 'Ignore Reset Password';
				$mail->Body    = '
					'.$user->mbr_firstname.' '.$user->mbr_lastname.',<br/>

					Your reset password has been ignored successfully.<br/>
					
					<br/><br/>
					The SoChivi Team
				';
				if(!$mail->send()) {
				   $this->render('notfound');
				   exit;
				}
			}
		}else{
			$this->render('notfound');
			exit;
		}
		$this->redirect(array('web/index'));
		
	}
	
	private function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
}