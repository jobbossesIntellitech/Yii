<?php
$form = '';
$form .= CHtml::beginForm(Jii::app()->createUrl('content/translate',array('f'=>$this->family,'c'=>$this->category,'id'=>Jii::param('id'))),'GET',
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
	'id'=>'content-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('content/translate',array('f'=>$this->family,'c'=>$this->category,'id'=>Jii::param('id'),'language'=>$language)),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->section(Jii::t('Translate Title To '.$languages[$language].' Language'),array(
	$h->displayHtml($l->lng_title),
	$h->text('title'),	
));
echo $h->section(Jii::t('Translate Excerpt To '.$languages[$language].' Language'),array(
	$h->displayHtml($l->lng_excerpt),
	$h->textArea('excerpt'),	
));
echo $h->section(Jii::t('Translate Text To '.$languages[$language].' Language'),array(
	$h->displayHtml($l->lng_text),
	$h->editor('text'),	
),false);
echo $h->submit(Jii::t('Save'));
$h->end();
?>