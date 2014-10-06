<?php
$o = new JGridList($list,7);
while($l = $o->next()){
	$o->add( $l->com_id );
	$o->add( $l->com_parentid );
	$o->add( $l->com_title );
	$o->add( $l->com_text );
	$o->add( $l->com_name );
	$o->add( $l->com_email );
	$status = '';
	if(Jii::hasPermission('comment','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('comment/status',array('id'=>$l->com_id,'c1'=>$this->category,'c2'=>$this->content)),
												   'post', array('name'=>'statusform_'.$l->com_id));		
		$status .= CHtml::dropDownList('status',$l->com_status,Comment::status()->getList(),array('onchange'=>'document.statusform_'.$l->com_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Comment::status()->getLabelByValue($l->com_status);
	}
	$o->add( $status );
}
$o->display();
?>