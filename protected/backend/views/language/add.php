<?php
$h = new Html($model,$this,array(
	'id'=>'language-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('language/add'),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->section(Jii::t('Language Form'),array(
	$h->text('iso'),
	$h->text('name'),
	$h->dropDownList('status',Language::status()->getList()),
	$h->dropDownList('direction',Language::direction()->getList()),	
),false);
echo $h->submit(Jii::t('Save'));
$h->end();
?>