<?php
$h = new Html($model,$this,array(
	'id'=>'form-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('form/add'),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->hidden('status',array('value'=>Form::status()->getItem('draft')->getValue()));
echo $h->section(Jii::t('Form Generator'),array(
	$h->text('title'),
	$h->dropDownList('sendto',Form::sendto()->getList()),
	$h->text('email'),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>