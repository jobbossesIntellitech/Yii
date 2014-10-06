<?php
$h = new Html($model,$this,array(
	'id'=>'member-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('member/add'),
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
$h->begin();
echo $h->section(Jii::t('Member Form'),array(
	/*$h->finder('image',array(
		'only'=>1,
		'dimension'=>'400x400',
		'type'=>'jpg,png,gif',
	)),*/
	$h->text('firstname'),
	$h->text('lastname'),
	$h->dropDownList('gender',Member::gender()->getList()),
	$h->text('phone'),	
	$h->dropDownList('locationid',Location::tree()),
	$h->dropDownList('status',Member::status()->getList()),
	$h->file('image'),
));
echo $h->section(Jii::t('Authentication'),array(
	$h->text('username'),
	$h->text('email'),
	$h->password('password'),
	$h->password('confirmpassword'),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>
