<?php
$h = new Html($model,$this,array(
	'id'=>'category-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('category/add',array('f'=>$this->family)),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->hidden('parentid');
echo $h->section(Jii::t('Category Form'),array(
	$h->text('name'),
	$h->dropDownList('status',Category::status()->getList()),
	$h->textArea('description'),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>