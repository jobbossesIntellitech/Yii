<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/ui.js');
$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/searchformbuilder/SearchFormBuilder.js');
$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/searchformbuilder/SearchFormBuilderArea.js');
$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/searchformbuilder/SearchFormBuilderField.js');
$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/searchformbuilder/SearchFormBuilderFieldsType.js');

$form = '';
	$form .= '<table border="0"><tr>';
	$form .= CHtml::beginForm(Jii::app()->createUrl('searchformbuilder/index'),'GET',
array('name'=>'form'));
		$form .= '<td>';
			$form .= CHtml::dropDownList('f',$this->form,$this->forms,array('onchange'=>'document.form.submit();'));
		$form .= '</td>';
$form .= CHtml::endForm();	
	$form .= '<td>';
		$form .= '<a href="javascript://" id="add-simple" class="button">';
			$form .= Jii::t('Add New Simple');
		$form .= '</a>';
		$form .= '<a href="javascript://" id="add-advanced" class="button">';
			$form .= Jii::t('Add New Advanced');
		$form .= '</a>';
		$form .= '<a href="javascript://" id="add-draft" class="button">';
			$form .= Jii::t('Add New Draft');
		$form .= '</a>';
	$form .= '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
		$form .= '<td>';
			$form .= '<input type="checkbox" name="sortable" value="1" id="enable-sortable" style="width:32px;" />';
			$form .= '<label for="enable-sortable">'.Jii::t('Enable Sortable').'</label>';
		$form .= '</td>';
		$form .= '<td>';
			$form .= '<form method="post" action="'.Jii::app()->createUrl('searchformbuilder/save',array('f'=>$this->form)).'" class="builder-form">';
				$form .= '<input type="submit" name="builder-send" value="'.Jii::t('Save').'" style="cursor:pointer; border:1px solid #000; width:auto;" class="button" />';
				$form .= '<input type="button" value="'.Jii::t('Duplicate To').'" id="duplicate-to" style="cursor:pointer; border:1px solid #000; width:auto;" class="button" />';
				$form .= '<div class="duplicate-to" style="display:none;">';
					$form .= CHtml::dropDownList('duplicateto[]','',$this->forms,array('size'=>'20','multiple'=>true));
				$form .= '</div>';
			$form .= '</form>';
		$form .= '</td>';
	$form .= '</tr>';
	$form .= '</table>';
$option = Layout::bloc($form);
echo $option;
?>
<div class="sfb-simple sfb-area">
	<h3 class="sfb-title"><?php echo Jii::t('Simple'); ?></h3>
	<div class="sfb-content" data-type="simple"></div>
</div>
<div class="sfb-advanced sfb-area">
	<h3 class="sfb-title"><?php echo Jii::t('Advanced'); ?></h3>
	<div class="sfb-content" data-type="advanced"></div>
</div>
<div class="sfb-draft sfb-area">
	<h3 class="sfb-title"><?php echo Jii::t('Draft'); ?></h3>
	<div class="sfb-content" data-type="draft"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	SearchFormBuilderField.formItems = <?php echo json_encode($fields); ?>;
	var builder = new SearchFormBuilder();
	builder.addArea('simple','.sfb-simple .sfb-content');
	builder.addArea('advanced','.sfb-advanced .sfb-content');
	builder.addArea('draft','.sfb-draft .sfb-content');
	
	$('#add-simple').click(function(){
		builder.getArea('simple').addField();
	});
	$('#add-advanced').click(function(){
		builder.getArea('advanced').addField();
	});
	$('#add-draft').click(function(){
		builder.getArea('draft').addField();
	});
	$('#enable-sortable').click(function(){
		if($(this).is(':checked')){
			$('.sorted-list').sortable('enable');
		}else{
			$('.sorted-list').sortable('disable');
		}
	});
	$('.sorted-list').sortable('disable');
	
	$('.builder-form input[type=submit]').click(function(e){
		e.preventDefault();
		var form = [], i=0;
		$('.sfb-area .sfb-content').each(function(u,area){
			$(area).find('.sfb-field').each(function(j,field){
				i = form.length;
				form[i] ='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][field]" value="'+$(field).find('.field-form').val()+'" />';
				form[i]+='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][search]" value="'+$(field).find('.field-search').val()+'" />';
				if( $(field).find('.label').attr('data-type') == 'one' ){
					form[i]+='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][label]" value="'+$(field).find('.label').val()+'" />';
				}else{
					$(field).find('.label').each(function(k,label){
						form[i]+='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][label]['+k+']" value="'+$(label).val()+'" />';
					});
				}
				if($(field).find('.is-integer').length > 0){
					form[i]+='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][integer]" value="'+($(field).find('.is-integer').is(':checked')?1:0)+'" />';
				}else
				if($(field).find('.inherit').length > 0){
					form[i]+='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][inherit]" value="'+($(field).find('.inherit').is(':checked')?1:0)+'" />';
					if(!$(field).find('.inherit').is(':checked')){
						$(field).find('.options li.option-item').each(function(x,option){
							form[i]+='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][option]['+x+'][value]" value="'+$(option).find('.value-option').val()+'" />';
							form[i]+='<input type="hidden" name="sfb['+$(area).attr('data-type')+']['+j+'][option]['+x+'][label]" value="'+$(option).find('.label-option').val()+'" />';
						});
					}
				}
			});
		});
		form = form.join(' ');
		if($.trim(form) != ''){
			$('.builder-form').append(form).submit();
		}else{
			alert('Cannot save empty form');
		}
		return false;
	});
	<?php 
	if(isset($data) && is_array($data) && !empty($data)){
		foreach($data AS $field){
			?>
			try{
				builder.getArea('<?php echo $field->fse_view; ?>').addField({
					field : '<?php echo $field->fse_fieldid; ?>',
					search : <?php echo $field->fse_type; ?>,
					label : <?php echo $field->fse_label; ?>,
					option : <?php echo (!empty($field->fse_options))?$field->fse_options:'""'; ?>
				});
			}catch(e){
				
			}
			<?php
		}
	}
	?>
	
	$('#duplicate-to').click(function(){
		var id = $(this).attr('id');
		$('.'+id).toggle();
	});
});
</script>