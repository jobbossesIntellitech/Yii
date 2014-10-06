<?php 
$data = isset($form['sections'])?json_encode($form['sections']):'null'; 
?>
<div id="formGen">
	<div class="canvas-panel"></div>
	<div class="side-panel">
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var fields = new Array();
	<?php
	$fields = FormField::type()->getItems();
		if(!empty($fields) && is_array($fields)){
			foreach($fields AS $field){
				?>
				fields[fields.length] = {label:'<?php echo $field->getLabel(); ?>',type:'<?php echo $field->getKey(); ?>'};
				<?php
			}
		}
	?>
	var data = [];
	$('#formGen').formgenerator({
	fields:fields,
	canvas:'.canvas-panel',
	side:'.side-panel',
	saveUrl : '<?php echo Jii::app()->createUrl('form/save'); ?>',
	formId : <?php echo Jii::param('id'); ?>,
	data : <?php echo $data; ?>
	});
});
</script>