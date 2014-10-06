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

		$translate = array();
		$languages = Language::get();
		if(!empty($languages) && is_array($languages)){
			foreach($languages AS $id=>$language){
				$translate[$language] = $h->textArea('translate[options]['.$id.']');
			}
		}

		$item_fields_form = '<div id="item_fields_form">
								<div class="item-field">
									<input type="text" placeholder="Field Name" name="field-name[]" class="field-name" />
									<input type="text" placeholder="Default Value" name="default-value[]" class="default-value" />
									<input type="text" placeholder="Pos" name="field-pos[]" class="field-pos" />
									<a class="del-item-field" onclick="delItemField(this);">X</a>
								</div>
								<a class="add-item-field" onclick="addItemField(1,this);">Add Item field</a>
							</div>';

		echo $h->section(Jii::t('Item Fields'),array(
			$item_fields_form,
		));

		$html = '<div id="options_form">
					<div align="right">
						<a class="add-opt">Add New Option</a>
					</div>
					<div class="option-form" data="1">
						<div>
							<input class="option-name" type="text" placeholder="Option Name">
							<select class="opt-type">
								<option value="1">Check Box</option>
								<option value="2">Radio Button</option>
								<option value="3">DropDown</option>
							</select>
							<a class="del-opt" onclick="delOpt(this);">X</a>
						</div>
						<div class="opt-field"><input class="opt-field" type="text" placeholder="Field" ><a class="del-opt-field" onclick="delOptField(this);">X</a></div>
						<a class="add-opt-field" onclick="addOptField(1,this);">Add field</a>
					</div>
					<a class="options-save">Save</a>
				</div>';
		echo $h->section(Jii::t('Item Options'),array(
			$h->hidden('options'),
			$html
			)
		);

	echo $h->section(Jii::t('Extras'),array(
		$h->text('position'),
		$h->dropDownList('status',Item::status()->getList()),
	));

	echo $h->submit(Jii::t('Save'));
$h->end();
?>
<style>
.add-opt { cursor: pointer; background: #ddd; padding: 5px; margin-bottom: 5px; display: inline-block;}
.option-form { margin-bottom: 10px; margin: 10px 0px;}
.option-form input[type=text] { padding: 8px 5px; border: 1px solid #aaa; width: 158px;}
.opt-type { padding: 6px 5px;}
.opt-field { margin: 5px 0; position: relative;}
.option-form input[type=text].opt-field { padding: 8px 5px; width: 312px;}
.add-opt-field { cursor: pointer; background: #ddd; padding: 5px; margin-bottom: 5px; display: inline-block;}
.options-save { text-align: right; display: inline-block; width: 100%; padding: 5px 0; cursor: pointer;}
.del-opt { cursor: pointer; background: #ddd; padding: 7px 10px; margin-bottom: 5px; display: inline-block; font-size: 16px; float: right;}
.del-opt-field { cursor: pointer; background: #ddd; padding: 5px 10px; margin-bottom: 5px; display: inline-block; font-size: 17px; position: absolute; top: 6px; right: 1px;}

#item_fields_form { padding: 20px 0px; }
.item-field input[type=text] { width: 118px; padding: 3px 5px; height: 25px; border: 1px solid #aaa; margin-right: 2px; }
input[type=text].field-pos { width: 25px; }
.add-item-field { cursor: pointer; padding: 5px; background: #ddd; margin: 10px 0; display: inline-block; }
.item-field { position: relative; margin: 10px 0; }
.del-item-field { position: absolute; top: 6px; right: -14px; cursor: pointer; padding: 3px 5px; }
</style>
<script type="text/javascript">
var last_id = 1;
function addOptField(id,btn){
	var html = '<div class="opt-field"><input class="opt-field" type="text" placeholder="Field"><a class="del-opt-field" onclick="delOptField(this);">X</a></div>';
	var id = id;
	//$('.option-form[data='+id+']').append(html);
	$(btn).before(html);
	$(btn).prev().find('input').focus();
}
function delOptField(btn) {
	$(btn).parent().remove();
}
function delOpt(btn) {
	$(btn).parent().parent().remove();
}
function validateOptions(){
	$('.options-save').click();
	// ^([a-z A-Z 0-9]+\,[1-3]{1}\,[a-z A-Z 0-9]+(\,[a-z A-Z 0-9]+)*;)+$
	re = new RegExp('^([a-z A-Z 0-9]+\,[1-3]{1}\,[a-z A-Z 0-9]+(\,[a-z A-Z 0-9]+)*;)+$');
	if(!re.test($('#ItemForm_options').val())){
		alert('Error in Options!');
		return false;
	}else{
		return true;
	}
};
function addItemField(id,btn){
	var html = '<div class="item-field"><input type="text" placeholder="Field Name" name="field-name[]" class="field-name" /><input type="text" placeholder="Default Value" name="default-value[]" class="default-value" /><input type="text" placeholder="Pos" name="field-pos[]" class="field-pos" /><a class="del-item-field" onclick="delItemField(this);">X</a></div>';
	//$('.option-form[data='+id+']').append(html);
	$(btn).before(html);
	$(btn).prev().find('input').first().focus();
}
function delItemField(btn) {
	$(btn).parent().remove();
}
$(document).ready(function(){
	$('#ItemForm_types').change(function(){
		if($(this).val() == ''){
			$('#ItemForm_type').removeAttr('readonly');
			$('#ItemForm_type').val('');			
		}else{
			$('#ItemForm_type').attr('readonly',true);
			$('#ItemForm_type').val($(this).val());
		}
	});
	$('#ItemForm_types').change();

	$( "#ItemForm_translate_2" ).change(function() {
	  $('#ItemForm_name').val($(this).val());
	});

	$('.options-save').click(function(){
		var opts = "";
		$('#options_form').find('.option-form').each(function( index, value ) {
		  opts += $(value).find('.option-name').val()+',';
		  opts += $(value).find('.opt-type').val();//+',';
		  $(value).find('input.opt-field').each(function( index, value ){
		  	opts += ','+$(value).val();
		  });
		  opts += ';';
		});
		$('#ItemForm_options').val(opts);
	});
	$('.add-opt').click(function(){
		last_id = last_id + 1;
		var html = '<div class="option-form" data="'+last_id+'"><div><input class="option-name" type="text" placeholder="Option Name"><select class="opt-type"><option value="1">Check Box</option><option value="2">Radio Button</option><option value="3">DropDown</option></select><a class="del-opt" onclick="delOpt(this);">X</a></div><div class="opt-field"><input class="opt-field" type="text" placeholder="Field"><a class="del-opt-field" onclick="delOptField(this);">X</a></div><a class="add-opt-field" onclick="addOptField('+last_id+',this);">Add field</a></div>';
		//$('.option-form[data='+(last_id-1)+']').after(html);
		$('.options-save').before(html);
	});
	$('#item-form').attr('onsubmit','return validateOptions();');
	
});
</script>