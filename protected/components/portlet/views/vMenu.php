<?php
if(isset($menu['items']) && is_array($menu['items']) && !empty($menu['items'])){
	echo '<div id="'.$this->hook.'-navigation">';
		echo $this->tree($menu['items']);
	echo '</div>';
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$( '#<?php echo $this->hook; ?>-navigation .parent' ).hover( 
		function(){
			$(this).find('ul.child').slideDown(200);
			$(this).find('ul.child').find('ul.child').hide();
		}, 
		function(){
			$(this).find('.child').hide();
		}
	);
});
</script>