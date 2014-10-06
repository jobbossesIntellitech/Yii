<?php
class Comment extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'cms_comments';
	}
	public function relations()
	{
		return array(
					'content'=>array(self::BELONGS_TO, 'Content', 'com_contentid'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('pending',0x00,Jii::t('Pending'),'Pending Comment');
			self::$status->add('approved',0x01,Jii::t('Approved'),'Approved Comment');
			self::$status->add('spam',0x02,Jii::t('Spam'),'Spam Comment');
			self::$status->add('delete',0x03,Jii::t('Delete'),'Delete Comment');
		}
		return self::$status;	
	}
	
	public function afterDelete(){
		parent::afterDelete();
		
	}
}
?>