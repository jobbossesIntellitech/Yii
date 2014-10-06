<?php
$c = strtolower(Jii::app()->controller->id);
$a = strtolower(Jii::app()->controller->action->id);
$id = isset($_GET['id'])?$_GET['id']:'0';

/*$locations = Location::model()->getchildren(Jii::app()->user->location);
$locations[] = 0;
$locations = implode(',',$locations).','.Jii::app()->user->location;*/

$criteria = new CDbCriteria;
$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
//$criteria->with = array('adscount'=>array('condition'=>'ads_locationid in ('.$locations.') and ads_status = '.Ads::status()->getItem('enable')->getValue(),'together'=>false));
$criteria->order = 'itm_parentid DESC, itm_position DESC, itm_name ASC';
//$criteria->together = false;
$items = Item::model()->findAll($criteria);
$data = array();

if(!empty($items) && is_array($items)){
	foreach($items as $item){
		if(!isset($data[$item->itm_parentid])){
			$data[$item->itm_parentid] = array();
			$data[$item->itm_parentid]['title'] = '';
			$data[$item->itm_parentid]['ads'] = 0;
			$data[$item->itm_parentid]['children'] = array();
		}
		if(!isset($data[$item->itm_id] )){
			$data[$item->itm_id] = array();
			$data[$item->itm_id]['children'] = array();
			$data[$item->itm_id]['ads'] = 0;
		}
		$data[$item->itm_id]['title'] = $item->itm_name;
		$data[$item->itm_id]['ads'] += $item->adscount;
		$data[$item->itm_parentid]['children'][] = $item->itm_id;
		$data[$item->itm_parentid]['ads'] += $item->adscount;
	}
}

/*function count_ads_tree($itemid,$locs){
	$criteria = new CDbCriteria;
	$criteria->addCondition('ads_itemid = '.$itemid);
	$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
	
	//$childrens = Location::model()->getchildren(Jii::app()->user->location);
	//$childrens[] = 0;
	$criteria->addCondition('ads_locationid in ('.$locs.')');
	
	$items = Ads::model()->findAll($criteria);
	
	if(!empty($items) && is_array($items)){
		return count($items);
	}else{
		return 0;
	}
}*/

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
						<li '.(($level > 0) && ($j>=24)?'class="hidden-menu-item"':'').'>
							<a href="'. Jii::app()->createUrl('item/list',Item::urlOptions($v,$item['title'],false,true)/*,array('itemid'=>$v)*/).'">'.$item['title'].'</a>
							'.subcategories($v,$data,$level,false,$status).'
						</li>
					';
					if($j == 24){
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
		
		$childrens = Location::model()->getchildren(Jii::app()->user->location);
		$childrens[] = 0;
		$criteria->addCondition('ads_locationid in ('.implode(',',$childrens).','.Jii::app()->user->location.')');
		
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





