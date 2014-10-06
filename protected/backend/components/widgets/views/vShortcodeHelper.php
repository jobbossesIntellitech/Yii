<div class="shortcode-helper-container">
	<h1>
		<?php echo Jii::t('Short Code Documentation'); ?>
		<a href="javascript://" id="closeShortCodeContainer"><?php echo Jii::t('Close'); ?></a>
	</h1>
	<div class="documentation">
		<?php echo JShortCode::helper(); ?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#outerPageTitle #innerPageTitle ul').append('<li><a href="javascript://" id="shortCodeContainer"><?php echo Jii::t('Short Code'); ?></a></li>');
	$('#outerPageTitle #innerPageTitle ul li a#shortCodeContainer').click(function(){
		$('.shortcode-helper-container').fadeIn(200);	
	});
	$('.shortcode-helper-container #closeShortCodeContainer').click(function(){
		$('.shortcode-helper-container').fadeOut(200);	
	});
});
</script>