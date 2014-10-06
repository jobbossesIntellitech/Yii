<?php
class User extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'admin_users';
	}
	public function relations()
	{
		return array(
					'permission'=>array(self::HAS_MANY, 'PermissionTable', 'permission_userid','order'=>'usr_firstname ASC'),
					'father'=>array(self::HAS_ONE, 'User', 'usr_parent','order'=>'usr_firstname ASC'),
					'log'=>array(self::HAS_MANY,'Log','log_userid','order'=>'log_date DESC'),
					'trace'=>array(self::HAS_MANY,'Log','log_userid','condition'=>'log_type='.Log::TRACE,'order'=>'log_date DESC'),
					'success'=>array(self::HAS_MANY,'Log','log_userid','condition'=>'log_type='.Log::SUCCESS,'order'=>'log_date DESC'),
					'error'=>array(self::HAS_MANY,'Log','log_userid','condition'=>'log_type='.Log::ERROR,'order'=>'log_date DESC'),
					'warning'=>array(self::HAS_MANY,'Log','log_userid','condition'=>'log_type='.Log::WARNING,'order'=>'log_date DESC'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('enable',0x01,Jii::t('Enable'),'Enable User');
			self::$status->add('disable',0x00,Jii::t('Disable'),'Disable User');
		}
		return self::$status;	
	}
	
	public static function breadcrumb($p = 1, $first = true){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('usr_id = '.$p);
		$user = User::model()->find($criteria);
		if(isset($user->usr_id) && $user->usr_id != Jii::app()->user->id){
			$breadcrumb .= self::breadcrumb($user->usr_parent, false).' * ';
			if($first){
				$breadcrumb .= $user->usr_firstname.' '.$user->usr_lastname;	
			}else{
				$breadcrumb .= CHtml::link($user->usr_firstname.' '.$user->usr_lastname,Jii::app()->createUrl('user/index',array('f'=>$user->usr_id)));	
			}
		}else{
			if($first){
				$breadcrumb .= Jii::t('Root');	
			}else{
				$breadcrumb .= CHtml::link(Jii::t('Root'),Jii::app()->createUrl('user/index'));	
			}
		}
		return $breadcrumb;		
	}
	
	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('usr_parent = '.$this->usr_id);
		$users = User::model()->findAll($criteria);
		if(!empty($users) && is_array($users)){
			foreach($users AS $user){
				$user->delete();	
			}	
		}
		PermissionTable::model()->deleteAllByAttributes(array('permission_userid'=>$this->usr_id));	
	}

	public static function getArrayAsTree($parent = NULL,$first = true,$indent = 0){
		if($parent == NULL){ $parent = Jii::app()->user->id; }
		$list = array();
		if($first){
			$me = self::model()->findByPk($parent);
			$list[] = array(
				'id'=>$me->usr_id,
				'name'=>$me->usr_firstname.' '.$me->usr_lastname,
				'image'=>$me->usr_image,
				'status'=>self::status()->getLabelByValue($me->usr_status),
				'lastvisit'=>date('l d F Y H:i',strtotime($me->usr_lastlogin)),
				'indent'=>$indent,
			);
		}
		$criteria = new CDbCriteria;
		$criteria->addCondition('usr_parent = '.$parent);
		$children = self::model()->findAll($criteria);
		$indent++;
		if(!empty($children) && is_array($children)){
			foreach($children AS $child){
				$list[] = array(
					'id'=>$child->usr_id,
					'name'=>$child->usr_firstname.' '.$child->usr_lastname,
					'image'=>$child->usr_image,
					'status'=>self::status()->getLabelByValue($child->usr_status),
					'lastvisit'=>date('l d F Y H:i',strtotime($child->usr_lastlogin)),
					'indent'=>$indent,
				);
				$sub = self::getArrayAsTree($child->usr_id,false,$indent);
				if(!empty($sub) && is_array($sub)){
					$list[] += $sub;
				}
			}
		}
		return $list;	
	}	
}
?>