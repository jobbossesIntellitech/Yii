<tr>
	<th>
	<label>
	<?php 
		$selected_value = (isset($selected_value))?$selected_value:$field['defaultvalue'];
		echo $field['label'];
	?>
	</label>
	</th>
	<td>
		<ul class="radio-list">
		<?php
		$list = explode('|-|',$field['options']);
		if(!empty($list) && is_array($list)){
			foreach($list AS $k=>$l){
				if(!empty($l)){
					$l = explode(':=:',$l);
					$selected = ($l[0] == $selected_value)?'selected="selected"':'';
					?>
					<li>
					<input type="radio" 
					name="field[<?php echo $fld_id; ?>]" 
					id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>_<?php echo $k; ?>" 
					value="<?php echo $l[0]; ?>" <?php echo $selected; ?> class="validate" />
					<label for="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>_<?php echo $k; ?>"><?php echo $l[1]; ?></label>
					</li>
					<?php
				}
			}
		}
		?>
		</ul>
	</td>
</tr>