<?php
$h = new Html($model,$this,array(
	'id'=>'setting-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('setting/edit'),
	'htmlOptions'=>array(),
));
$options = array();
if( trim($model['options']) != '' ){
	$list = explode(',',$model['options']);
	if(!empty($list) && is_array($list)){
		foreach($list AS $k=>$v){
			$options[$v] = $v;
		}
	}
}
$h->begin();
echo $h->hidden('id');
echo $h->section(Jii::t('Setting Form'),array(
	$h->text('key'),
	(trim($model['options']) == '')?$h->textArea('value'):$h->dropDownList('value',$options),
	$h->dropDownList('sections',Setting::section()->getList(),array('prompt'=>Jii::t('-- Add New Section --'))),
	$h->text('section'),
));
if(Jii::app()->user->id == 1){
	echo $h->section(Jii::t('Setting Value Options'),array(
		$h->textArea('options',array('display'=>Jii::t('o1,o2,o3,...'))),
	));
}else{
	echo $h->hidden('options');
}
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