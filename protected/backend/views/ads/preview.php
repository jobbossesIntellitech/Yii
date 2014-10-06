<?php
$name = '';
$image = explode(',',$model->gallery);
$count_images = count($image);
$img = '';
$description = '';
$date = '';
$price = '';
$location = '';
$category = '';

$name = '<br><span style="font-weight:bold;">Name of Ad: </span>'.$ads->ads_name.'<br>';

if(!empty($image) && isset($image) && is_array($image)){
//$image = array_reverse($image);
	$img .= '<br><br>';
	foreach($image as $g){
		if($g != ''){
			$img .= '<img width="100" height="100" style="margin-left:10px; float:left;" src="'.Jii::app()->baseUrl.'/assets/uploads/ads/'.$model->id.'/'.$g.'">';
		}
	}
	$img .= '<div class="clear"></div><br><br>';
}

$description .= '<br><span style="font-weight:bold;">Reference: </span>'.$ads->ads_reference.'<br>';
$description .= '<span style="font-weight:bold;">Description: </span>'.$ads->ads_description.'<br>';

$desc = get_description($ads->ads_saverequestkey);
if(isset($desc) && !empty($desc) && is_array($desc)){
	foreach($desc as $d){
		$label = FormField::model()->findByPk($d->save_fieldid);
		if(!empty($label)) $description .= '<span style="font-weight:bold;">'.$label->fld_label.': </span>';
	
		if(is_array(json_decode($d->save_value))){
			foreach(json_decode($d->save_value) as $val){
				$description .= $val.', <br>';
			}
		}else{
			$description .= $d->save_value.'<br>';
		}
	}
}

$date .= '<span style="font-weight:bold;">Date: </span>'.date('d F, Y',strtotime($ads->dates->dat_creation)).'<br>';

$cur = Currency::model()->findByPk($ads->ads_currencyid );
if(isset($cur)){
	$cur = $cur->cur_sign;
}else{
$cur ='';
} 
$price .= '<span style="font-weight:bold;">Price: </span>'.number_format($ads->ads_price).' '.$cur.'<br>';

$location = '<br><span style="font-weight:bold;">Location: </span>'.Location::breadcrumblocation($ads->ads_locationid,true,$ads->ads_map);
$category = '<br><span style="font-weight:bold;">Category: </span>'.Item::breadcrumbitem($ads->ads_itemid);

$member_name = '';
$member_image = '';
$member = Member::model()->findByPk($ads->ads_memberid);
if(!empty($member)){
	$member_name = '<br><span style="font-weight:bold;">Member Name: </span>'.$member->mbr_firstname.' '.$member->mbr_lastname;
	if(!empty($member->mbr_image)) $member_image = '<br><img width="100" height="100" src="'.Jii::app()->baseUrl.'/assets/uploads/members/'.$member->mbr_image.'"/>';
}

	
$h = new Html($model,$this,array(
	'id'=>'ads-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('ads/preview'),
	'htmlOptions'=>array(),
));

$h->begin();
echo $h->hidden('id');
echo $h->section(Jii::t('Principal'),array(
		$name,
		$price,
		$date,
		$img,
		$location,
		$category,
		//$h->dropDownList('status',Ads::status()->getList()),
));
	
echo $h->section(Jii::t('Status'),array(
	$h->dropDownList('status',Ads::status()->getList()),
));
echo '<div class="clear"></div>';
echo $h->section(Jii::t('Description'),array(
	$description,
));

echo $h->section(Jii::t('Member'),array(
	$member_name,
	$member_image,
));
	

//$img = '<img src="'.Jii::app()->baseUrl.'/assets/uploads/ads/'.$model->id.'/'.$image[0].'"';

echo $h->submit(Jii::t('Submit'));

$h->end();
?>

<script type="text/javascript">
$(document).ready(function(){
	$(':reset').remove();
	$('label span.required').html('');
	$('.errorMessage').remove();
});
</script>


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