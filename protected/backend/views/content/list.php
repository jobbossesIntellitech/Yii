<?php
$o = new JGridList($list,6);
while($l = $o->next()){
	$o->add( $l->con_id );
	$o->add( CHtml::link($l->con_slug,Jii::app()->createUrl('content/index',array('f'=>$l->con_id,'c'=>$this->category))) );
	$o->add( CHtml::link($l->content_lang->lng_title,Jii::app()->createUrl('content/index',array('f'=>$l->con_id,'c'=>$this->category))) );
	// status form
	$status = '';
	if(Jii::hasPermission('content','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('content/status',array('id'=>$l->con_id,'f'=>$this->family,'c'=>$this->category)),
												   'post', array('name'=>'statusform_'.$l->con_id));		
		$status .= CHtml::dropDownList('status',$l->con_status,Content::status()->getList(),array('onchange'=>'document.statusform_'.$l->con_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Content::status()->getLabelByValue($l->con_status);
	}
	$o->add( $status,false );
	// comment form
	$comment = '';
	if(Jii::hasPermission('content','hascomment')){
		$comment .= CHtml::beginForm(Jii::app()->createUrl('content/hascomment',array('id'=>$l->con_id,'f'=>$this->family,'c'=>$this->category)),
												   'post', array('name'=>'commentform_'.$l->con_id));		
		$comment .= CHtml::dropDownList('comment',$l->con_hascomments,Content::comment()->getList(),array('onchange'=>'document.commentform_'.$l->con_id.'.submit();'));
		$comment .= CHtml::endForm();
	}else{
		$comment .= Content::comment()->getLabelByValue($l->con_hascomments);
	}
	if(Content::comment()->equal('yes',$l->con_hascomments)){
		$comment .= '<br>'.count($l->comment).' '.Jii::t('comments');
	}
	$o->add( $comment,false );
	// actions
	$ob = new OptionButton();
	if(Jii::hasPermission('content','translate'))
	{
		$ob->put(Jii::t('Translate'),Jii::app()->createUrl('content/translate',array('id'=>$l->con_id,'f'=>$this->family,'c'=>$this->category)));
	}
	if(Jii::hasPermission('content','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('content/edit',array('id'=>$l->con_id,'f'=>$this->family,'c'=>$this->category)));
	}
	if(Jii::hasPermission('content','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('content/delete',array('id'=>$l->con_id,'f'=>$this->family,'c'=>$this->category)),array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>