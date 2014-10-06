<div class="form-gen-res">
<a href="javascript://" id="expCol" data-to="1"><?php echo Jii::t('Open All'); ?></a>
<?php
if(isset($list) && is_array($list) && !empty($list)){
	?>
	<ul>
	<?php
	foreach($list AS $save){
		?>
		<li>
			<h3 class="title">
			<?php 
				$id = $save->save_requestkey;
				list($ip,$request) = explode('_',$save->save_requestkey);
				echo Jii::t('Request').' <span class="b">#'.$request.'</span> '.Jii::t('from the ip').' <span class="b">'.$ip.'</span> '.Jii::t('on').' ';
				echo '<span class="b">'.date('l d F Y \@ H:i',strtotime($save->dates->dat_creation)).'</span>';
			?>
			</h3>
			<div class="response">
			<?php
			if(isset($data[$id]) && is_array($data[$id]) && !empty($data[$id])){
				?>
				<table>
				<?php
				foreach($data[$id] AS $request){
					?>
					<tr>
						<th><?php echo $request['label']; ?></th>
						<td><?php echo $request['value']; ?></td>
					</tr>
					<?php
				}
				?>
				</table>
				<?php
			}
			?>	
			</div>
		</li>
		<?php
	}
	?>
	</ul>
	<?php
}else{
	echo '<div class="notfound">'.Jii::t('Results list is empty').'</div>';
}
?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.form-gen-res li').each(function(i,e){
		$(e).find('.response').hide();
		$(e).find('h3.title').click(function(){
			if( $(e).find('.response').is(':hidden') ){
				$('.form-gen-res li .response:visible').slideUp(500);
				$(e).find('.response').slideDown(500);
			}else{
				$(e).find('.response').slideUp(500);
			}
		});
	});
	$('#expCol').click(function(){
		if($(this).attr('data-to') == '0'){ // close all
			$(this).attr('data-to','1');
			$('.form-gen-res li .response').slideUp(500);
			$(this).text('<?php echo Jii::t('Open All'); ?>');
		}else{ // open all
			$(this).attr('data-to','0');
			$('.form-gen-res li .response').slideDown(500);
			$(this).text('<?php echo Jii::t('Close All'); ?>');
		}
	});
});
</script>