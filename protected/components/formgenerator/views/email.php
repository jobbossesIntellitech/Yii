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
		<input type="text" name="field[<?php echo $fld_id; ?>]" id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>" value="<?php echo $field['defaultvalue']; ?>" class="validate email <?php echo ($field['require'])?'required':''; ?>"/>
		<?php
		if($field['require']){
		?>
		<div class="error-message error"><?php echo $field['errormessage']; ?></div>
		<?php
		}
		?>
		<div class="email-message error"><?php echo Jii::t('Email not valid'); ?></div>
		<div class="clear"></div>
	</td>
</tr>