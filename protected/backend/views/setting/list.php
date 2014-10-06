<?php
$o = new JGridList($list,5);
while($l = $o->next()){
	$o->add( $l->set_id );
	$o->add( $l->set_key );
	$o->add( $l->set_value );
	$o->add( $l->set_section );
	
	$ob = new OptionButton();
	if(Jii::hasPermission('setting','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('setting/edit',array('id'=>$l->set_id)));
	}
	if(Jii::hasPermission('setting','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('setting/delete',array('id'=>$l->set_id)),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>