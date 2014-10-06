<?php
$o = new JGridList($list,4);
while($l = $o->next()){
	$o->add( $l->itm_id );
	$o->add( CHtml::link($l->itm_name,Jii::app()->createUrl('item/index',array('f'=>$l->itm_id))) );
	// status form
	$status = '';
	if(Jii::hasPermission('item','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('item/status',array('id'=>$l->itm_id,'f'=>$this->family,'uws'=>Jii::param('uws'))),
												   'post', array('name'=>'statusform_'.$l->itm_id));		
		$status .= CHtml::dropDownList('status',$l->itm_status,Location::status()->getList(),array('onchange'=>'document.statusform_'.$l->itm_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Location::status()->getLabelByValue($l->itm_status);
	}
	$o->add( $status,false );
	// actions
	$ob = new OptionButton();
	if(Jii::hasPermission('item','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('item/edit',array('id'=>$l->itm_id,'f'=>$this->family,'uws'=>Jii::param('uws'))));
	}
	if(Jii::hasPermission('item','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('item/delete',array('id'=>$l->itm_id,'f'=>$this->family,'uws'=>Jii::param('uws'))),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>