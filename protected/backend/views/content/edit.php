<?php
$h = new Html($model,$this,array(
	'id'=>'content-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('content/edit',array('f'=>$this->family,'c'=>$this->category)),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->hidden('id');
echo $h->hidden('parentid');
echo $h->section(Jii::t('Gallery'),array(
	$h->finder('gallery',array(
		'dimension'=>'open',
		'type'=>'jpg,png,gif',
	)),	
),false);
echo $h->section(Jii::t('Content'),array(
	$h->text('title'),
	$h->textArea('excerpt'),
	$h->text('metatitle'),
	$h->text('metadescription'),
	$h->text('metakeywords'),
));
echo $h->section(Jii::t('Options'),array(
	$h->dropDownList('status',Content::status()->getList()),
	$h->dropDownList('hascomments',Content::comment()->getList()),
	$h->dropDownList('categoryid',Category::tree()),
	$h->dropDownList('previd',Content::without(),array('prompt'=>Jii::t('Root'))),
	$h->tags('tags'),	
));
echo $h->section(Jii::t('Editor'),array(
	$h->editor('text'),	
),false);
echo $h->submit(Jii::t('Save'));
$h->end();
?>