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
		<input type="password" name="field[<?php echo $fld_id; ?>]" id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>" value="<?php echo $field['defaultvalue']; ?>" class="validate <?php echo ($field['require'])?'required':''; ?>"/>
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