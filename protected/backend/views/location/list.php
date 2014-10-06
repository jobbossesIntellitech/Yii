<?php
$o = new JGridList($list,5);
while($l = $o->next()){
	$o->add( $l->loc_id );
	$o->add( CHtml::link($l->loc_name,Jii::app()->createUrl('location/index',array('f'=>$l->loc_id))) );
	$o->add( $l->loc_type);
	// status form
	$status = '';
	if(Jii::hasPermission('location','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('location/status',array('id'=>$l->loc_id,'f'=>$this->family,'uws'=>Jii::param('uws'))),
												   'post', array('name'=>'statusform_'.$l->loc_id));		
		$status .= CHtml::dropDownList('status',$l->loc_status,Location::status()->getList(),array('onchange'=>'document.statusform_'.$l->loc_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Location::status()->getLabelByValue($l->loc_status);
	}
	$o->add( $status,false );
	// actions
	$ob = new OptionButton();
	if(Jii::hasPermission('location','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('location/edit',array('id'=>$l->loc_id,'f'=>$this->family,'uws'=>Jii::param('uws'))));
	}
	if(Jii::hasPermission('location','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('location/delete',array('id'=>$l->loc_id,'f'=>$this->family,'uws'=>Jii::param('uws'))),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>