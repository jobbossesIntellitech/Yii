<?php
$o = new JGridList($list,5);
while($l = $o->next()){
	$o->add( $l->menu_id );
	$o->add( $l->menu_name );
	$o->add( $l->menu_hook );
	
	$status = '';
	if(Jii::hasPermission('menu','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('menu/status',array('id'=>$l->menu_id,'hook'=>$l->menu_hook)),
												   'post', array('name'=>'statusform_'.$l->menu_id));		
		$status .= CHtml::dropDownList('status',$l->menu_status,Menu::status()->getList(),array('onchange'=>'document.statusform_'.$l->menu_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Menu::status()->getLabelByValue($l->menu_status);
	}
	$o->add( $status,false );
	
	$ob = new OptionButton();
	if(Jii::hasPermission('menu','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('menu/edit',array('id'=>$l->menu_id)));
	}
	if(Jii::hasPermission('menu','manage'))
	{
		$ob->put(Jii::t('Manage'),Jii::app()->createUrl('menu/manage',array('id'=>$l->menu_id)));
	}
	if(Jii::hasPermission('menu','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('menu/delete',array('id'=>$l->menu_id)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>