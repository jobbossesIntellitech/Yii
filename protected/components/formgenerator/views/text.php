<tr>
	<th>
	<label for="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>">
	<?php 
	$selected_value = (isset($selected_value))?$selected_value:$field['defaultvalue'];
	//echo $field['label'];
	echo Jii::t($field['label']);
	if($field['require']){
		echo '<span class="required">*</span>';
	}	
	?>
	</label>
	</th>
	<td>
		<input type="text" name="field[<?php echo $fld_id; ?>]" id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>" value="<?php echo $selected_value; ?>" class="validate <?php echo ($field['require'])?'required':''; ?>" />
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