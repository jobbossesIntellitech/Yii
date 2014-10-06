<?php
class wNews extends CWidget{
	public function init(){
		parent::init();
	}
	public function run(){
		$criteria = new CDbCriteria;
		$criteria->addCondition('con_categoryid = 2');
		$criteria->addCondition('con_status = '.Content::status()->getItem('publish')->getValue());
		$criteria->order = 'con_id DESC';
		$criteria->limit = 2;
		$news = Content::model()->findAll($criteria);
			
		$this->render('vNews',array('news'=>$news));
	}

}
?>