<?php
$h = new Html($model,$this,array(
	'id'=>'menu-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('menu/add'),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->hidden('status',array('value'=>Form::status()->getItem('draft')->getValue()));
echo $h->section(Jii::t('Menu'),array(
	$h->text('name'),
	$h->dropDownList('hook',Menu::hook()),
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>