<tr>
	<th>
	&nbsp;
	</th>
	<td>
		<input type="checkbox" 
		name="field[<?php echo $fld_id; ?>]" 
		id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>" 
		value="<?php echo $field['defaultvalue']; ?>" class="validate <?php echo ($field['require'])?'required':''; ?>"
		<?php echo ($field['require'])?'checked="checked"':''; ?> />
		<label for="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>">
		<?php 
		echo $field['label'];	
		?>
		</label>
	</td>
</tr>