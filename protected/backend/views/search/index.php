<?php
$n = 1;

$item = Item::model()->findByPk($this->form);
//echo $item->itm_formid;
$criteria = new CDbCriteria;
$criteria->addCondition('form_id = '.$item->itm_formid);
$criteria->with = array('section'=>array('with'=>array('field')));
$criteria->addCondition('form_status = '.Form::status()->getItem('publish')->getValue());
$form = Form::model()->with()->find($criteria);

$message = '';
if(isset($form->section) && is_array($form->section) && !empty($form->section)){
	$message .= '<div class="field">';
		$message .= '<div class="input">';
			$message .= '<select class="fieldlist">';
			foreach($form->section AS $section){
				//$message .= '<tr><th colspan="2" style="background:#fabc00; color:#874700; padding:5px;">'.$section->sec_title.'</th></tr>';
				if(isset($section->field) && is_array($section->field) && !empty($section->field)){
					$message .= '<option value=""> -- Please Select Field -- </option>';
					foreach($section->field AS $field){
						$message .= '<option value="'.$field->fld_id.'">'.$field->fld_label.'</option>';
					}
				}
			}
			$message .= '</select>';
		$message .= '</div>';
		
		$message .= '<div class="input">';
			$types = Search::type()->getList();
			$message .= '<select class="typelist">';
				$message .= '<option value=""> -- Please Select Type -- </option>';
				foreach($types AS $k=>$v){
					$message .= '<option value="'.$k.'">'.$v.'</option>';
				}
			$message .= '</select>';
		$message .= '</div>';
		
		$message .= '<div class="input">';
			$message .= '<div class="labels">';
				$message .='<label style="color:#fff;">Label1</label><input id="label1" name="label1" type="text" />';
			$message .= '</div>';
		$message .= '</div>';
		
		$message .= '<div class="input" style="display:none;">';
			$message .= '<div class="options_radio">';
				/*$message .='<label style="color:#fff;">Options Forms</label><div class="clear"></div>';
				$message .='<input type="radio" name="option'.$n.'" value="1"  checked="checked"/><label style="color:#fff; margin-right:20px;">Inherit</label>';
				$message .='<input type="radio" name="option'.$n.'" value="0" /><label style="color:#fff;">Custom</label>';*/
			$message .= '</div>';
		$message .= '</div>';
		
		$message .= '<div class="clear"></div>';
		$message .= '<div class="options fields" style="display:none;">';
			$message .= '<a class="add_new_option" href="javascript://">+</a>';
		$message .= '</div>';
		
	$message .= '</div>';
	$n++;
}


?>
<?php
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets/scripts/ui.js');
$form = '';
$form .= CHtml::beginForm(Jii::app()->createUrl('search/index'),'GET',
array('name'=>'form'));
	$form .= '<table border="0"><tr>';
	$form .= '<td>';
		$form .= CHtml::dropDownList('f',$this->form,$this->forms,array('onchange'=>'document.form.submit();'));
	$form .= '</td>';
	$form .= '<td><a href="javascript://" class="add_form_button" id="add_simple_line">'.Jii::t("Add New Simple").'</a></td>';
	$form .= '<td><a href="javascript://" class="add_form_button" id="add_advanced_line">'.Jii::t("Add New Advanced").'</a></td>';
	$form .= '<td><a href="javascript://" class="add_form_button" id="add_draft_line">'.Jii::t("Add New Draft").'</a></td>';
	$form .= '</tr></table>';
$form .= CHtml::endForm();
$option = Layout::bloc($form);
echo $option;
?>
<div class="sortable-with">
	<label>Sorting: </label>
	<input type="radio" name="sortable" value="0" checked="checked" /><label>disable</label>
	<input type="radio" name="sortable" value="1" /><label>enable</label>
</div>
<div class="clear"></div>
<div class="j-form">
	<div class="error err"><div style="" id="SearchForm_error" class="errorMessage"></div></div>
	
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div>Simple Search Forms<div class="r"></div>
			</legend>
			<div class="fields">
				<ul id="simple_searchform_container" class="new_form_container">
					
				</ul>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
				
	<div class="clear"></div>
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div>Advanced Search Forms<div class="r"></div>
			</legend>
			<div class="fields">
			<ul id="advanced_searchform_container" class="new_form_container">
				
			</ul>
			<div class="clear"></div>
			</div>
		</fieldset>
	</div>
	
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div>Draft Search Forms<div class="r"></div>
			</legend>
			<div class="fields">
				<ul id="draft_searchform_container" class="new_form_container">
					
				</ul>
				<div class="clear"></div>
				</div>
		</fieldset>
	</div>
	<div class="clear"></div>
		
</div>
<script type="text/javascript">
var n = 1;
var s = 1;
$(function() {
	$( "#simple_searchform_container, #advanced_searchform_container, #draft_searchform_container" ).sortable({
		connectWith: ".new_form_container"
	});
});
//$( ".new_form_container" ).sortable( "enable" );
//$(".new_form_container").sortable("disable");

$('document').ready(function(){
	$('.sortable-with input[type=radio]').click(function(){ 
		if($(this).val() == 1){
			$('.new_form_container').sortable('enable');	
		}else if($(this).val() == 0){
			$('.new_form_container').sortable('disable');	
		}
	});
	$('.sortable-with input[value=0]').trigger('click');
	
	
	$('.add_form_button').click(function(){
		generateItem($(this).attr('id').split('_')[1],'');
	});
	
	$(document).on('click','.searchform_line .typelist option',function(){
		generateLabels($(this));
	});
	
	$(document).on('click','.options_radio input[type=radio]',function(){
		inherit_options($(this));
	});
	
	$(document).on('click','.options .add_new_option',function(){
		var value = prompt('value','');
		var label = prompt('label','');
		addNewOption($(this),value,label);
	});
	
	$(document).on('click','.options .option_field .delete',function(){
		$(this).parent().remove();
	});
	
});

function generateItem(appendto, options){
	var data = '<?php echo $message;?>';
	var type = appendto;
	if(data != ''){
		$('#'+type+'_searchform_container').append('<li id="searchform_line_<?php echo $this->form;?>_'+n+'" class="searchform_line"></li>');
		$('#'+type+'_searchform_container #searchform_line_<?php echo $this->form;?>_'+n).append(data);
		n++;
	}else{
		//alert("This Item doesn't have Form !!!");
		$('.errorMessage').html('');
		$('.errorMessage').append("This Item doesn't have Form !!!");
		$('.error').css('display','block');
		window.setTimeout('disappear()',4000);
	}
}

function generateLabels(searchtype){
	
	searchtype.parent().parent().parent().find('.labels').html('');
	if(searchtype.val() == 1 || searchtype.val() == 2){
		searchtype.parent().parent().parent().find('.labels').append('<label style="color:#fff;">Label1</label><input id="label1" name="label1" type="text" /><label style="color:#fff;">Label2</label><input id="label2" name="label2" type="text" />');
	}else{
		searchtype.parent().parent().parent().find('.labels').append('<label style="color:#fff;">Label1</label><input id="label1" name="label1" type="text" />');
	}
	
	
	var text = '';
	text +='<label style="color:#fff;">Options Forms</label><div class="clear"></div>';
	text +='<input type="radio" name="option'+s+'" value="1"  checked="checked"/><label style="color:#fff; margin-right:20px;">Inherit</label>';
	text +='<input type="radio" name="option'+s+'" value="0" /><label style="color:#fff;">Custom</label>';
	
	searchtype.parent().parent().parent().find('.options_radio').html('');
	searchtype.parent().parent().parent().find('.options_radio').parent().show();
	if(searchtype.val() == 3 || searchtype.val() == 4 || searchtype.val() == 5){
		searchtype.parent().parent().parent().find('.options_radio').append(text);
		s++;
	}else{
		searchtype.parent().parent().parent().find('.options_radio').parent().hide();
	}
}

function addNewOption(item,value,label){
	item.parent().append(
	'<div class="option_field">'+
		'<span class="value_option">'+value+'</span>'+
		'<span style="margin:2px 5px;">:</span><span class="label_option">'+label+'</span>'+
		'<a href="javascript://" class="delete">x</a>'+
	'</div>'
	);
}

function inherit_options(option_selected){
	var search_id = option_selected.parent().parent().parent().parent().attr('id');
		
	if(option_selected.val() == 1){
		$('#'+search_id+' .options').css('display','none');
	}else if(option_selected.val() == 0){
		$('#'+search_id+' .options').css('display','block');
	}
}

function disappear(){
	$('.error').css('display','none');
}
</script>

<style type="text/css">
.j-form .outer-section.floatting{width:1000px;}
.j-form .field .input{margin-left:5px;}
.j-form .field .input select{width:165px;}
.j-form .field .input input[type="text"]{width:60px;}
.error{display:none;}

.options{margin-top:10px; height:40px; overflow:auto; padding:5px!important;}
.options .option_field{position:relative; float:left; background:#aaa; border:1px solid #fff; margin:5px; padding:5px;}
.options .option_field .delete{position:absolute; right:-3px; top:-10px; background:#666; color:#fff; padding:0 1px; display:none;}
.options .option_field:hover .delete{display:block;}

.new_form_container{position:relative; height:300px; display:block; background:#ccc;}
.new_form_container .searchform_line{position:relative; min-height:60px; display:block; background:#999; border:1px solid #000; margin-top:2px;}
.sortable-with{position:relative; display:block; background:#999; border:1px solid #000; margin-top:2px;}

a.add_form_button{float:left; margin:5px 15px; padding:5px; background:#ccc; color:#000!important; font-size:18px;}
a.add_form_button:hover{color:#eee!important;}

a.add_new_option{float:left; margin:5px 15px; padding:5px; background:#ccc; color:#000!important; font-size:18px;}
a.add_new_option:hover{color:#eee!important;}

</style>