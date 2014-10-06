<?php
$h = new Html($model,$this,array(
	'id'=>'currency-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('currency/edit',array('uws'=>Jii::param('uws'))),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->hidden('id');
echo $h->section(Jii::t('Currency Form'),array(
	$h->text('name'),
	$h->text('sign'),
	$h->dropDownList('locations',Location::getCountry(),array('size'=>5,'multiple'=>true)),
));

echo $h->submit(Jii::t('Save'));
$h->end();
?>