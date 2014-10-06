<?php
class FormgeneratorController extends Controller{
	
	public function actionSave(){
		$user = $_SERVER['REMOTE_ADDR'].'_'.$_SERVER['REQUEST_TIME'];
		$fields = Jii::param('field');
		if(Jii::param('id') && $fields && !empty($fields) && is_array($fields)){
			$criteria = new CDbCriteria;
			$criteria->addCondition('form_id = '.Jii::param('id'));
			$criteria->with = array('section'=>array('with'=>array('field')));
			$criteria->addCondition('form_status = '.Form::status()->getItem('publish')->getValue());
			$form = Form::model()->with()->find($criteria);
			if(Form::sendto()->equal('email',$form->form_sendto) && trim($form->form_email) != ''){ // send to email
				
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
				ini_set('sendmail_from',$form->form_email);
					$send = mail($form->form_email, 'Thank you for contacting us on SoChivi!', $message, $headers);
				ini_restore('sendmail_from');
				
				if($send){
					$subject = 'Thank you for contacting us on SoChivi!';
					$message = 'Thank you for contacting us on SoChivi, your email was successfully received and we will revert back to you as soon as possible.';
					ini_set('sendmail_from',$email_from);
						$send = mail($fields[267], $subject, $message, $headers);
					ini_restore('sendmail_from');
					
				}
			}
			foreach($fields AS $id=>$value){
				$s = new FormSave;
				$s->save_fieldid = $id;
				$s->save_value = $value;
				$s->save_requestkey = $user;
				$res = $s->save();	
			}
		}
		Log::success('The email has been sent successfully');
		$this->redirect(Jii::app()->request->urlReferrer);
	}
	
	public function actionView(){
		if( Jii::param('id') ){
			$this->render('view',array('id'=>Jii::param('id')));
		}else{
			$this->redirect(Jii::app()->request->urlReferrer);
		}
	}
	
}
?>