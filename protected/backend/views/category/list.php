<?php
$o = new JGridList($list,5);
while($l = $o->next()){
	$o->add( $l->cat_id );
	$o->add( CHtml::link($l->cat_slug,Jii::app()->createUrl('category/index',array('f'=>$l->cat_id))) );
	$o->add( CHtml::link($l->category_lang->lng_name,Jii::app()->createUrl('category/index',array('f'=>$l->cat_id))) );
	// status form
	$status = '';
	if(Jii::hasPermission('category','status')){
		$status .= CHtml::beginForm(Jii::app()->createUrl('category/status',array('id'=>$l->cat_id,'f'=>$this->family)),
												   'post', array('name'=>'statusform_'.$l->cat_id));		
		$status .= CHtml::dropDownList('status',$l->cat_status,Category::status()->getList(),array('onchange'=>'document.statusform_'.$l->cat_id.'.submit();'));
		$status .= CHtml::endForm();
	}else{
		$status .= Category::status()->getLabelByValue($l->cat_status);
	}
	$o->add( $status,false );
	// actions
	$ob = new OptionButton();
	if(Jii::hasPermission('category','translate'))
	{
		$ob->put(Jii::t('Translate'),Jii::app()->createUrl('category/translate',array('id'=>$l->cat_id,'f'=>$this->family)));
	}
	if(Jii::hasPermission('category','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('category/edit',array('id'=>$l->cat_id,'f'=>$this->family)));
	}
	if(Jii::hasPermission('category','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('category/delete',array('id'=>$l->cat_id,'f'=>$this->family)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>