<?php
class PermissionTable extends CActiveRecord{
	
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'admin_users_permissions';
	}
	
	
	
	public function relations()
	{
		return array(
					 
					'actiontable'=>array(self::BELONGS_TO, 'ActionTable', 'permission_actionid'),
					'controllertable'=>array(self::BELONGS_TO, 'ControllerTable', 'permission_controllerid'),
					'user'=>array(self::BELONGS_TO, 'User', 'permission_userid','joinType'=>'INNER JOIN'),
				);	
	}
	
	
	
}
?>