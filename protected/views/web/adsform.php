<?php

if(isset($item->itm_formid) && $item->itm_formid != 0 && !isset($ads_id)){
echo JShortCode::filter('[form id='.$item->itm_formid.' itemid='.$item->itm_id.' type="ads"  /]');
}else if(isset($item->itm_formid) && $item->itm_formid != 0 && isset($ads_id)){
	echo JShortCode::filter('[form id='.$item->itm_formid.' itemid='.$item->itm_id.' type="edit_ads"  /]');
}else{
	echo 'Form is not available!!!';
}

?>
