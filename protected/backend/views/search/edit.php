<?php
foreach($model->translate AS $k=>$v){
	$model->translate[intval($k)] = $v;
}
$h = new Html($model,$this,array(
	'id'=>'location-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('location/edit',array('f'=>$this->family,'uws'=>Jii::param('uws'))),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->hidden('id');
echo $h->hidden('parentid');
echo $h->section(Jii::t('Location Form'),array(
	$h->finder('logo',array(
		'only'=>1,
		'type'=>'jpg,png,gif',
	)),
	$h->text('name'),
	$h->dropDownList('types',Location::type()->getList(),array('prompt'=>Jii::t('-- Add New Type --'))),
	$h->text('type'),	
));

$translate = array();
$languages = Language::get();
if(!empty($languages) && is_array($languages)){
	foreach($languages AS $id=>$language){
		$translate[] = $h->text('translate['.$id.']');
	}
}

echo $h->section(Jii::t('Translation'),$translate);

echo $h->section(Jii::t('Options'),array(
	$h->text('priority'),
	$h->text('position'),
	$h->dropDownList('status',Location::status()->getList()),
));

echo $h->submit(Jii::t('Save'));
$h->end();
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#LocationForm_types').change(function(){
		if($(this).val() == ''){
			$('#LocationForm_type').removeAttr('readonly');
			$('#LocationForm_type').val('');			
		}else{
			$('#LocationForm_type').attr('readonly',true);
			$('#LocationForm_type').val($(this).val());
		}
	});
	$('#LocationForm_types').change();
});
</script>