<?php
$o = new JGridList($list,5);
while($l = $o->next()){
	$o->add( $l->cur_id );
	$o->add( $l->cur_name );
	$o->add( $l->cur_sign );
	$countries = Location::getCountry();
	$allowed = explode(',',$l->cur_locations);
	$locations = array_intersect_key($countries, array_flip($allowed));
	$o->add( implode(', ',$locations) );
	// actions
	$ob = new OptionButton();
	if(Jii::hasPermission('currency','edit'))
	{
		$ob->put(Jii::t('Edit'),Jii::app()->createUrl('currency/edit',array('id'=>$l->cur_id,'uws'=>Jii::param('uws'))));
	}
	if(Jii::hasPermission('currency','delete'))
	{
		$ob->put(Jii::t('Delete'),Jii::app()->createUrl('currency/delete',array('id'=>$l->cur_id,'uws'=>Jii::param('uws'))),
		array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
	}
	$o->add( $ob->procced(true),false );
}
$o->display();
?>