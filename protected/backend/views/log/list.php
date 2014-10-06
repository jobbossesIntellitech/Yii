<?php
$o = new JGridList($list,6);
while($l = $o->next()){
	$o->add( $l->log_id );
	$o->add( $l->log_message );
	$o->add( date('l d F Y H:i',strtotime($l->log_date)) );
	$o->add( $l->log_ip );
	$o->add( $l->log_url );
	$o->add( Log::type($l->log_type) );
}
$o->display();
?>