<?php
class ContentForm extends CFormModel{
	public $id;
	public $status;
	public $parentid;
	public $categoryid;
	public $previd;
	public $tags;
	public $hascomments;
	public $gallery;
	public $title;
	public $excerpt;
	public $text;
	public $metatitle;
	public $metadescription;
	public $metakeywords;
	public function rules()
	{
		return array(
			array('title', 'required'),
			array('id,status,parentid,categoryid,previd,tags,hascomments,gallery,title,excerpt,text,metatitle,metadescription,metakeywords', 'safe'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'id'=>Jii::t('ID'),
			'status'=>Jii::t('Status'),
			'parentid'=>Jii::t('Belong To'),
			'categoryid'=>Jii::t('Category'),
			'previd'=>Jii::t('Prev. Content'),
			'tags'=>Jii::t('Tags'),
			'hascomments'=>Jii::t('Has Comments'),
			'gallery'=>Jii::t('Gallery'),
			'title'=>Jii::t('Title'),
			'excerpt'=>Jii::t('Excerpt'),
			'text'=>Jii::t('Full Text'),
			'metatitle'=>Jii::t('Meta Title'),
			'metadescription'=>Jii::t('Meta Description'),
			'metakeywords'=>Jii::t('Meta Keywords'),
		);
	}
}