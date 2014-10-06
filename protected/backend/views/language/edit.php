<?php
$h = new Html($model,$this,array(
	'id'=>'language-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('language/edit'),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->section(Jii::t('Language Form'),array(
	$h->hidden('id'),
	$h->text('iso'),
	$h->text('name'),
	$h->dropDownList('status',Language::status()->getList()),
	$h->dropDownList('direction',Language::direction()->getList()),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>