<?php
class UserCookie extends CActiveRecord{
	
	private static $data = NULL;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'admin_users_cookies';
	}
	
	public function relations()
	{
		return array(
					'user'=>array(self::BELONGS_TO, 'User', 'auc_userid'),
				);	
	}
	
	public static function get($key,$default = ''){
		self::load();
		if(!isset(self::$data[$key])){
			self::set($key,$default);	
		}
		return self::$data[$key];
	}
	
	public static function set($key,$value){
		self::load();
		$criteria = new CDbCriteria;
		$criteria->addCondition('auc_userid = '.Jii::app()->user->id);
		$criteria->addCondition('auc_key = "'.$key.'"');
		$c = self::model()->find($criteria);
		if(!isset($c->auc_id)){
			$c = new self;
			$c->auc_userid = Jii::app()->user->id;
			$c->auc_key = $key;
		}
		$c->auc_value = $value;
		if($c->save()){
			self::$data[$key] = $value;
			return true;
		}
		return false;
	}
	
	public static function sets($data){
		if(!empty($data) && is_array($data)){
			foreach($data AS $k=>$v){
				self::set($k,$v);
			}
			return true;
		}
		return false;
	}
	
	public static function data(){
		self::load();
		return self::$data;
	} 
	
	public static function load(){
		if(self::$data == NULL){
			$criteria = new CDbCriteria;
			$criteria->addCondition('auc_userid = '.Jii::app()->user->id);
			self::$data = CHtml::listData(self::model()->findAll($criteria),'auc_key','auc_value');
		}
	}
	
}
?>