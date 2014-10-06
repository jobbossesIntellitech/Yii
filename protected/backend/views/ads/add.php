<?php
$h = new Html($model,$this,array(
	'id'=>'item-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('item/add',array('f'=>$this->family,'uws'=>Jii::param('uws'))),
	'htmlOptions'=>array(),
));
$h->begin();
	echo $h->hidden('parentid');
		$translate = array();
		$languages = Language::get();
		if(!empty($languages) && is_array($languages)){
			foreach($languages AS $id=>$language){
				$translate[$language] = $h->text('translate['.$id.']');
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
	
	$('#ItemForm_name').val($( "#ItemForm_translate_2" ).val());
	$( "#ItemForm_translate_2" ).change(function() {
		$value = $(this).val();
	  $('#ItemForm_name').val($value);
	});

});
</script>