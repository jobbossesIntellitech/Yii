<div id="logo">
	<a href="<?php echo Jii::app()->getHomeUrl(); ?>"></a>
</div>
<div id="search-panel">
	<div class="find titillium"><?php echo Jii::t('Find a:');?></div>
	<input type="text" id="search-text" name="search-text" placeholder="<?php echo Jii::t('Type to Search...');?>"/>
	<div class="example"><?php echo Jii::t('eg. BMW, Appartment, Closet...');?></div>
	<div class="box"><a href="javascript://"><?php echo Jii::t('All Categories');?></a></div>
	<div class="box"><a href="javascript://"><?php echo Jii::t('All Cities');?></a></div>
	<div class="search-logo"></div>
	<div class="search-advanced"><a href="javascript://"><?php echo Jii::t('advanced Search');?></a></div>
	<div class="clear"></div>
</div>
<?php
if(isset($sidebar) && !empty($sidebar)){
	$image = json_decode($sidebar->con_gallery);
    $img = new ImageProcessor(Jii::app()->basePath.'/..'.$image[0]);
	$img->setIdentity('sidebar');
	$img->resizeInto(180,350,255,255,255);
	echo '<img src="'.$img->output(IMAGETYPE_PNG).'"/>';
}
?>
<div class="clear"></div>

<script type="text/javascript">
	var search_hold = '<?php echo Jii::t('Type to Search...'); ?>';
	var search_input = null;
	$(document).ready(function(){
		search_input = $('#search-panel #search-text');
		search_action();
		search_input.focus(function(){
			search_action();	
		});	
		search_input.blur(function(){
			search_action();	
		});
	});

	function search_action(){
	if(search_input.val() == ""){
		search_input.val(search_hold);	
		search_input.css('color','#bbb');
	}else
	if(search_input.val() == search_hold){
		search_input.val("");
		search_input.css('color','#000');	
	}else{
		search_input.css('color','#000');	
	}		
	}
</script>