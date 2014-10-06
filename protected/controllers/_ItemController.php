<?php
class ItemController extends Controller
{
	public function actionList()
	{
		$this->pageTitle = Jii::t('Item List PAGE');
		if(Jii::param('itemid')){
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('itm_id = '.Jii::param('itemid'));
			$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
			//$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
			$criteria->order = 'itm_position DESC,itm_name ASC';
			$this_item = Item::model()->find($criteria);
			
			if(!empty($this_item)){
				$criteria = new CDbCriteria;
				$criteria->addCondition('itm_parentid = '.$this_item->itm_parentid);
				$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
				//$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
				$criteria->order = 'itm_position DESC,itm_name ASC';
				$samelevel = Item::model()->findAll($criteria);
				
				$parentitem = Item::model()->findByPk($this_item->itm_parentid);        
			}
			
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('itm_parentid = '.Jii::param('itemid'));
			$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
			$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
			$criteria->order = 'itm_position DESC,itm_name ASC';
			$subcat = Item::model()->findAll($criteria);
			
			/*$criteria = new CDbCriteria;
			$criteria->addCondition('itm_parentid = '.Jii::param('itemid'));
			$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
			$criteria->addCondition('itm_type = '.Item::type()->getItem('item')->getValue());
			$criteria->order = 'itm_position DESC,itm_name ASC';
			$subitems = Item::model()->findAll($criteria);*/
			
			
			$table = array();
			//$table = Item::model()->detect_items(Jii::param('itemid'),$table,0);
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
			
			$list_subcat = Item::model()->getchildren(Jii::param('itemid'));
			
			if(!empty($list_subcat) && is_array($list_subcat)){
				$criteria->addCondition('ads_itemid in ('.implode(',',$list_subcat).','.Jii::param('itemid').')');
			}else{
				$criteria->addCondition('ads_itemid = '.Jii::param('itemid'));
			}	
			
			
			$childrens = Location::model()->getchildren(Jii::app()->user->location);
			$childrens[] = 0;
			$criteria->addCondition('ads_locationid in ('.implode(',',$childrens).','.Jii::app()->user->location.')');
			
			
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
			$pages->params = array('itemid'=>Jii::param('itemid'),'sort'=>Jii::param('sort'),'order'=>Jii::param('order'),'number_ads'=>Jii::param('number_ads'));
			
			$listads = Ads::model()->findAll($criteria);
			
			
			
			$this->render('list',array('samelevel'=>$samelevel,'parentitem'=>$parentitem,'this_item'=>$this_item,'subcat'=>$subcat,'listads'=>$listads,'pages'=>$pages));
		}else{
			$this->redirect(Jii::app()->baseUrl);
		}
		
		
	}
	
	public function actionPreview()
	{
		$this->pageTitle = Jii::t('Item PAGE');
		if(Jii::param('itemid')){
			$criteria = new CDbCriteria;
			$criteria->addCondition('itm_id = '.Jii::param('itemid'));
			$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
			//$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
			$this_item = Item::model()->find($criteria);
			
			if(!empty($this_item)){
				$criteria = new CDbCriteria;
				$criteria->addCondition('itm_parentid = '.$this_item->itm_parentid);
				$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
				//$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
				$samelevel = Item::model()->findAll($criteria);
				
				$parentitem = Item::model()->findByPk($this_item->itm_parentid);        
			}
			
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('itm_parentid = '.Jii::param('itemid'));
			$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
			$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
			$subcat = Item::model()->findAll($criteria);
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('itm_parentid = '.Jii::param('itemid'));
			$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
			$criteria->addCondition('itm_type = '.Item::type()->getItem('item')->getValue());
			$subitems = Item::model()->findAll($criteria);
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_id = '.Jii::param('adsid'));
			$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
			$ads = Ads::model()->find($criteria);
			
			$criteria = new CDbCriteria;
			$criteria->addCondition('ads_id != '.Jii::param('adsid'));
			$criteria->addCondition('ads_itemid = '.Jii::param('itemid'));
			$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
			$criteria->order = 'ads_id DESC';
			$criteria->limit = 3;
			$relatedads = Ads::model()->findAll($criteria);
			
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
					$line3 = 'If you wish to view, edit or delete your post, please go to the following link:<br> <a href="http://sochivi.com/'.Jii::app()->createUrl('web/adspreview',array('adsid'=>Jii::param('adsid'))).'">http://sochivi.com/'.Jii::app()->createUrl('web/adspreview',array('adsid'=>Jii::param('adsid'))).'</a><br /><br />';
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
			
			if(!isset($_COOKIE['ads_counter'])){
				setcookie('ads_counter', true, time()+60*60*24);
				$u = $ads;
				$u->ads_counter = $ads->ads_counter + 1;
				$res = $u->save();
			}
			
			$this->render('preview',array('samelevel'=>$samelevel,'parentitem'=>$parentitem,'this_item'=>$this_item,'subcat'=>$subcat,'subitems'=>$subitems,'ads'=>$ads,'relatedads'=>$relatedads,'model'=>$model,'modelfriend'=>$modelfriend));
		}else{
			$this->redirect(Jii::app()->baseUrl);
		}
		
		
	}
	
	public function actionSavelocation(){
		/*$json = array('country'=>'','city'=>'');
		if(Jii::param('locationid')){
			$location = Location::model()->findByPk(Jii::param('locationid'));
			if($location->loc_parentid == 0){
				$json['country'] = $location->loc_id;
				$json['city'] = '';
			}else{
				$json['country'] = $location->loc_parentid;
				$json['city'] = $location->loc_id;
			}
		}
		echo json_encode($json);*/
		if(Jii::isAjax()){
			Jii::app()->user->setState('location',Jii::param('locationid'));
			echo true;
		}
	}
	
	public function actionSavefavorite(){
		
		if(Jii::isAjax() && !Jii::app()->user->isGuest){
			//$memberid = Jii::app()->user->id;
			//Jii::param('adsid');
			$data = array();
			
			$criteria = new CDbCriteria();
			$criteria->addCondition('fav_adid = '.Jii::param('adsid'));
			$criteria->addCondition('fav_memberid = '.Jii::app()->user->id);
			$fav = Favorite::model()->find($criteria);
			
			if(!empty($fav)){
				$fav->delete();
				$data['list'] = 1;
			}else{
				$u = new Favorite;
				$u->fav_adid = Jii::param('adsid');
				$u->fav_memberid = Jii::app()->user->id;
				$res = $u->save();
				$data['list'] = 2;
			}
			echo json_encode($data);
		}
	}
	
	public function actionSearchsubcat(){
		
		$subcategories = array();
		if(Jii::param('id')){
			$criteria = new CDbCriteria();
			$criteria->addCondition('itm_parentid = '.Jii::param('id'));
			$subcategories = CHtml::ListData(Item::model()->findAll($criteria),'itm_id','itm_name');
			
		}
		UI::$id+=100;
		echo UI::selectBox('subcategory',intval(Jii::param('v')),$subcategories,'Select Sub Category','170px');
		
	}
	
	public function actionSearchcities(){
		
		$cities = array();
		if(Jii::param('id')){
			$criteria = new CDbCriteria();
			$criteria->addCondition('loc_parentid = '.Jii::param('id'));
			$cities = CHtml::ListData(Location::model()->findAll($criteria),'loc_id','loc_name');
			
		}
		UI::$id+=200;
		echo UI::selectBox('city',intval(Jii::param('v')),$cities,'Select City','170px');
		
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
}