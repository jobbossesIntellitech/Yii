<?php
class Content extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'cms_contents';
	}
	public function relations()
	{
		return array(
					'category'=>array(self::BELONGS_TO, 'Category', 'con_categoryid'),
					'content_lang'=>array(self::HAS_ONE, 'ContentLang', 'lng_contentid'),
					'comment'=>array(self::HAS_MANY, 'Comment', 'com_contentid','together'=>false),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('draft',0x00,Jii::t('Draft'),'Draft Content');
			self::$status->add('publish',0x01,Jii::t('Publish'),'Publish Content');
			self::$status->add('hot',0x02,Jii::t('Hot'),'Hot Content');
			self::$status->add('archive',0x03,Jii::t('Archive'),'Archive Content');
			self::$status->add('delete',0x04,Jii::t('Delete'),'Delete Content');
		}
		return self::$status;	
	}
	
	private static $comment = NULL;
	public static function comment(){
		if(self::$comment == NULL){
			self::$comment = new Status();
			self::$comment->add('yes',0x01,Jii::t('Yes'),'has comment');
			self::$comment->add('no',0x00,Jii::t('No'),'hasnt comment');
		}
		return self::$comment;	
	}
	
	public static function breadcrumb($id,$category, $first = true){
		$breadcrumb = '';
		$criteria = new CDbCriteria;
		$criteria->addCondition('con_id = '.$id);
		$criteria->with = array('content_lang:'.Jii::app()->language);
		$content = self::model()->find($criteria);
		if(isset($content->con_id)){
			$breadcrumb .= self::breadcrumb($content->con_parentid,$category, false).' * ';
			if($first){
				$breadcrumb .= $content->content_lang->lng_title;	
			}else{
				$breadcrumb .= CHtml::link($content->content_lang->lng_title,Jii::app()->createUrl('content/index',array('f'=>$content->con_id,'c'=>$category)));	
			}
		}else{
			if($first){
				$breadcrumb .= Jii::t('Root');	
			}else{
				$breadcrumb .= CHtml::link(Jii::t('Root'),Jii::app()->createUrl('content/index',array('f'=>$id,'c'=>$category)));
			}
		}
		return $breadcrumb;		
	}
	
	public static function without($w = 0){
		$criteria = new CDbCriteria;
		$criteria->with = array('content_lang:'.Jii::app()->language);
		$criteria->addCondition('con_id not in ('.$w.')');
		return CHtml::listData(self::model()->findAll($criteria),'con_id','content_lang.lng_title');
	}
	
	
	
	public function afterDelete(){
		parent::afterDelete();
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('con_parentid = '.$this->con_id);
		$list = self::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();	
			}	
		}
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('lng_contentid = '.$this->con_id);
		$list = ContentLang::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();	
			}	
		}
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('com_contentid = '.$this->con_id);
		$list = Comment::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();	
			}	
		}
	}
	
	public static function tree($category,$parent = 0, $prefix = '', $sep = ''){
		$data = array();
		$criteria = new CDbCriteria;
		$criteria->with = array('content_lang:'.Jii::app()->language);
		$criteria->addCondition('con_categoryid = '.$category);
		$criteria->addCondition('con_parentid = '.$parent);
		$list = self::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$data[$l->con_id] = $prefix.$sep.$l->content_lang->lng_title;
				$data += self::tree($category,$l->con_id,$prefix.'|---',' ');
			}
		}
		return $data;	
	}
	
	public static function correctGallery($gal){
		$list = array();
		$gallery = json_decode($gal);
		if(!empty($gallery) && is_array($gallery)){
			foreach($gallery as $i=>$g){
				if($g != Jii::notfound()){
					$info = pathinfo($g);
					$source = Jii::app()->params['rootPath'].$info['dirname'].'/'.urldecode($info['filename']).'.'.$info['extension'];
					$destination = Jii::app()->params['rootPath'].$info['dirname'].'/'.($i.'_'.time()).'.'.$info['extension'];
					$destinationurl = '/assets/finder/files/'.($i.'_'.time()).'.'.$info['extension'];
					rename($source,$destination);
					$list[] = $destinationurl;
				}
			}
			return json_encode($list);
		}
	}
}
?>