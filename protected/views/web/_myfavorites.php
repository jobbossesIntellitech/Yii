<script type="text/javascript">
window.sochivi.location.redirect = true;
</script>
<?php if(isset($listads) && !empty($listads) && is_array($listads)){?>
<div class="list-page">
	<div class="list-subcategories">
		<div class="title-box" style="border:none;">
			<span class="titillium" style="font-size:20px;"><?php echo Jii::t('My Favorites'); ?></span> 
		</div>
		<div class="clear"></div>
	</div>
	
	
	<div class="shape">
		<a href="javascript://">
			<span style="font-weight:bold;">Sort By: </span>
			<?php
				if(Jii::param('sort') && Jii::param('order')){
					$sort = Jii::param('sort');
					$order = Jii::param('order');
					if($sort == 'ads_price' && $order == 'ASC'){ echo 'Price -- lowest to highest';}
					else if($sort == 'ads_price' && $order == 'DESC'){ echo 'Price -- highest to lowest';}
					else if($sort == 'ads_id' && $order == 'ASC'){ echo 'Date posted -- oldest to newest';}
					else if($sort == 'ads_id' && $order == 'DESC'){ echo 'Date posted -- newest to oldest';}
				}
			?>
		</a>
	</div>
	<ul class="sorting-box" id="not-active">
		<li><a href="<?php echo Jii::app()->createUrl('web/myfavorites',array('sort'=>'ads_price','order'=>'ASC'));?>" id="price_low_to_high">Price -- lowest to highest</a></li>
		<li><a href="<?php echo Jii::app()->createUrl('web/myfavorites',array('sort'=>'ads_price','order'=>'DESC'));?>" id="price_high_to_low">Price -- highest to lowest</a></li>
		<li><a href="<?php echo Jii::app()->createUrl('web/myfavorites',array('sort'=>'ads_id','order'=>'ASC'));?>" id="date_old_to_new">Date posted -- oldest to newest</a></li>
		<li><a href="<?php echo Jii::app()->createUrl('web/myfavorites',array('sort'=>'ads_id','order'=>'DESC'));?>" id="date_new_to_old">Date posted -- newest to oldest</a></li>
	</ul>
	<div class="clear"></div>
	
	
	<div class="list-ads unsorted">
		<!--<div class="big-title">List-Ads</div>-->
	<?php
	if(isset($listads) && !empty($listads) && is_array($listads)){
		foreach($listads as $l){
		?>
			<div class="item" data-price="<?php echo isset($l->ads_price)?$l->ads_price:'';?>" data-date="<?php echo isset($l->dates->dat_creation)?strtotime($l->dates->dat_creation):'';?>">
				<div class="image">
					<?php $image = explode(',',$l->ads_gallery);?>
					<img class="image-ads" src="<?php echo Jii::app()->baseUrl.'/assets/uploads/ads/'.$l->ads_id.'/'.$image[0]; ?>" onError="this.src='<?php echo Jii::app()->baseUrl.'/assets/notfound.jpg'; ?>'" >
					<div class="clear" style="height:10px;"></div>
					<div style="float:left; left:0; width:180px;" class="rw-ui-container rw-urid-<?php echo $l->ads_id;?>"></div>
				</div>
				
				<div class="title">
					<a class="name titillium" href="<?php echo Jii::app()->createUrl('item/preview',array('adsid'=>$l->ads_id,'itemid'=>$l->ads_itemid));?>"><?php echo $l->ads_name; ?></a>
					<div class="clear"></div>
					<div class="date"><?php echo date('d F, Y',strtotime($l->dates->dat_creation));?></div>
					<div class="description">
						<div <?php if($l->ads_price == 0) echo 'style="display:none;"';?> class="price titillium">
							<?php echo number_format($l->ads_price);?>
							<span class="currency"><?php $cur = Currency::model()->findByPk($l->ads_currencyid); echo (isset($cur))?$cur->cur_sign:'';?></span>
						</div>
						<div class="clear"></div>
						<div class="desc">
							<?php 
								//echo $l->ads_saverequestkey;
								$desc = get_description($l->ads_saverequestkey);
								if(isset($desc) && !empty($desc) && is_array($desc)){
									$i = 1;
									foreach($desc as $d){
									?>
										<div>
											<span class="name">
												<?php
													$label = FormField::model()->findByPk($d->save_fieldid);
													if(!empty($label)) echo $label->fld_label;
												?>
											</span>
											<span class="text"><?php if(!empty($d->save_value)) echo ': '.$d->save_value;?></span>
										</div>
									<?php	
										//if($i%2 == 0) echo '<div class="clear"></div>';
										echo '<div class="clear"></div>';
										$i++;
									}
								}
							?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				
				<div class="member-container">
					<div class="member-image">
						<?php
							$user = Member::model()->findByPk($l->ads_memberid);
							if(isset($user->mbr_image) && !empty($user->mbr_image)){
							
								$image = '/assets/uploads/members/'.$user->mbr_image;
								if(isset($image) && !empty($image)){
									$img = new ImageProcessor(Jii::app()->params['rootPath'].$image);
									$img->setIdentity('list_member_image');
									$img->resizeInto(100,100);
									echo '<img src="'.$img->output(IMAGETYPE_PNG).'"/>';
								}else{
									echo '<img src="'.Jii::app()->baseUrl.'/assets/member.jpg"/>';
								}
							}else{
								echo '<img src="'.Jii::app()->baseUrl.'/assets/member.jpg" />';
							}
						?>
					</div>
					<div class="clear" style="height:10px;"></div>
					<div class="member-name">
						<div class="listed-title"><?php echo Jii::t('Listed by: ');?></div>
						<div class="listed-text"><?php echo $user->mbr_firstname.' '.$user->mbr_lastname;?></div>
					</div>
					<div class="clear"></div>
					<div class="view-profile"><a href="<?php echo Jii::app()->createUrl('web/viewprofile',array('id'=>$l->ads_memberid));?>"><?php echo Jii::t('View Profile');?></a></div>
				</div>
				
				<div class="clear"></div>
				<div class="location-box">
					<?php echo 'Located: '.Location::breadcrumblocation($l->ads_locationid,true,$l->ads_map);?>
				</div>
				<div class="clear"></div>
				<div class="category-box">
					<?php echo Item::breadcrumbitem($l->ads_itemid);?>
				</div>
				<div id="status_ads">
					<a href="<?php echo Yii::app()->createURL("item/savefavorite",array('adsid'=>$l->ads_id));?>"><?php echo Jii::t('Remove from Favorites');?></a>
				</div>
				
				<div class="clear"></div>
			</div>
		<?php
		}
	}
	?>
	</div>
		
					
					
	<div id="number_ads_page" style="float:right; margin:5px;">
		<select id="number_of_ads" name="number_of_ads">
			<option name="" value="5" <?php echo (Jii::param('number_ads') == '5')?'selected="selected"':'';?>>5</option>
			<option name="" value="10" <?php echo (Jii::param('number_ads') == '10')?'selected="selected"':'';?>>10</option>
			<option name="" value="25" <?php echo (Jii::param('number_ads') == '25')?'selected="selected"':'';?>>25</option>
			<option name="" value="50" <?php echo (Jii::param('number_ads') == '50')?'selected="selected"':'';?>>50</option>
		</select>
	</div>
	<div class="clear"></div>
	<div class="list-ads sorted"></div>
	
	<?php
		if($pages->pageCount > 1){
			echo '<div class="pagination">';
				$pagingoption=array(
					'pages'=>$pages, "cssFile" => false,'maxButtonCount'=>4,"firstPageLabel"=>Jii::t("<<"),"lastPageLabel"=>Jii::t(">>"),
										"nextPageLabel"=>Jii::t(">")	,"prevPageLabel"=>Jii::t("<"),"header"=>"",
				);
				$this->widget('CLinkPager',$pagingoption);
			echo '</div>';	
		}
	?>
</div>
<?php 
}else{
?>
<div class="list-page">
	<div class="list-subcategories">
		<div class="title-box" style="border:none;">
			<span class="titillium" style="font-size:20px;"><?php echo Jii::t('My Favorites'); ?></span> 
		</div>
		<div class="clear"></div>
	</div>
	<div class="empty-list"><?php echo Jii::t('Empty List');?></div>
</div>
<?php
}
?>


<?php
function get_parent($itemid, $links){
	$this_item = Item::model()->findByPk($itemid);
	
	if($this_item->itm_parentid > 0){
		$links = get_parent($this_item->itm_parentid, $links);
	}
	return $links.' > '.'<a href="'.Jii::app()->createUrl('item/list',array('itemid'=>$this_item->itm_id)).'">'.$this_item->itm_name.'</a>';
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
	$criteria->with = array('field');
	$criteria->order = 'field.fld_position ASC';
	$criteria->limit = 4;
	$descriptions = FormSave::model()->findAll($criteria);
	
	return $descriptions;
}
?>
<script type="text/javascript">
$('document').ready(function() {
	$('#status_ads a').unbind('click').click(function(e){
		e.preventDefault();
		var favorite_button = $(this);
		$.ajax({
			url: favorite_button.attr('href'),
			type: "POST",
			data : '',
			dataType : 'json',
			beforeSend: function() {
				//	INVOKE THE OVERLAY
			},
			success: function(data) { 
				if(data.list == '1'){
					//alert('The ad was removed from fav');
					window.location.href = '';
				}else if(data.list == '2'){
					//alert('The ad was added to fav');
				}
			},
			error: function(ex) {
				//alert("An error occured: " + ex.status + " " + ex.statusText);
			}
		});
	});
});
</script>
<script type="text/javascript">
$('document').ready(function() {	
	$('html').click(function() {
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
	});
	
	$('.list-page .shape').click(function(event){
		if($('.list-page .sorting-box').attr('id') == 'not-active'){
			$('.list-page .sorting-box').slideDown('slow');
			event.stopPropagation();
			//$('.list-page .sorting-box').show();	
			$('.list-page .sorting-box').attr('id','active');
		}
		else if($('.list-page .sorting-box').attr('id') == 'active'){
			$('.list-page .sorting-box').slideUp('slow');
			event.stopPropagation();
			//$('.list-page .sorting-box').hide();	
			$('.list-page .sorting-box').attr('id','not-active');
		}
	});
	
	$('.list-page .sorting-box').click(function(event){
		event.stopPropagation();
	});
	
	$('.list-page .sorting-box li a#price_low_to_high').click(function(event){
		$('.list-page .shape a').empty();
		$('.list-page .shape a').append('<span style="font-weight:bold;">Sort By: </span>'+$(this).html());
		$('.list-page .sorting-box li a').removeClass('selected');
		$(this).addClass('selected');
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
	});
	
	$('.list-page .sorting-box li a#price_high_to_low').click(function(event){
		$('.list-page .shape a').empty();
		$('.list-page .shape a').append('<span style="font-weight:bold;">Sort By: </span>'+$(this).html());
		$('.list-page .sorting-box li a').removeClass('selected');
		$(this).addClass('selected');
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
	});
	
	$('.list-page .sorting-box li a#date_old_to_new').click(function(event){
		$('.list-page .shape a').empty();
		$('.list-page .shape a').append('<span style="font-weight:bold;">Sort By: </span>'+$(this).html());
		$('.list-page .sorting-box li a').removeClass('selected');
		$(this).addClass('selected');
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
	});
	
	$('.list-page .sorting-box li a#date_new_to_old').click(function(event){
		$('.list-page .shape a').empty();
		$('.list-page .shape a').append('<span style="font-weight:bold;">Sort By: </span>'+$(this).html());
		$('.list-page .sorting-box li a').removeClass('selected');
		$(this).addClass('selected');
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
	});
	$('#number_ads_page #number_of_ads option').click(function(){
		window.location.href = '<?php echo Jii::app()->createUrl('web/myfavorites',array('sort'=>Jii::param('sort'),'order'=>Jii::param('order')));?>&number_ads='+$(this).val();
		//alert($(this).val());
	});
	
});

</script>


