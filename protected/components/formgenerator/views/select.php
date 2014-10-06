<tr>
	<th>
	<label for="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>">
	<?php 
	$selected_value = (isset($selected_value))?$selected_value:$field['defaultvalue'];
	echo $field['label'];
	if($field['require']){
		echo '<span class="required">*</span>';
	}	
	?>
	</label>
	</th>
	<td>
		<select <?php echo ($field['defaultvalue'] == 'multiple')?'multiple="multiple"':''; ?> class="validate <?php echo ($field['require'])?'required':''; ?>" name="field[<?php echo $fld_id; ?>]<?php echo ($field['defaultvalue'] == 'multiple')?'[]':''; ?>" id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>">
		<?php
		$list = explode('|-|',$field['options']);
		if(!empty($list) && is_array($list)){
			if(($field['defaultvalue'] == 'multiple') && (is_array(json_decode($selected_value)))){
					$selected = array();
					//echo $val.', ';
					foreach($list AS $l){
						if(!empty($l)){
							$l = explode(':=:',$l);
							foreach(json_decode($selected_value) as $val){
								$selected[$l[0]] = ($l[0] == $val)?'selected="selected"':'';
								if($selected[$l[0]] != '') break;
							}
							?>
							<option value="<?php echo $l[0]; ?>" <?php if($selected[$l[0]] != '') echo $selected[$l[0]]; ?>><?php echo $l[1]; ?></option>
							<?php
						}
					}
				
				
			}else{
				foreach($list AS $l){
					if(!empty($l)){
						$l = explode(':=:',$l);
						$selected = ($l[0] == $selected_value)?'selected="selected"':'';
						
						?>
						<option value="<?php echo $l[0]; ?>" <?php echo $selected; ?>><?php echo $l[1]; ?></option>
						<?php
					}
				}
			}
		}
		?>
		</select>
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