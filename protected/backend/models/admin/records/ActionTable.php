<?php
class ActionTable extends CActiveRecord{
	
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'admin_actions';
	}
	
	
	public function relations()
	{
		return array(
					 
					'controllertable'=>array(self::BELONGS_TO, 'ControllerTable', 'action_controllerid','joinType'=>'INNER JOIN'),
					
					'permission'=>array(self::HAS_MANY, 'PermissionTable', 'permission_actionid',
												 'joinType'=>'INNER JOIN',
												 'on'=>'action_id = permission_actionid','order'=>'action_name ASC'),
					
				);	
	}
	
	
	
}
?>