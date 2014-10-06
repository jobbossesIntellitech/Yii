<?php
class Log extends CActiveRecord{
	const TRACE   = 0x00;
	const SUCCESS = 0x01;
	const ERROR   = 0x02;
	const WARNING = 0x03;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'admin_logs';
	}
	public function relations()
	{
		return array(
					
					'user'=>array(self::BELONGS_TO, 'User', 'log_userid'),
					
				);	
	}
	
	private static function set($message,$type){
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$l = new self;
		$l->log_message = $message;
		$l->log_ip = $_SERVER['REMOTE_ADDR'];
		$l->log_useragent = $_SERVER['HTTP_USER_AGENT'];
		$l->log_date = date('Y-m-d H:i:s');
		$l->log_userid = (Jii::app()->user->isGuest)?0:Jii::app()->user->id;
		$l->log_url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$l->log_type = $type;
		return $l->save();
	}
	
	private static function buildMessageView($type){
		 if (Jii::app()->user->hasFlash($type)){ 
			echo '<div class="message-box"><div class="'.$type.'">'.Jii::app()->user->getFlash($type).'</div></div>';
			Jii::app()->clientScript->registerScript('myHideEffect','$(".message-box").animate({opacity: 1.0}, 10000).fadeOut("slow");',CClientScript::POS_READY);
		}		
	}
	
	public static function trace($message){
		return self::set($message,self::TRACE);
	}
	
	public static function success($message){
		Jii::app()->user->setFlash('success', Jii::t($message));
		return self::set($message,self::SUCCESS);	
	}
	
	public static function error($message){
		Jii::app()->user->setFlash('error', Jii::t($message));
		return self::set($message,self::ERROR);		
	}
	
	public static function warning($message){
		Jii::app()->user->setFlash('warning', Jii::t($message));
		return self::set($message,self::WARNING);		
	}
	
	public static function messageView(){
		self::buildMessageView('success');
		self::buildMessageView('error');
		self::buildMessageView('warning');	
	}
	
	public static function type($k = NULL){
		$list = array();
		$list[self::TRACE] = Jii::t('Trace');
		$list[self::SUCCESS] = Jii::t('Success');
		$list[self::ERROR] = Jii::t('Error');
		$list[self::WARNING] = Jii::t('Warning');
		if($k == NULL){
			return $list;	
		}else{
			return (isset($list[$k]))?$list[$k]:'--';	
		}	
	}
}
?>