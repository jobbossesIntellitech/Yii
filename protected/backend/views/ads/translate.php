<?php
$form = '';
$form .= CHtml::beginForm(Jii::app()->createUrl('category/translate',array('f'=>$this->family,'id'=>Jii::param('id'))),'GET',
array('name'=>'form'));
	$form .= '<table border="0"><tr>';
	$form .= '<td>';
		$form .= CHtml::dropDownList('language',$language,$languages,array('onchange'=>'document.form.submit();'));
	$form .= '</td>';
	$form .= '</tr></table>';
$form .= CHtml::endForm();
$option = Layout::bloc($form);
echo $option;
/* -- .................................................................................... -- */
$h = new Html($model,$this,array(
	'id'=>'category-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('category/translate',array('f'=>$this->family,'id'=>Jii::param('id'),'language'=>$language)),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->section(Jii::t('Translate Name To '.$languages[$language].' Language'),array(
	$h->displayHtml($l->lng_name),
	$h->text('name'),	
));
echo $h->section(Jii::t('Translate Description To '.$languages[$language].' Language'),array(
	$h->displayHtml($l->lng_description),
	$h->textArea('description'),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>