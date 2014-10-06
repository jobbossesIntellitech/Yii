<?php
class CmsController extends Controller{
	
	public function actionView(){
		if(Jii::param('id')){
			$criteria = new CDbCriteria;
			$criteria->addCondition('con_id = '.Jii::param('id'));
			$criteria->addCondition('con_status = '.Content::status()->getItem('publish')->getValue());
			$criteria->with = array('content_lang:'.Jii::app()->language,'comment'=>array('condition'=>'com_status = '.Comment::status()->getItem('approved')->getValue()));
			$view = Content::model()->find($criteria);
			if(isset($view->con_id)){
				if(isset($view) && !empty($view)){
					$meta_title = '';
					$meta_description = '';
					$meta_keywords = '';
					
					if(!empty($view->con_metatitle))$meta_title = strip_tags($view->con_metatitle);
					if(!empty($view->con_metakeywords))$meta_keywords = strip_tags($view->con_metakeywords);
					if(!empty($view->con_metadescription))$meta_description = strip_tags($view->con_metadescription);
					JMeta::set($meta_title,$meta_keywords,$meta_description);
				}	
				
				$this->render('view',array('view'=>$view));
			}else{
				$this->redirect(Jii::app()->baseUrl);
			}
		}else{
			$this->redirect(Jii::app()->baseUrl);
		}
	}
	
	public function actionAddComment(){
		$model = new CommentForm;
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = new Comment;
				$c->com_parentid = $model->parentid;
				$c->com_user = $model->user;
				$c->com_name = $model->name;
				$c->com_email = $model->email;
				$c->com_title = $model->title;
				$c->com_text = $model->text;
				$c->com_status = Comment::status()->getItem('approved')->getValue();
				$c->com_contentid = $model->contentid;
				$c->com_likes = 0;
				$c->save();
			}
		}
		$this->redirect(Jii::app()->request->urlReferrer);
	}
	
	public function actionCategory(){
		if(Jii::param('id')){
			// sub categories
			$criteria = new CDbCriteria;
			$criteria->addCondition('cat_id = '.Jii::param('id'));
			$criteria->with = array('category_lang:'.Jii::app()->language,'children'=>array('width'=>array('category_lang:'.Jii::app()->language)));
			$category = Category::model()->find($criteria);
			if(isset($category->cat_id)){
				// category contents
				$criteria = new CDbCriteria;
				$criteria->addCondition('con_categoryid = '.Jii::param('id'));
				$criteria->addCondition('con_status = '.Content::status()->getItem('publish')->getValue());
				$criteria->with = array('content_lang:'.Jii::app()->language);
				$contents = Content::model()->findAll($criteria);
				
				$this->render('category',array('category'=>$category,'contents'=>$contents));
			}else{
				$this->redirect(Jii::app()->baseUrl);
			}
		}else{
			$this->redirect(Jii::app()->baseUrl);	
		}
	}
	
	public function actionContactUs(){
		$this->pageTitle = strtoupper('Contact US :: GCI');
		$model = new ContactForm;
		$this->ajaxValidation($model);
		if(isset($this->data['ContactForm'])){
			$model->attributes = $data = $this->data['ContactForm'];
			if($model->validate()){
				$name = $data['name'];
				$email = $data['email'];
				$subject = $data['subject'];
				$message = $data['body'];
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
				$headers .= 'From: '.$email.''.$eol; 
				$headers .= 'Reply-To: '.$name.' <'.$email.'>'.$eol; 
				$headers .= 'Return-Path: '.$name.' <'.$email.'>'.$eol;     // these two to set reply address 
				$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol; 
				$headers .= "X-Mailer: PHP/".phpversion().$eol;           // These two to help avoid spam-filters 
				// Boundry for marking the split & Multitype Headers 
				$mime_boundary = md5(time()); 
				$headers .= 'MIME-Version: 1.0'.$eol; 
				$headers .= "Content-Type: text/html; charset=utf-8; boundary=\"".$mime_boundary."\"".$eol; 
				ini_set('sendmail_from',$email);  // the INI lines are to force the From Address to be used ! 
					$send = mail(Jii::app()->params['email'], $subject, $message, $headers); 
				ini_restore('sendmail_from');	
				
				
			}
		}
		$contact = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('con_id = 2');
		$criteria->addCondition('con_status = '.Content::status()->getItem('publish')->getValue());
		$criteria->with = array('content_lang:'.Jii::app()->language,'comment'=>array('condition'=>'com_status = '.Comment::status()->getItem('approved')->getValue()));
		$view = Content::model()->find($criteria);
		if(isset($view->con_id)){
			$contact = $this->renderPartial('view',array('view'=>$view),true,true);
		}
		$this->render('contactus',array('model'=>$model,'contact'=>$contact));	
	}
	
}
?>