<?php
$this->widget('wBegin',array('headers'=>$headers));
if(isset($list) && is_array($list) && !empty($list)){
	for($i = count($list)-1; $i >= 0; $i--){
		$l = (object)$list[$i];
	?>
		<tr>
			<td><?php echo $l->id+1; ?></td>
            <td><?php echo $l->name; ?></td>
            <td><?php echo $l->size; ?></td>
            <td><?php echo $l->create_time; ?></td>
			<td>
                <?php
				$ob = new OptionButton();
					if(Jii::hasPermission('backup','download'))
					{
						$ob->put(Jii::t('Download'),Jii::app()->createUrl('backup/download',array('file'=>$l->name)));
					}
					if(Jii::hasPermission('backup','delete'))
					{
						$ob->put(Jii::t('Delete'),Jii::app()->createUrl('backup/delete',array('file'=>$l->name)),
													array('confirm'=>Jii::t('Are you Sure ?'),'class'=>'x'));
					}
				$ob->procced();
				?>
			</td>
		</tr>
	<?php
	}
}else{
	?>
	<tr><td colspan="5" class="notfound"><?php echo Jii::t("Empty List"); ?></td></tr>
	<?php	
}
$this->widget('wEnd',array('pages'=>$pages));
?>
<script type="text/javascript">
$(document).ready(function(e) {
	$('#gv tr.tab_header').next().remove();    
});
</script>