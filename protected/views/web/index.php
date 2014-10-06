<script type="text/javascript">
window.sochivi.location.redirect = true;
</script>
<?php
function home_subcat($parentid){
	$criteria = new CDbCriteria;
	$criteria->addCondition('itm_parentid = '.$parentid);
	$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
	$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
	$criteria->limit = 4;
	$sub = Item::model()->findAll($criteria);
	if(!empty($sub) && is_array($sub)){
		echo '<ul>';
		foreach($sub as $s){
		?>
			<li>
				<a class="titillium" href="<?php echo Jii::app()->createUrl('item/list',array('itemid'=>$s->itm_id));?>"><?php echo $s->itm_name;?><span> (<?php echo count_items($s->itm_id,0);?>)</span></a>
				<?php //subcategories($s->itm_id);?>
			</li>
		<?php
		}
		echo '</ul>';
	}
}

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
?>
<div class="banner-container">
	<div class="banner-text titillium" id="banner1"><?php echo Jii::t('Your virtual ');?><b><?php echo Jii::t('marketplace! ');?></b></div>
	<div class="banner-text titillium" id="banner2" style="display:none;"><?php echo Jii::t('Build your ');?><b><?php echo Jii::t('store');?></b><?php echo Jii::t(" or simply place an ");?><b><?php echo Jii::t('ad');?></b></div>
</div>

<script type="text/javascript">
$('document').ready(function() {
	slides(1);
});

function slides(i){
	if(i == 1){
		$('.banner-container .banner-text').hide();
		$('.banner-container #banner1').show();
		window.setTimeout('slides(2)',3000);
	}else if(i == 2){
		$('.banner-container .banner-text').hide();
		$('.banner-container #banner2').show();
		window.setTimeout('slides(1)',3000);
	}
}
</script>

<?php
$criteria = new CDbCriteria;
$criteria->addCondition('itm_parentid = 0');
$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
$cat = Item::model()->findAll($criteria);
if(!empty($cat) && is_array($cat)){
	$i = 1;
	$border = 1;
	foreach($cat as $c){
	?>
		<div class="box-container">
			<?php
				$link = Jii::app()->createUrl('item/list',Item::urlOptions($c->itm_id,$c->itm_name));
				if($c->itm_id == 12) $link = 'javascript://';
			?>
			<div class="box-image box-image-<?php echo strtolower($c->itm_name);?>"><a class="box-image-link" href="<?php echo $link;?>"></a></div>
			<div class="title-container border-<?php echo $border;?>">
				<div class="title titillium"><?php echo $c->itm_name;?></div>
				<a class="titillium" href="<?php echo $link;?>">view all</a>
				<div class="clear"></div>
			</div>
			<div class="categories-list">
				<?php //home_subcat($c->itm_id); ?>
			</div>
			<div>
				<a class="search-ads titillium" href="<?php echo $link;?>">Search <?php echo $c->itm_name;?></a>
				<span class="search-ads-icons search-ads-<?php echo strtolower($c->itm_name);?>"></span>
				<div class="clear"></div>
			</div>
			<div><a class="place-ads titillium" href="<?php echo Jii::app()->createUrl('web/adscategory',array('itemid'=>$c->itm_id));?>">Place your Ad - Free</a></div>
			<div class="clear"></div>
		</div>
	<?php
	if($i%3 == 0 && $i<6){
		$border = 0;
		?>
			<div class="clear" style="height:25px"></div>
		<?php
	}
	$i++;
	$border++;
	}
}
?>


<div class="clear"></div>