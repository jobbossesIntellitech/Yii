<?php
$o = new JGridList($list,4);
while($l = $o->next()){
if($l->ads_status == Ads::status()->getItem('enable')->getValue() || $l->ads_status == Ads::status()->getItem('pending')->getValue()){
	$o->add( $l->ads_id );
	$o->add( $l->ads_name);
	$category = Item::model()->findByPk($l->ads_itemid);
	$o->add( $category->itm_name);
	// status form
	$status = '';
	if(Jii::hasPermission('ads','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('ads/status',array('id'=>$l->ads_id)),
												   'post', array('name'=>'statusform_'.$l->ads_id));		
		$status .= CHtml::dropDownList('status',$l->ads_status,Ads::status()->getList(),array('onchange'=>'document.statusform_'.$l->ads_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Ads::status()->getLabelByValue($l->ads_status);
	}
	$o->add( $status,false );
	// actions
	$ob = new OptionButton();
	if(Jii::hasPermission('ads','preview'))
	{
		$ob->put(Jii::t('Preview'),Jii::app()->createUrl('ads/preview',array('id'=>$l->ads_id)));
		$ob->put(Jii::t('Share on Facebook'),Jii::app()->createUrl('ads/facebookposting',array('id'=>$l->ads_id)));
	}
	if(Jii::hasPermission('ads','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('ads/delete',array('id'=>$l->ads_id)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
}
$o->display();
?>
<style type="text/css">
.option-button li{float:none;}
</style>