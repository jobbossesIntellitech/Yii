<?php
if(isset($list) && is_array($list) && !empty($list)){
	$header = array(Jii::t('ID'),Jii::t('Message'),Jii::t('Date'),Jii::t('Type'));
	ob_start();	
	foreach($list AS $l){
		echo '
			<tr>
				<td><div class="wordwrap">'.$l->log_id.'</div></td>
				<td><div class="wordwrap">'.$l->log_message.'</div></td>
				<td><div class="wordwrap">'.date('l d F Y H:i',strtotime($l->log_date)).'</div></td>
				<td><div class="wordwrap">'.Log::type($l->log_type).'</div></td>
			</tr>
		';	
	}
	$data = ob_get_clean();
	$this->dashboard->add(Dashboard::COLUMN_2,'latestLog',Jii::t('Latest Logs'),$data,$header);	
}
?>