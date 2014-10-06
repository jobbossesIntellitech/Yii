<?php
if(isset($list) && is_array($list) && !empty($list)){
	foreach($list AS $extend=>$rows){
		$header = array(Jii::t('ID'),Jii::t('Name'),Jii::t('Created'),Jii::t('Last Updated'));
		ob_start();
		foreach($rows AS $row){
			$last = '';
			if(isset($row['update'])&& is_array($row['update']) && !empty($row['update'])){
				$last = date('l d F Y H:i',strtotime($row['update'][count($row['update'])-1]));	
			}
			echo '
				<tr>
					<td><div class="wordwrap">'.$row['id'].'</div></td>
					<td><div class="wordwrap">'.$row['name'].'</div></td>
					<td><div class="wordwrap">'.date('l d F Y H:i',strtotime($row['create'])).'</div></td>
					<td><div class="wordwrap">'.$last.'</div></td>
				</tr>
			';
		}
		$data = ob_get_clean();
		$this->dashboard->add(Dashboard::COLUMN_1,$extend,Jii::t($extend.' Dates'),$data,$header);
	}
}
?>