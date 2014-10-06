<?php
$cs=Jii::app()->clientScript;
$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/scripts/jquery.tagsinput.min.js');
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
	$('#field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>').tagsInput({
		height : '100px',
		width : '300px',
		interactive :true,
		defaultText : '<?php echo Jii::t('add a tag'); ?>',
		removeWithBackspace : true,
		minChars : 0,
		maxChars : 0,
		placeholderColor : '#363636'					
	});
});
</script>