<?php
$cs=Jii::app()->clientScript;
$cs->registerCssFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/_samples/sample.css');
$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/ckeditor.js');
$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/_samples/sample.js');
?>
<tr>
	<th>
	<label for="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>">
	<?php 
	echo $field['label'];
	if($field['require']){
		echo '<span class="required">*</span>';
	}	
	?>
	</label>
	</th>
	<td>
		<textarea name="field[<?php echo $fld_id; ?>]" id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>" class="validate <?php echo ($field['require'])?'required':''; ?>"><?php echo $field['defaultvalue']; ?></textarea>
		<?php
		if($field['require']){
		?>
		<div class="error-message error"><?php echo $field['errormessage']; ?></div>
		<div class="clear"></div>
		<?php
		}
		?>
	</td>
</tr>
<script type="text/javascript">
$(document).ready(function(){
	var editor<?php echo $sec_id; ?>_<?php echo $fld_id; ?> = $('textarea#field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>');
	if (editor<?php echo $sec_id; ?>_<?php echo $fld_id; ?>.length) {
		var instance = CKEDITOR.instances['field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>'];
		if (instance) { CKEDITOR.remove(instance); e.destroy(); e=null; }
		editor = CKEDITOR.replace('field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>',
		{
			fullPage : false,
			uiColor:"#ccc",
			width:"100%",
			height:200,
			toolbar : "codendot"
		});
	}
	CKEDITOR.instances['field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>'].on("blur", function(e) {
		$('textarea#field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>').val(CKEDITOR.instances['field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>'].getData());
		$('textarea#field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>').trigger("blur");								
	});
});
</script>