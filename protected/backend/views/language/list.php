<?php
$o = new JGridList($list,6);
while($l = $o->next()){
	$o->add( $l->lng_id );
	$o->add( $l->lng_iso );
	$o->add( $l->lng_name );
	$o->add( Language::direction()->getItem($l->lng_direction)->getLabel() );
	
	$status = '';
	if(Jii::hasPermission('language','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('language/status',array('id'=>$l->lng_id)),
												   'post', array('name'=>'statusform_'.$l->lng_id));		
		$status .= CHtml::dropDownList('status',$l->lng_status,Language::status()->getList(),array('onchange'=>'document.statusform_'.$l->lng_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Language::status()->getLabelByValue($l->lng_status);
	}
	$o->add( $status,false );
	
	$ob = new OptionButton();
	if(Jii::hasPermission('language','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('language/edit',array('id'=>$l->lng_id)));
	}
	if(Jii::hasPermission('language','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('language/delete',array('id'=>$l->lng_id)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>