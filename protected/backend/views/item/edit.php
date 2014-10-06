<?php

foreach($model->translate AS $k=>$v){
	$model->translate[intval($k)] = $v;
}
$h = new Html($model,$this,array(
	'id'=>'item-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('item/edit',array('f'=>$this->family,'uws'=>Jii::param('uws'))),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->hidden('id');
echo $h->hidden('parentid');

$translate = array();
$languages = Language::get();
if(!empty($languages) && is_array($languages)){
	foreach($languages AS $id=>$language){
		$translate[] = $h->text('translate['.$id.']');
	}
}

echo $h->section(Jii::t('Item Name'),$translate);
echo $h->hidden('name');


echo $h->section(Jii::t('Extras'),array(
		$h->dropDownList('type',Item::type()->getList()),
		$h->dropDownList('formid',CHtml::listData(Form::model()->findAll(), 'form_id', 'form_title'),array('prompt'=>Jii::t('-- Select Form --'))),
		$h->text('position'),
		$h->dropDownList('status',Item::status()->getList()),
	));

echo $h->submit(Jii::t('Save'));
$h->end();
?>
<script type="text/javascript">
$(document).ready(function(){
	
	$( "#ItemForm_translate_2" ).change(function() {
	  $('#ItemForm_name').val($(this).val());
	});

});
</script>