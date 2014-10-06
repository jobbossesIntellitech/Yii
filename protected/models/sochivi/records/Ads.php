<?php
class Ads extends JActiveRecord{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'_ads';
	}
	public function relations()
	{
		return array(
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
					'location'=>array(self::BELONGS_TO,'Location','ads_locationid'),
					'item'=>array(self::BELONGS_TO,'Item','ads_itemid'),
					'member'=>array(self::BELONGS_TO,'Member','ads_memberid'),
					'currency'=>array(self::BELONGS_TO,'Currency','ads_currencyid'),
					'saves'=>array(self::HAS_MANY,'FormSave','ads_saverequestkey'),
				);	
	}
	
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('draft',0x00,Jii::t('Draft'),'Draft Item');
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable Item');
			self::$status->add('pending',0x02,Jii::t('Pending'),'Pending Item');
			self::$status->add('disable',0x03,Jii::t('Disable'),'Disable Item');
		}
		return self::$status;	
	}
	
	public static function adsconfirmation($adsid){
		$u = Ads::model()->findByPk($adsid);
		if(isset($u->ads_id)){
			$subject = 'Thank you for placing your ad on SoChivi!';
					
			$line1 = 'Thank you for placing your ad for ('.$u->ads_name.') on SoChivi.<br><br> ';
			
			
			$link = Jii::app()->createAbsoluteUrl('web/adspreview',array('adsid'=>$u->ads_id));
			$link = str_replace('/admin.php','',$link);
			
			$line2 = 'If you wish to view, edit or delete your post, please go to the following link:<br> <a href="'.$link.'">'.$link.'</a><br /><br />';
			
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
				$send = mail($member->mbr_email, $subject, $message, $headers); 
			ini_restore('sendmail_from');
		}
	}
	
	
	public static function urlOptions($id,$itemid, $title,$foreTitle = false){
		$title = trim(str_replace(array(' ','/','#','!','@','$','%','^','&','*','(',')','[',']','{','}','\\','.'),'_',$title));
		$list = array();
		$list['itemid'] = $itemid;
		$list['adsid'] = $id;
		$find = false;
		$last = '';
		if(Jii::param('_l1')){
			$list['_l1'] = Jii::param('_l1');
			$last = '_l1';
		}/*else{
			if(!$find && !empty($title)){
				$list['_l1'] = $title;
				$find = true;
			}
		}*/
		
		if(Jii::param('_l2')){
			$list['_l2'] = Jii::param('_l2');
			$last = '_l2';
		}/*else{
			if(!$find && !empty($title)){
				$list['_l2'] = $title;
				$find = true;
			}
		}*/
		
		if(Jii::param('_l3')){
			$list['_l3'] = Jii::param('_l3');
			$last = '_l3';
		}/*else{
			if(!$find && !empty($title)){
				$list['_l3'] = $title;
				$find = true;
			}
		}*/
		
		if(Jii::param('_l4')){
			$list['_l4'] = Jii::param('_l4');
			$last = '_l4';
		}/*else{
			if(!$find && !empty($title)){
				$list['_l4'] = $title;
				$find = true;
			}
		}*/
		
		/*if(Jii::param('_a')){
			$list['_a'] = Jii::param('_a');
			$last = '_a';
		}else{
			if(!$find && !empty($title)){
				$list['_a'] = $title;
				$find = true;
			}
		}*/
		
		if(!$find && !empty($title)){
			$list['_a'] = $title;
			$find = true;
		}
		
		if(!empty($last) && $foreTitle){
			$list[$last] = $title;
		}
		
		return $list;
	}
	
	public static function completeUrlOptions($breadcrumb,$options){
		$breadcrumb = explode('>',$breadcrumb);
		$list = array();
		foreach($breadcrumb AS $i=>$b){
			$list['_l'.($i+1)] = trim($b);
		}
		return $options+$list;
	}
}
?>