<?php
class wLatestLog extends CWidget{
	public $dashboard;
	public function init(){	
		parent::init();	
	}
	public function run(){
		$criteria = new CDbCriteria;
		$criteria->addCondition('log_userid = '.Jii::app()->user->id);
		$criteria->limit = 50;
		$criteria->order = 'log_date DESC';
		$list = Log::model()->findAll($criteria);
		$this->render('vLatestLog',array('list'=>$list));	
	}
}
?>