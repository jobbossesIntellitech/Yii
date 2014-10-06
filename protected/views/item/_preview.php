<div class="preview-page">
	
	<?php if(isset($subcat) && !empty($subcat) && is_array($subcat)){?>
	<div class="list-subcategories">
		<div class="title-box">
			<?php if(isset($parentitem) && !empty($parentitem)){?>
				<span class="titillium"><?php echo Jii::t('Browse results in:').' '; ?></span> 
				<?php echo get_parent($this_item->itm_parentid,'').$this_item->itm_name;?>
			<?php }else{ ?>
				<span class="titillium"><?php echo Jii::t('Browse results in:').' '; ?></span> 
				<?php echo $this_item->itm_name;?>
			<?php } ?>
		</div>
		<?php
		if(isset($subcat) && !empty($subcat) && is_array($subcat)){
			foreach($subcat as $s){
			$count = count_items($s->itm_id,0); 
				if(!empty($count)){
					?>
						<div class="item">
							<a class="titillium" href="<?php echo Jii::app()->createUrl('item/list',array('itemid'=>$s->itm_id));?>"><?php echo $s->itm_name; ?></a>
						</div>
					<?php
				}
			}
		}
		?>
		<div class="clear"></div>
	</div>
	<?php }else{?>
		<div class="list-samelevel">
			<div class="title-box">
				<span class="titillium"><?php  echo Jii::t('Browse results in:').' '; ?></span>
				<?php if(isset($parentitem) && !empty($parentitem)){?>
					<?php echo get_parent($this_item->itm_id,'');?>
					<?php if(isset($ads) && !empty($ads)) echo $ads->ads_name;?>
					<?php //if($this_item->itm_type == 1) echo ' > '.$this_item->itm_name;?>
				<?php }else{
					echo Jii::t('Root');
				}?>
			</div>
			<?php
			if(isset($samelevel) && !empty($samelevel) && is_array($samelevel)){
				foreach($samelevel as $s){
				$count = count_items($s->itm_id,0); 
				/*if(!empty($count)){
						?>
							<div class="item">
								<a class="titillium" href="<?php echo Jii::app()->createUrl('item/list',array('itemid'=>$s->itm_id));?>"><?php echo $s->itm_name; ?><span> (<?php $cc = count_items($s->itm_id,0); if(!empty($cc)){echo $cc;}else{echo '0';} ?>)</span></a>
							</div>
						<?php
					}*/
				}
			}
			?>
			<div class="clear"></div>
		</div>
	<?php }?>
	
	<?php if(isset($subitems) && !empty($subitems) && is_array($subitems)){?>
		<div class="list-subcategories">
			<div class="title-box">
				<span class="titillium"><?php echo Jii::t('List Sub Items of:').' '; ?></span>
				<a href="<?php echo Jii::app()->createUrl('item/list',array('itemid'=>$parentitem->itm_id));?>"><?php echo $parentitem->itm_name;?></a>
				<?php echo ' > '.$this_item->itm_name;?>
			</div>
			<?php
			if(isset($subitems) && !empty($subitems) && is_array($subitems)){
				foreach($subitems as $s){
				?>
					<div class="item">
						<a class="titillium" href="<?php echo Jii::app()->createUrl('item/list',array('itemid'=>$s->itm_id));?>"><?php echo $s->itm_name; ?></a>
					</div>
				<?php
				}
			}
			?>
			<div class="clear"></div>
		</div>
	<?php }?>
	
	
	
	
	

	<?php 
	if(isset($ads) && !empty($ads)){
	?>
		<div class="preview-ads">
			<div class="left-block">
				<div class="image">
					<?php $image = explode(',',$ads->ads_gallery); $count_images = count($image);?>
					<img src="<?php echo Jii::app()->baseUrl.'/assets/uploads/ads/'.$ads->ads_id.'/'.$image[0]; ?>" onError="this.src='<?php echo Jii::app()->baseUrl.'/assets/notfound.jpg'; ?>'" >
					<a class="enlarge titillium" href="javascript://"><?php echo $count_images.'  '.Jii::t('Pictures Availables Click to Enlarge');?></a>
					
					<div class="gallery" style="display:none;">
						<?php 
						if(!empty($image) && isset($image) && is_array($image)){
							$image = array_reverse($image);
							foreach($image as $g){
								?>
								
									<a href="<?php echo Jii::app()->baseUrl.'/assets/uploads/ads/'.$ads->ads_id.'/'.$g; ?>" class="to-large" img="<<?php echo Jii::app()->baseUrl.'/assets/uploads/ads/'.$ads->ads_id.'/'.$g; ?>" rel="group">
										<img src="<?php echo Jii::app()->baseUrl.'/assets/uploads/ads/'.$ads->ads_id.'/'.$g; ?>" onError="this.src='<?php echo Jii::app()->baseUrl.'/assets/notfound.jpg'; ?>'" > 
									</a>
								
								<?php
							}
						}
						
						?>
					</div>
					<script type="text/javascript">
					$('document').ready(function() {
						$('.image a.enlarge').click(function(){
							$('.image a.to-large').click();
						});
						$('.image img').click(function(){
							$('.image a.to-large').click();
						});
						$("a.to-large").fancybox({
								'zoomSpeedIn'		:	500,
								'zoomSpeedOut'		:	500,
								'overlayOpacity'	:	0.7,
								'overlayColor'		:	'#000',
							});
					});
					</script>
				</div>
				<div class="description">
					<div>
						<span class="name"><?php echo Jii::t('Reference: ');?></span>
						<span class="text"><?php echo $ads->ads_reference;?></span>
					</div>
					<div class="clear" style="border-bottom:1px dotted #d7d7d7; width:100%;"></div>
					<?php 
						$desc = get_description($ads->ads_saverequestkey);
						if(isset($desc) && !empty($desc) && is_array($desc)){
							foreach($desc as $d){
							?>
								<div>
									<span class="name">
										<?php
											$label = FormField::model()->findByPk($d->save_fieldid);
											if(!empty($label)) echo $label->fld_label.': ';
										?>
									</span>
									<!--<span class="text titillium"><?php //echo $d->save_value;?></span>-->
									<span class="text">
										<?php
											if(is_array(json_decode($d->save_value))){
												foreach(json_decode($d->save_value) as $val){
													echo $val.', ';
												}
											}else{
												echo $d->save_value;
											}
										?>
									</span>
								</div>
							<?php
							}
						}
					?>
					<div class="clear" style="border-bottom:1px dotted #d7d7d7; width:100%;"></div>
					<div>
						<span class="name"><?php echo Jii::t('Description: ');?></span>
						<span class="text"><?php echo $ads->ads_description;?></span>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="right-block">
				<div class="title">
					<div class="name titillium"><?php echo $ads->ads_name; ?></div>
					<div class="clear"></div>
					<div class="date"><?php echo date('d F, Y',strtotime($ads->dates->dat_creation));?></div>
				</div>
				<div class="clear"></div>
				<div <?php if($ads->ads_price == 0) echo 'style="display:none;"';?> class="price titillium">
					<?php echo number_format($ads->ads_price);?>
					<span class="currency"><?php $cur = Currency::model()->findByPk($ads->ads_currencyid ); echo (isset($cur))?$cur->cur_sign:'';?></span>
				</div>
				<div class="clear"></div>
				<div class="rw-ui-container rw-urid-<?php echo $ads->ads_id;?>"></div>
				<div class="clear" style="border-bottom:1px dotted #d7d7d7; width:100%; padding-top:15px;"></div>
				<div class="contact-block">
					<a id="contact-details" class="details titillium" href="javascript://"><?php echo Jii::t('Call the seller');?></a>
					<span class="contact-seperator"><?php echo Jii::t('or');?></span>
					<a id="contact-email"class="details titillium" href="javascript://"><?php echo Jii::t('Send an email ');?></a>
					<div class="clear" style="height:10px;"></div>
					<?php
						if(!Jii::app()->user->isGuest){
							$criteria = new CDbCriteria();
							$criteria->addCondition('fav_adid = '.$ads->ads_id);
							$criteria->addCondition('fav_memberid = '.Jii::app()->user->id);
							$fav = Favorite::model()->find($criteria);
							if(!empty($fav)){
								?>
									<a id="favorite-button" class="details titillium" href="javascript://" style="line-height:18px;"><?php echo Jii::t('Remove from Favorites');?></a>
								<?php
							}else{
								?>
								<a id="favorite-button" class="details titillium" href="javascript://"><?php echo Jii::t('Add to Favorites');?></a>
							<?php
							}
						}else{
						?>
							<span class="details titillium" ><?php echo Jii::t('Add to Favorites');?></span>
						<?php
						}
					?>
					
					<a id="tellfriend-button" class="details titillium" href="javascript://" style="margin-left:32px;"><?php echo Jii::t('Tell a Friend');?></a>
					<div class="clear"></div>
					<div class="phone">
						<?php 
							if($ads->ads_phone != ''){ 
								echo 'Phone: '.$ads->ads_phone;
							}else{
								echo "Phone number doesn't exist";
							}
							/*$member = Member::model()->findByPk($ads->ads_memberid);
							if(!empty($member)) echo 'Phone: '.$member->mbr_phone;*/
						?>
					</div>
					<div class="mailing">
						<?php
						CHtml::$afterRequiredLabel = ' <span class="required">(required)</span> ';
						$h = new Html($model,$this,array(
							'id'=>'email-form',
							'enableAjaxValidation'=>true,
							'enableClientValidation'=>true,
							'htmlOptions'=>array('action'=>Jii::app()->createUrl('item/preview',array())),
						));
						$h->begin();
						echo $h->text('email');
						echo '<div class="sep"></div>';
						echo $h->text('name');
						echo '<div class="sep"></div>';
						echo $h->text('phone');
						echo '<div class="sep"></div>';
						echo $h->textArea('message');
						echo $h->submit(Jii::t('Send Email'));
						$h->end();
						?>  
					</div>
					<div class="tellfriend-mailing">
						<?php
						CHtml::$afterRequiredLabel = ' <span class="required">(required)</span> ';
						$h = new Html($modelfriend,$this,array(
							'id'=>'emailfriend-form',
							'enableAjaxValidation'=>true,
							'enableClientValidation'=>true,
							'htmlOptions'=>array('action'=>Jii::app()->createUrl('item/preview',array())),
						));
						$h->begin();
						echo $h->text('email_from');
						echo '<div class="sep"></div>';
						echo $h->text('name_from');
						echo '<div class="sep"></div>';
						echo $h->text('email_to');
						echo '<div class="sep"></div>';
						echo $h->text('name_to');
						echo '<div class="sep"></div>';
						echo $h->textArea('message');
						echo $h->submit(Jii::t('Send Email'));
						$h->end();
						?>  
					</div>
					<div class="clr"></div>
					
					
					<script type="text/javascript">
					$('document').ready(function() {
						$('.j-form .field .label span.required').html('*');
						$('.j-form .field .label span.required').css('color','#000');
						
						$('.contact-block #contact-details').click(function(){
							$('.contact-block .mailing').hide();
							$('.contact-block .tellfriend-mailing').hide();
							$('.contact-block .phone').slideDown('slow');
						});
						$('.contact-block #contact-email').click(function(){
							$('.contact-block .phone').hide();
							$('.contact-block .tellfriend-mailing').hide();
							$('.contact-block .mailing').slideDown('slow');
						});
						$('.contact-block #tellfriend-button').click(function(){
							$('.contact-block .mailing').hide();
							$('.contact-block .phone').hide();
							$('.contact-block .tellfriend-mailing').slideDown('slow');
							$('#EmailfriendForm_message').html('');
							$('#EmailfriendForm_message').append('Check out what I found on sochivi.com');
							//window.open('mailto:?subject=Sochivi Website&body='+encodeURIComponent(window.location), '_self');
						});
						$('.contact-block #favorite-button').click(function(){
							var favorite_button = $(this);
							$.ajax({
								url: "<?php echo Yii::app()->createURL("item/savefavorite")?>?adsid=<?php echo $ads->ads_id;?>",
								type: "POST",
								data : '',
								dataType : 'json',
								beforeSend: function() {
									//	INVOKE THE OVERLAY
								},
								success: function(data) { 
									if(data.list == '1'){
										//alert('You have been delele your fav');
										favorite_button.empty();
										favorite_button.append('<?php echo Jii::t('Add to Favorites');?>');
										favorite_button.css('line-height','35px');
									}else if(data.list == '2'){
										//alert('You have been added your fav');
										favorite_button.empty();
										favorite_button.append('<?php echo Jii::t('Remove from Favorites');?>');
										favorite_button.css('line-height','18px');
									}
								},
								error: function(ex) {
									//alert("An error occured: " + ex.status + " " + ex.statusText);
								}
							});
						});
					});
					</script>
					<div class="facebook-block">
						<div class="fb-like" data-href="http://sochivi.com/beta/" data-width="350" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear" style="border-bottom:1px dotted #d7d7d7; width:100%; padding-top:15px;"></div>
				<div class="location-box">
					<?php echo 'Located: '.Location::breadcrumblocation($ads->ads_locationid,true,$ads->ads_map);?>
				</div>
				<div class="clear"></div>
				<div class="category-box">
					<?php echo Item::breadcrumbitem($ads->ads_itemid);?>
				</div>
				<div class="advertisement">Ads 400x250 pixels</div>
				<?php if(isset($relatedads) && !empty($relatedads) && is_array($relatedads)){?>
					<div class="related-block">
						<div class="rel-title titillium"><?php echo Jii::t('Related Items');?></div>
						
						<?php 
						if(isset($relatedads) && !empty($relatedads) && is_array($relatedads)){
							foreach($relatedads as $rel){
							?>
								<div class="item">
									<?php $image = explode(',',$rel->ads_gallery);?>
									<img src="<?php echo Jii::app()->baseUrl.'/assets/uploads/ads/'.$rel->ads_id.'/'.$image[0]; ?>" onError="this.src='<?php echo Jii::app()->baseUrl.'/assets/notfound.jpg'; ?>'" >
									<div class="desc">
										<div class="name"><a href="<?php echo Jii::app()->createUrl('item/preview',array('itemid'=>$rel->ads_itemid,'adsid'=>$rel->ads_id));?>"><?php echo $rel->ads_name;?></a></div>
										<div class="clear"></div>
										<div class="location"><?php echo Location::get($rel->ads_locationid);?></div>
										<div class="clear"></div>
										<div class="price">
											<?php echo $rel->ads_price;?>
											<span class="currency"><?php $cur = Currency::model()->find($rel->ads_currencyid ); echo $cur->cur_sign;?></span>
										</div>
									</div>
									<div class="clear"></div>
								</div>
								<div class="clear"></div>
							<?php
							}
						}
						?>
						
					</div>
				<?php }?>
			</div>
			
			
			<div class="clear"></div>
		</div>
	<?php
	}
	?>
	
	
</div>


<?php
function get_parent($itemid, $links){
			
	$this_item = Item::model()->findByPk($itemid);
	
	if($this_item->itm_parentid > 0){
		$links = get_parent($this_item->itm_parentid, $links);
	}
	return $links.'<a href="'.Jii::app()->createUrl('item/list',array('itemid'=>$this_item->itm_id)).'">'.$this_item->itm_name.'</a>'.' > ';
}
		
function count_items($parentid,$count){
	$criteria = new CDbCriteria;
	$criteria->addCondition('itm_parentid = '.$parentid);
	$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
	//$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
	$subcat = Item::model()->findAll($criteria);
	if(!empty($subcat) && is_array($subcat)){
		$n = 0;
		foreach($subcat as $sub){
			$n += count_items($sub->itm_id,$count);
		}
		return $n;
	}else{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('ads_itemid = '.$parentid);
		$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
		$items = Ads::model()->findAll($criteria);
		
		if(!empty($items) && is_array($items)){
			$count += count($items);
			return $count;
		}
	}
}

function count_ads($itemid){
	$criteria = new CDbCriteria;
	$criteria->addCondition('ads_itemid = '.$itemid);
	$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
	$items = Ads::model()->findAll($criteria);
	
	$count = 0;
	if(!empty($items) && is_array($items)) $count = count($items);
	return $count;
}

function get_description($saverequestkey){
	$criteria = new CDbCriteria;
	$criteria->addCondition('save_requestkey = "'.$saverequestkey.'"');
	$descriptions = FormSave::model()->findAll($criteria);
	
	return $descriptions;
}
?>

<style type="text/css">
#email-form .j-form .field .input input[type="text"], #email-form .j-form .field .input input[type="password"], #email-form .j-form .field .input select, #email-form .j-form .field .input textarea{width:365px;}
#email-form .j-form .field .label label{text-align:left;}

#emailfriend-form .j-form .field .input input[type="text"], #emailfriend-form .j-form .field .input input[type="password"], #emailfriend-form .j-form .field .input select, #emailfriend-form .j-form .field .input textarea{width:365px;}
#emailfriend-form .j-form .field .label label{text-align:left;}
</style>


