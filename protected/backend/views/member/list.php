<?php
$o = new JGridList($list,7);
while($l = $o->next()){
	$o->add( $l->mbr_id );
	
	$img = '<img width="100" height="100" src="'.Jii::app()->baseUrl.'/assets/uploads/members/'.$l->mbr_image.'"/>';
	$o->add( $img );
	
	$o->add( $l->mbr_firstname.' '.$l->mbr_lastname);
		
	$o->add( $l->mbr_email);
	
	$o->add( $l->mbr_phone);
	
	$status = '';
	if(Jii::hasPermission('member','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('member/status',array('id'=>$l->mbr_id)),
												   'post', array('name'=>'statusform_'.$l->mbr_id));		
		$status .= CHtml::dropDownList('status',$l->mbr_status,Member::status()->getList(),array('onchange'=>'document.statusform_'.$l->mbr_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Member::status()->getLabelByValue($l->mbr_status);
	}
	$o->add( $status );
	
	
	
	$ob = new OptionButton();
	if(Jii::hasPermission('member','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('member/edit',array('id'=>$l->mbr_id)));
	}
	if(Jii::hasPermission('member','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('member/delete',array('id'=>$l->mbr_id)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>