<?php
$criteria = new CDbCriteria;
$criteria->addCondition('save_fieldid = '.$fld_id);
$criteria->addCondition('save_requestkey like "'.$_SERVER['REMOTE_ADDR'].'%"');
$save = FormSave::model()->find($criteria);
$permission = !isset($save->save_id);
?>
<tr>
	<td colspan="2">
		<div id="poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>" class="poll">
			<h1><?php echo $field['label']; ?></h1>
			<?php if($permission){ ?>
			<div class="vote">
				<ul class="radio-list">
				<?php
			}	
				$list = explode('|-|',$field['options']);
				$label = array();
				if(!empty($list) && is_array($list)){
					foreach($list AS $k=>$l){
						if(!empty($l)){
							$l = explode(':=:',$l);
							if($permission){
								$selected = ($l[0] == $field['defaultvalue'])?'selected="selected"':'';
								?>
								<li>
								<input type="radio" 
								name="field[<?php echo $fld_id; ?>]" 
								id="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>_<?php echo $k; ?>" 
								value="<?php echo $l[0]; ?>" <?php echo $selected; ?> class="validate" />
								<label for="field_<?php echo $sec_id; ?>_<?php echo $fld_id; ?>_<?php echo $k; ?>"><?php echo $l[1]; ?></label>
								</li>
								<?php
							}
							$label[$l[0]] = $l[1]; 
						}
					}
				}
			if($permission){?>
				</ul>
				<a href="javascript://" class="view-result"><?php echo Jii::t('Show result'); ?></a>
			</div>
			<?php } ?>
			<div class="result">
				<?php
				$criteria = new CDbCriteria;
				$criteria->addCondition('save_fieldid = '.$fld_id);
				$res = FormSave::model()->findAll($criteria);
				if(!empty($res) && is_array($res)){
					$list = array();
					$total = 0;
					foreach($res AS $k=>$v){
						if(!isset($list[$v->save_value])){ $list[$v->save_value] = array('label'=>$label[$v->save_value],'count'=>0); }	
						$list[$v->save_value]['count']++;
						$total++;
					}
					if(!empty($list) && is_array($list)){
						?>
						<table>
						<?php
						foreach($list AS $l){
							?>
							<tr>
								<th><?php echo $l['label']; ?></th>
								<td colspan="2">
									<div class="outer-vote">
										<div class="votes" data-per="<?php echo round( $l['count']*100/$total ); ?>">
											<?php echo $l['count'].' '.Jii::t('Votes').' ~'.round( $l['count']*100/$total ).'%'; ?>
										</div>
									</div>
								</td>
							</tr>
							<?php	
						}
						?>
						</table>
						<?php
					}
				}else{
					echo '<div class="notfound">'.$field['label'].' '.Jii::t('result empty').'</div>';
				}
				?>
				<?php if($permission){ ?>
					<a href="javascript://" class="view-poll"><?php echo Jii::t('Back to vote'); ?></a>
				<?php } ?>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			var w = 0,ww = 0;
			var per = 0;
			$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .view-result').click(function(){
				$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .vote').hide();
				$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .result').show();
			});
			$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .view-poll').click(function(){
				$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .vote').show();
				$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .result').hide();
			});
			$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .result tr').each(function(i,e){
				per = parseInt($(e).find('.votes').attr('data-per'));
				$(e).find('.votes').css('width',per+'%');
			});
			<?php if($permission){ ?>
				$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .vote').show();
				$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .result').hide();	
			<?php }else{ ?>	
				$('#poll_<?php echo $sec_id; ?>_<?php echo $fld_id; ?> .result').show();
			<?php } ?>
		});
		</script>
	</td>
</tr>