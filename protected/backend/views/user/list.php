<?php
$o = new JGridList($list,7);
while($l = $o->next()){
	$o->add( $l->usr_id );
	
	$img = '<img 
            	src="'.Jii::app()->baseUrl.$l->usr_image.'"
            	onError = "'.Jii::app()->baseUrl.Jii::notfound().'"
                style="width:100px;"
            /> ';
	$o->add( $img,false );
	
	$o->add( CHtml::link($l->usr_firstname.' '.$l->usr_lastname,Jii::app()->createUrl('user/index',array('f'=>$l->usr_id))) );
	
	$status = '';
	if(Jii::hasPermission('user','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('user/status',array('id'=>$l->usr_id,'f'=>$l->usr_parent)),
												   'post', array('name'=>'statusform_'.$l->usr_id));		
		$status .= CHtml::dropDownList('status',$l->usr_status,User::status()->getList(),array('onchange'=>'document.statusform_'.$l->usr_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= User::status()->getLabelByValue($l->usr_status);
	}
	$o->add( $status );
	
	$o->add( date('l d F Y H:i',strtotime($l->usr_lastlogin)) );
	
	$o->add( '<div style="background:#'.$l->usr_color.'; width:50px; height:50px; position:relative; margin:0 auto;">&nbsp;</div>',false );
	
	$ob = new OptionButton();
	if(Jii::hasPermission('user','permission'))
	{
		$ob->put(Jii::t('Permission'),Jii::app()->createUrl('user/permission',array('id'=>$l->usr_id,'f'=>$this->family)));
	}
	if(Jii::hasPermission('user','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('user/edit',array('id'=>$l->usr_id,'f'=>$this->family)));
	}
	if(Jii::hasPermission('user','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('user/delete',array('id'=>$l->usr_id,'f'=>$this->family)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>