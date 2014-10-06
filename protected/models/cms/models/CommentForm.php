<?php
class CommentForm extends CFormModel{
	public $id;
	public $status;
	public $parentid;
	public $contentid;
	public $user;
	public $name;
	public $email;
	public $title;
	public $text;
	public function rules()
	{
		return array(
			array('title,text,name', 'required'),
			array('id,status,parentid,contentid,user,name,email,title,text', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'status'=>Jii::t('Status'),
			'parentid'=>Jii::t('Belong To'),
			'contentid'=>Jii::t('Content'),
			'user'=>Jii::t('User'),
			'name'=>Jii::t('Name'),
			'email'=>Jii::t('Email'),
			'title'=>Jii::t('Title'),
			'text'=>Jii::t('Text'),
		);
	}
}