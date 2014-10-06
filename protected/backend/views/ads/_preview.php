<?php
$location = Location::model()->findByPk($model->locationid);
$member = Member::model()->findByPk($model->memberid);
$item = Item::model()->findByPk($model->itemid);
$image = explode(',',$model->gallery);
$count_images = count($image);
$img = '';

if(!empty($image) && isset($image) && is_array($image)){
//$image = array_reverse($image);
	foreach($image as $g){
		$img .= '<img width="100" height="100" style="margin-left:10px;" src="'.Jii::app()->baseUrl.'/assets/uploads/ads/'.$model->id.'/'.$g.'">';
	}
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
		$h->text('name'),
		$h->text('reference'),
		$img,
	));

echo $h->section(Jii::t('Extras'),array(
		$h->text('locationid',array('value'=>$location->loc_name)),
		$h->text('memberid',array('value'=>$member->mbr_firstname)),
		$h->text('itemid',array('value'=>$item->itm_name)),
	));

//$img = '<img src="'.Jii::app()->baseUrl.'/assets/uploads/ads/'.$model->id.'/'.$image[0].'"';

echo $h->submit(Jii::t('Back'));

$h->end();
?>

<script type="text/javascript">
$(document).ready(function(){
	$(':reset').remove();
	$('label span.required').html('');
	$('.errorMessage').remove();
});
</script>