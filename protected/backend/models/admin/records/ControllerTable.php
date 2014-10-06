<?php
class ControllerTable extends CActiveRecord{
	
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'admin_controllers';
	}
	
	public function relations()
	{
		return array(
					'actiontable'=>array(self::HAS_MANY, 'ActionTable', 'action_controllerid',
												 'joinType'=>'INNER JOIN',
												 'on'=>'controller_id = action_controllerid','order'=>'controller_name ASC'),
					
					'permission'=>array(self::HAS_MANY, 'PermissionTable', 'permission_controllerid',
												 'joinType'=>'INNER JOIN',
												 'on'=>'controller_id = permission_controllerid','order'=>'controller_name ASC'),
				);
	}
	
	
	
}
?>