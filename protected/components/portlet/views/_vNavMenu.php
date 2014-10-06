<?php
$c = strtolower(Jii::app()->controller->id);
$a = strtolower(Jii::app()->controller->action->id);
$id = isset($_GET['id'])?$_GET['id']:'0';

$criteria = new CDbCriteria;
$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
$criteria->with = array('adscount');
$items = Item::model()->findAll($criteria);
$data = array();

if(!empty($items) && is_array($items)){
	foreach($items as $item){
		if(!isset($data[$item->itm_parentid])){
			$data[$item->itm_parentid] = array();
			$data[$item->itm_parentid]['title'] = '';
			$data[$item->itm_parentid]['ads'] = 0;
		}
		if(!isset($data[$item->itm_parentid]['children'])){
			$data[$item->itm_parentid]['children'] = array();
		}
		$data[$item->itm_id] = array();
		$data[$item->itm_id]['title'] = $item->itm_name;
		$data[$item->itm_id]['ads'] = $item->adscount;
		$data[$item->itm_id]['children'] = array();
		$data[$item->itm_parentid]['children'][] = $item->itm_id;
		$data[$item->itm_parentid]['ads'] += $item->adscount;
	}
}
//Jii::print_r($data);

function subcategories($parentid, $data, $level, $i = false, $status){
	$return = '';
	if(isset($data[$parentid])){
		$sub = $data[$parentid]['children'];
		
		if(!empty($sub) && is_array($sub) && ($level < 2)){
			$level++;
			if($i){
				$return .= '<div class="hidden" id="news-items-'.$status.'">';	
			}
			$return .= '<ul>';
			$return .= '<li class="view-all"><a href="'.Jii::app()->createUrl('item/list',array('itemid'=>$parentid)).'">View All</a></li>';
			$j = 0;
			foreach($sub as $k => $v){
				$j++;
				//$count = count_items_ads($v,0);
				$item = $data[$v];
				//if(!empty($count)){
					$return .='
						<li '.(($level > 0) && ($j>15)?'class="hidden-menu-item"':'').'>
							<a href="'. Jii::app()->createUrl('item/list',array('itemid'=>$v)).'">'.$item['title'].'</a>
							'.subcategories($v,$data,$level,false,$status).'
						</li>
					';
					if($j == 15){
						$return .= '<li><a class="menu_show_more" href="javascript://">Show More >>></a></li>';
					}
				//}
			}
			//echo '<div class="clear"></div>';
			//echo '<li class="view-all"><a href="javascript://">View All</a></li>';
			$return .= '<div class="clear"></div>';
			$return .= '</ul>';
			$return .= '<div class="clear"></div>';
			
			if($i){
				$return .= '</div>';
			}
		}
	}
	return $return;
}
?>

<script type="text/javascript">
$('document').ready(function(){
	
	/*$('#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul > li > ul').each(function(){
		//$(this).css('height',($(this).parent().parent().css('height')));
		$(this).parent().parent().css('height');
	});
	
	$(document).on('mouseover','#main-navigation > ul > li > div.submenu-box-container > div.submenu-box > ul.level_1 > li',function(){
		//alert('s');
		//var h = $(this).parents('.submenu-box').height(); 
		
		/*$(this).find('ul.level_2').each(function(i,e){
			if(h < $(e).height()){
				h =$(e).height();
			}
			if($(e).height() < h) $(e).height(h);
		});*/
		/*var childen_height = $(this).find('ul.level_2').height();
		var parent_height = $(this).parent().height();
		var height = (childen_height > parent_height)?childen_height:parent_height;
		
		$(this).parents('.submenu-box').height(height);
		$(this).find('ul.level_2').height(height);*/
		//$(this).parent().height(height);
		//alert($(this).height());
	//});

	
});
</script>

<?php

function count_items_ads($parentid,$count){
	$criteria = new CDbCriteria;
	$criteria->addCondition('itm_parentid = '.$parentid);
	$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
	$subcat = Item::model()->findAll($criteria);
	if(!empty($subcat) && is_array($subcat)){
		$n = 0;
		foreach($subcat as $sub){
			$n += count_items_ads($sub->itm_id,$count);
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
<div id="main-navigation">

<ul>
	<li>
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="#news-items-1" id="hierarchybreadcrumb_1"></a>
		<span class="titillium" id="">motors</span>
		<div class="shape"></div>
		<?php echo subcategories(1,$data,0,true,1);?>
	</li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="#news-items-2" id="hierarchybreadcrumb_2"></a>
		<span class="titillium">classifieds</span>
		<div class="shape"></div>
		<?php echo subcategories(2,$data,0,true,2);?>
    </li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="#news-items-3" id="hierarchybreadcrumb_3"></a>
		<span class="titillium">properties</span>
		<div class="shape"></div>
		<?php echo subcategories(6,$data,0,true,3);?>
	</li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="#news-items-4" id="hierarchybreadcrumb_4"></a>
		<span class="titillium">jobs</span>
		<div class="shape"></div>
		<?php echo subcategories(10,$data,0,true,4);?>
    </li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="#news-items-5" id="hierarchybreadcrumb_5"></a>
		<span class="titillium">community</span>
		<div class="shape"></div>
		<?php echo subcategories(11,$data,0,true,5);?>
    </li>
	
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="javascript://" id="hierarchybreadcrumb_6"></a>
		<span class="titillium">deals</span>
		<div class="shape"></div>
		<?php echo subcategories(12,$data,0,true,6);?>
    </li>
</ul>
</div>





