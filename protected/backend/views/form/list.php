<?php
$o = new JGridList($list,4);
while($l = $o->next()){
	$o->add( $l->form_id );
	$o->add( $l->form_title );
	
	$ob = new OptionButton();
	if( Form::status()->equal('draft',$l->form_status) ){
		$item = Form::status()->getItem('publish');
		$ob->put($item->getLabel(),Jii::app()->createUrl('form/status',array('id'=>$l->form_id,'status'=>$item->getValue())));	
	}else
	if( Form::status()->equal('publish',$l->form_status) ){
		$item = Form::status()->getItem('close');
		$ob->put($item->getLabel(),Jii::app()->createUrl('form/status',array('id'=>$l->form_id,'status'=>$item->getValue())));
	}
	if( !Form::status()->equal('delete',$l->form_status) ){
		$item = Form::status()->getItem('delete');
		$ob->put($item->getLabel(),Jii::app()->createUrl('form/status',array('id'=>$l->form_id,'status'=>$item->getValue())));
	}
	if( Form::status()->equal('delete',$l->form_status) ){
		$item = Form::status()->getItem('delete');
		$ob->put($item->getLabel().'d','javascript://');
	}
	if( Form::status()->equal('close',$l->form_status) ){
		$item = Form::status()->getItem('close');
		$ob->put($item->getLabel().'d','javascript://');
	}
	
	$o->add( $ob->procced(true),false );
	
	$ob = new OptionButton();
	if(Jii::hasPermission('form','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('form/edit',array('id'=>$l->form_id)));
	}
	if(Jii::hasPermission('form','manage') && Form::status()->equal('draft',$l->form_status))
	{
		$ob->put(Jii::t('Manage'),Jii::app()->createUrl('form/manage',array('id'=>$l->form_id)));
	}
	if(Jii::hasPermission('form','results') && !Form::status()->equal('draft',$l->form_status))
	{
		$ob->put(Jii::t('Results'),Jii::app()->createUrl('form/results',array('id'=>$l->form_id)));
	}
	if(Jii::hasPermission('form','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('form/delete',array('id'=>$l->form_id)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>