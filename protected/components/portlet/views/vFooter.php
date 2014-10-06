<div class="footer-left-section">
	<ul class="footer-menu">
		<li><a href="<?php echo Jii::app()->getHomeUrl();?>">Home Page</a></li>
		<li><a href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>6));?>">About Us</a></li>
		<li><a href="<?php echo Jii::app()->createUrl('cms/category',array('id'=>2));?>">Blog</a></li>
		<!--<li><a href="javascript://">Newsletter</a></li>-->
		<li><a href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>7));?>">Contact Us</a></li>
		<li>
			<a></a>
			<ul class="social">
				<li><a id="facebook" href="https://www.facebook.com/pages/SoChivi/1475938355964083" target="_blank"></a></li>
				<li><a id="twitter" href="https://twitter.com/SoChivi" target="_blank"></a></li>
				<li><a id="linkedin" href="javascript://"></a></li>
				<li><a id="google" href="https://plus.google.com/u/1/b/100390678439017040020/100390678439017040020/posts" target="_blank"></a></li>
			</ul>	
		</li>
	</ul>
	<div class="clear"></div>
	
</div>

<div class="footer-right-section">
	<ul class="privacy">
		<li><a class="titillium" href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>8));?>">Terms of use</a></li>
		<li><a class="titillium" href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>9));?>" style="border-left:1px solid #ccc; padding-left:7px;">Privacy policy</a></li>
	</ul>
	<div class="clear"></div>
	<div id="copyright-sochivi">&copy All Rights Reserved SoChivi 2014.</div>
	<div class="clear"></div>
	<ul class="footer-country">
		<li><a data-location="60" id="ksa" href="javascript://"></a></li>
		<li><a data-location="3" id="uae" href="javascript://"></a></li>
		<li><a data-location="139" id="kuwait" href="javascript://"></a></li>
		<li><a data-location="97" id="qatar" href="javascript://"></a></li>
		<li><a data-location="82" id="bahrain" href="javascript://"></a></li>
		<li><a data-location="140" id="oman" href="javascript://"></a></li>
		<li><a data-location="1" id="lebanon" href="javascript://"></a></li>
	</ul>
</div>

<script type="text/javascript">
$('document').ready(function() {
	$('.footer-country li a').click(function(e){
		var elem = $(this);
		var country = $(this).attr('data-location');
		$.ajax({
			url: "<?php echo Yii::app()->createURL("item/savelocation")?>?locationid="+country,
			type: "POST",
			beforeSend: function() {
				//	INVOKE THE OVERLAY
			},
			success: function(data) { 
				if(data == 1){
					if(window.sochivi.location.redirect){
						window.location.href = ''; 
					}
				}
			},
			error: function(ex) {
				//alert("An error occured: " + ex.status + " " + ex.statusText);
			}
		});
	});
	
});
</script>	