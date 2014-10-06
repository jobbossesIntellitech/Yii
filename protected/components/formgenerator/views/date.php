<?php
$cs=Jii::app()->clientScript;
$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/scripts/jquery.maskedinput.min.js');
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
		<input type="text" name="field[<?php echo $fld_id; ?>]" id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>" value="<?php echo $field['defaultvalue']; ?>" class="validate <?php echo ($field['require'])?'required':''; ?>"/>
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
	$('#field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>').mask( '9999-99-99' );
});
</script>