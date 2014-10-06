<?php 
if(!empty($list) && is_array($list)){
	$left = (Jii::app()->user->direction == 'ltr')?'left':'right';
	$color = '#'.Jii::app()->user->color;
	$header = array(Jii::t('Image'),Jii::t('ID'),Jii::t('Name'),Jii::t('Status'),Jii::t('Last Visit'));
	ob_start();
	foreach($list As $l){
		echo '
			<tr>
				<td>
					<span style="padding-'.$left.':'.($l['indent']*14).'px; ">
					<img src="'.Jii::app()->baseUrl.$l['image'].'" style="width:32px; height:32px;
					border-'.$left.':2px solid '.$color.'; padding-'.$left.': 5px;" />
					</span>
				</td>
				<td><div class="wordwrap">'.$l['id'].'</div></td>
				<td><div class="wordwrap">'.$l['name'].'</div></td>
				<td><div class="wordwrap">'.$l['status'].'</div></td>
				<td><div class="wordwrap">'.$l['lastvisit'].'</div></td>
			</tr>
		';	
	}
	$data = ob_get_clean();
	$this->dashboard->add(Dashboard::COLUMN_1,'treeAdminUsers',Jii::t('Users'),$data,$header);
}
?>