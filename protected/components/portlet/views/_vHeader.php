<div class="header-adss"><?php echo Jii::t('Ads 728x90 pixels');?>
<?php
if(isset($header_ads) && !empty($header_ads)){
	$image = json_decode($header_ads->con_gallery);
    $img = new ImageProcessor(Jii::app()->basePath.'/..'.$image[0]);
	$img->setIdentity('sidebar');
	$img->resizeInto(728,90,0,0,0);
	echo '<img src="'.$img->output(IMAGETYPE_PNG).'"/>';
}
?>
</div>
<div class="clear"></div>
<div class="country-container">
	<div class="country"><?php echo Jii::t('Select Location');?></div>
	<?php 
		if(Jii::param('city')){
			$this->city = Jii::param('city'); 
		}else if(Jii::param('country')){
			$this->country = Jii::param('country'); 
		}else{
			$this->city = 0;
			$this->country = 0;
		}
		//echo $this->city.' '.$this->country;
	?>
	
	
	<div class="shape"><a href="javascript://"></a></div>
	<div class="home"><a href="<?php echo Jii::app()->getHomeUrl(); ?>"></a></div>
	
	<?php //echo CHtml::dropDownList('types',Location::type()->getList(),array('prompt'=>Jii::t('-- Add New Type --')));?>
	<?php
		$criteria = new CDbCriteria;
		$criteria->addCondition('t.loc_parentid = 0');
		$criteria->with = array('children');
		$criteria->addCondition('t.loc_status = '.Location::status()->getItem('enable')->getValue());
		$locations = Location::model()->findAll($criteria);
		
		if(!empty($locations) && is_array($locations)){
			?>
			<ul class="location-box" id="not-active">
				<?php
				foreach($locations as $loc){
					?>
						<li>
							<a href="javascript://">
								<span id="<?php echo $loc->loc_id;?>"><img width="15" height="10" src="<?php echo Yii::app()->request->baseUrl.''.$loc->loc_logo;?>" onError="this.src=<?php echo Jii::app()->baseUrl.'/assets/notfound.jpg'; ?>"/></span>
								<?php echo $loc->loc_name;?>
							</a>
							<?php
								if(isset($loc->children) && !empty($loc->children) && is_array($loc->children)){
									?>
									<ul>
										<?php
										foreach($loc->children as $c){
											?>
											<li>
												<a href="javascript://">
													<span id="<?php echo $c->loc_id;?>"><img width="15" height="10" src="<?php echo Yii::app()->request->baseUrl.''.$c->loc_logo;?>" onError="this.src=<?php echo Jii::app()->baseUrl.'/assets/notfound.jpg'; ?>"/></span>
													<?php echo $c->loc_name;?>
												</a>
											</li>
											<?php
										}
										?>
									</ul>
									<?php
								}
							?>
						</li>
					<?php
				}
				?>
			</ul>
			<?php
		}
	?>
	
</div>
<script type="text/javascript">
$('document').ready(function() {
	var id = <?php echo Jii::app()->user->location;?>;
	var loc = $('.country-container .location-box li a span').each(function(){
		if($(this).attr('id') == id){
			var country = $(this).parent().html();
			$('.country-container .country').html(country);
		}
	});
	
	
	$('.country-container .location-box a').click(function(e){
		var elem = $(this);
		var country = $(this).find('span').attr('id');
		$('.country-container .location-box').slideUp('slow');
		$('.country-container .location-box').attr('id','not-active');
		
		/*var loadUrl = "<?php echo Yii::app()->createURL("item/findlocation")?>?locationid="+country;
		$.ajax(loadUrl).done(function(data){
			alert(data);
		});*/
		$.ajax({
			url: "<?php echo Yii::app()->createURL("item/savelocation")?>?locationid="+country,
			type: "POST",
			beforeSend: function() {
				//	INVOKE THE OVERLAY
			},
			success: function(data) { 
				if(data == 1){
					$('.country-container .country').html(elem.html());
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


<div class="header-right">
	<ul>
		<li><a href="<?php echo Jii::app()->createUrl('web/adscategory',array());?>" class="titillium"><?php echo Jii::t('Place an Ad');?></a></li>
		
		<?php if(Jii::app()->user->isGuest){?>
			<li class="sep"><a href="<?php echo Jii::app()->createUrl('web/register',array());?>" class="titillium"><?php echo Jii::t('Register');?></a></li>
			<li class="sep"><a id="login" href="javascript://" class="titillium"><?php echo Jii::t('Sign in');?></a></li>
			<li class="sep"><a href="<?php echo Jii::app()->createUrl('web/facebooklogin');?>" class="titillium" id="facebook"></a></li>
		<?php }else{?>
			<li class="sep"><a href="<?php echo Jii::app()->createUrl('web/myfavorites',array());?>" class="titillium"><?php echo Jii::t('My Favorites');?></a></li>
			<li class="sep"><a href="<?php echo Jii::app()->createUrl('web/myads',array());?>" class="titillium"><?php echo Jii::t('My Ads');?></a></li>
			<li class="sep"><a href="<?php echo Jii::app()->createUrl('web/editprofile',array('id'=>Jii::app()->user->id));?>" class="titillium"><?php echo Jii::t('My Account');?></a></li>
			
			<li style="padding:0 5px; position:relative;" class="sep">
				<span style="font-weight:bold; float:left;"><?php echo Jii::t('Welcome').' '.Jii::app()->user->firstname;?>,</span> <a style="display:inline; padding:0 0 0 3px; float:left;"  href="<?php echo Jii::app()->createUrl('web/logout');?>">Logout</a>
				<?php
					$user = Member::model()->findByPk(Jii::app()->user->id);
					if(isset($user->mbr_image) && !empty($user->mbr_image)){
					
						$image = '/assets/uploads/members/'.$user->mbr_image;
						if(isset($image) && !empty($image)){
							$img = new ImageProcessor(Jii::app()->params['rootPath'].$image);
							$img->setIdentity('header_image');
							$img->resizeInto(25,25);
							echo '<img style="float:right; padding-left:5px; top:-5px; position:relative;" width="25" height="25" src="'.$img->output(IMAGETYPE_PNG).'"/>';
						}else{
							echo '<img style="float:right; padding-left:5px; top:-5px; position:relative;" width="25" height="25" src="'.Jii::app()->baseUrl.'/assets/member.jpg"/>';
						}
						//echo '<img style="float:right; padding-left:5px; top:-5px; position:relative;" width="25" height="25" src="'.Jii::app()->baseUrl.'/assets/uploads/members/'.$user->mbr_image.'"/>';
					}else{
						echo '<img style="float:right; padding-left:5px; top:-5px; position:relative;" width="25" height="25" src="'.Jii::app()->baseUrl.'/assets/member.jpg" />';
					}
				?>
			</li>
		<?php }?>
	
	</ul>
</div>
<?php if(Jii::app()->user->isGuest){?>
<div class="login-box" id="not-active">
	<?php
	$h = new Html($model,$this,array(
		'id'=>'member-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
	));
	$h->begin();
	echo $h->text('username');
	echo $h->password('password');
	echo $h->submit(Jii::t('Login'));
	$h->end();
	?>
	<div class="clear"></div>
</div>
<?php }?>
<div class="clear"></div>

<script type="text/javascript">
$('document').ready(function() {
	
	$('html').click(function() {
		$('.login-box').slideUp('slow');
		$('.login-box').attr('id','not-active');
	});
	
	$('.header-right #login').click(function(event){
		if($('.login-box').attr('id') == 'not-active'){
			$('.login-box').slideDown('slow');
			event.stopPropagation();
			//$('.login-box').show();	
			$('.login-box').attr('id','active');
		}
		else if($('.login-box').attr('id') == 'active'){
			$('.login-box').slideUp('slow');
			event.stopPropagation();
			//$('.login-box').hide();	
			$('.login-box').attr('id','not-active');
		}
	});
	
	$('.login-box').click(function(event){
		event.stopPropagation();
	});
	
	$('.login-box .submit :submit').click(function(event){
		//document.location.href = '<?php echo Jii::app()->createUrl('web/index');?>';
	});
	
	
	
	
	
	
	$('html').click(function() {
		$('.country-container .location-box').slideUp('slow');
		$('.country-container .location-box').attr('id','not-active');
	});
	
	$('.country-container .shape').click(function(event){
		if($('.country-container .location-box').attr('id') == 'not-active'){
			$('.country-container .location-box').slideDown('slow');
			event.stopPropagation();
			//$('.country-container .location-box').show();	
			$('.country-container .location-box').attr('id','active');
		}
		else if($('.country-container .location-box').attr('id') == 'active'){
			$('.country-container .location-box').slideUp('slow');
			event.stopPropagation();
			//$('.country-container .location-box').hide();	
			$('.country-container .location-box').attr('id','not-active');
		}
	});
	
	$('.country-container .location-box').click(function(event){
		event.stopPropagation();
	});
});

</script>