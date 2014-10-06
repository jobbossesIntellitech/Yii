<div class="list-page">
	
	<div class="shape"><a href="javascript://"><span style="font-weight:bold;">Sort By: </span></a></div>
	<ul class="sorting-box" id="not-active">
		<li><a href="javascript://" id="price_low_to_high">Price -- lowest to highest</a></li>
		<li><a href="javascript://" id="price_high_to_low">Price -- highest to lowest</a></li>
		<li><a href="javascript://" id="date_old_to_new">Date posted -- oldest to newest</a></li>
		<li><a href="javascript://" id="date_new_to_old">Date posted -- newest to oldest</a></li>
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
					<img src="<?php echo Jii::app()->baseUrl.'/assets/uploads/ads/'.$l->ads_id.'/'.$image[0]; ?>" onError="this.src='<?php echo Jii::app()->baseUrl.'/assets/notfound.jpg'; ?>'" >
				</div>
				
				<div class="title">
					<a class="name titillium" href="<?php echo Jii::app()->createUrl('item/preview',array('itemid'=>$l->ads_itemid,'adsid'=>$l->ads_id));?>"><?php echo $l->ads_name; ?></a>
					<div class="clear"></div>
					<div class="date"><?php echo date('d F, Y',strtotime($l->dates->dat_creation));?></div>
				</div>
				
				<div class="description">
					<div class="price titillium">
						<?php echo $l->ads_price;?>
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
												if(!empty($label)) echo $label->fld_label.': ';
											?>
										</span>
										<span class="text"><?php echo $d->save_value;?></span>
									</div>
								<?php	
									if($i%2 == 0) echo '<div class="clear"></div>';
									$i++;
								}
							}
						?>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="clear"></div>
				<div class="location-box">
					<?php echo 'Located: '.Location::breadcrumblocation($l->ads_locationid,true,$l->ads_map);?>
				</div>
				<div class="clear"></div>
				<div class="category-box">
					<?php echo Item::breadcrumbitem($l->ads_itemid);?>
				</div>
				
			</div>
		<?php
		}
	}else{
		echo "<div class='empty-list'>Empty List</div>";
	}
	?>
	</div>
	
	<div class="list-ads sorted"></div>
	
	<?php
		if($pages->pageCount > 1){
			echo '<div class="pagination">';
				$pagingoption=array(
					'pages'=>$pages, "cssFile" => false,'maxButtonCount'=>4,"firstPageLabel"=>Jii::t("First"),"lastPageLabel"=>Jii::t("Last"),
										"nextPageLabel"=>Jii::t("Next")	,"prevPageLabel"=>Jii::t("Previous"),"header"=>"",
				);
				$this->widget('CLinkPager',$pagingoption);
			echo '</div>';	
		}
	?>
</div>


<?php
function count_items($parentid,$count){
	$criteria = new CDbCriteria;
	$criteria->addCondition('itm_parentid = '.$parentid);
	$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
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
	$criteria->limit = 4;
	$descriptions = FormSave::model()->findAll($criteria);
	
	return $descriptions;
}
?>



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
		var sortedDivs = $(".unsorted").find("div.item").toArray().sort(sorter_low_to_high);
		$.each(sortedDivs, function (index, value) {
			$(".sorted").append(value);
		});
		
		$('.list-ads.unsorted').html('');
		$('.list-ads').each(function(){
			if($(this).html() == ''){
				$(this).removeClass('unsorted');
				$(this).addClass('sorted');
			}else{
				$(this).removeClass('sorted');
				$(this).addClass('unsorted');
			}
		});
	});
	
	$('.list-page .sorting-box li a#price_high_to_low').click(function(event){
		$('.list-page .shape a').empty();
		$('.list-page .shape a').append('<span style="font-weight:bold;">Sort By: </span>'+$(this).html());
		$('.list-page .sorting-box li a').removeClass('selected');
		$(this).addClass('selected');
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
		var sortedDivs = $(".unsorted").find("div.item").toArray().sort(sorter_high_to_low);
		$.each(sortedDivs, function (index, value) {
			$(".sorted").append(value);
		});
		
		$('.list-ads.unsorted').html('');
		$('.list-ads').each(function(){
			if($(this).html() == ''){
				$(this).removeClass('unsorted');
				$(this).addClass('sorted');
			}else{
				$(this).removeClass('sorted');
				$(this).addClass('unsorted');
			}
		});
	});
	
	$('.list-page .sorting-box li a#date_old_to_new').click(function(event){
		$('.list-page .shape a').empty();
		$('.list-page .shape a').append('<span style="font-weight:bold;">Sort By: </span>'+$(this).html());
		$('.list-page .sorting-box li a').removeClass('selected');
		$(this).addClass('selected');
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
		var sortedDivs = $(".unsorted").find("div.item").toArray().sort(sorter_date_low_to_high);
		$.each(sortedDivs, function (index, value) {
			$(".sorted").append(value);
		});
		
		$('.list-ads.unsorted').html('');
		$('.list-ads').each(function(){
			if($(this).html() == ''){
				$(this).removeClass('unsorted');
				$(this).addClass('sorted');
			}else{
				$(this).removeClass('sorted');
				$(this).addClass('unsorted');
			}
		});
	});
	
	$('.list-page .sorting-box li a#date_new_to_old').click(function(event){
		$('.list-page .shape a').empty();
		$('.list-page .shape a').append('<span style="font-weight:bold;">Sort By: </span>'+$(this).html());
		$('.list-page .sorting-box li a').removeClass('selected');
		$(this).addClass('selected');
		$('.list-page .sorting-box').slideUp('slow');
		$('.list-page .sorting-box').attr('id','not-active');
		var sortedDivs = $(".unsorted").find("div.item").toArray().sort(sorter_date_high_to_low);
		$.each(sortedDivs, function (index, value) {
			$(".sorted").append(value);
		});
		
		$('.list-ads.unsorted').html('');
		$('.list-ads').each(function(){
			if($(this).html() == ''){
				$(this).removeClass('unsorted');
				$(this).addClass('sorted');
			}else{
				$(this).removeClass('sorted');
				$(this).addClass('unsorted');
			}
		});
	});
	
});

function sorter_low_to_high(a, b) {
	return a.getAttribute('data-price') - b.getAttribute('data-price');
};
function sorter_high_to_low(a, b) {
	return b.getAttribute('data-price') - a.getAttribute('data-price');
};

function sorter_date_low_to_high(a, b) {
	return a.getAttribute('data-date') - b.getAttribute('data-date');
};
function sorter_date_high_to_low(a, b) {
	return b.getAttribute('data-date') - a.getAttribute('data-date');
};
</script>

