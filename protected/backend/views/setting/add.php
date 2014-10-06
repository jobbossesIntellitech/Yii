<?php
$h = new Html($model,$this,array(
	'id'=>'setting-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('setting/add'),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->section(Jii::t('Setting Form'),array(
	$h->text('key'),
	$h->textArea('value'),
	$h->dropDownList('sections',Setting::section()->getList(),array('prompt'=>Jii::t('-- Add New Section --'))),
	$h->text('section'),
));
echo $h->section(Jii::t('Setting Value Options'),array(
	$h->textArea('options',array('display'=>Jii::t('o1,o2,o3,...'))),
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#SettingForm_sections').change(function(){
		if($(this).val() == ''){
			$('#SettingForm_section').removeAttr('readonly');
			$('#SettingForm_section').val('');			
		}else{
			$('#SettingForm_section').attr('readonly',true);
			$('#SettingForm_section').val($(this).val());
		}
	});
	$('#SettingForm_sections').change();
});
</script>