<div class="list-page">
	<div class="list-subcategories">
		<div class="title-box" style="border:none;">
			<span class="titillium" style="font-size:20px;"><?php echo Jii::t('Forgot Password'); ?></span> 
		</div>
		<div class="clear"></div>
	</div>
	<?php
	$h = new Html($model,$this,array(
		'id'=>'forgotpassword-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'action'=>Jii::app()->createUrl('web/forgotpassword'),
		'htmlOptions'=>array('method'=>'post'),
	));
	$h->begin();
	echo $h->section(Jii::t('Forgot Password'),array(
		'<p style="padding:5px;">'.Jii::t('To request a new password, enter your email address and select Send. You will then receive an email message to choose a new password.').'</p>',
		$h->text('email',array('class'=>'col_12')),
	));
	echo $h->submit(Jii::t('Send'));
	$h->end();
	?>
</div>
<br/>
<?php //$this->widget('wSection3'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#forgotpassword-form input[type=submit]').addClass('button').addClass('green');
	$('#forgotpassword-form input[type=reset]').addClass('button').addClass('red');
});
</script>