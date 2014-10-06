<?php
$cs=Jii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/jldate/jldate.js');
$cs->registerCssFile(Yii::app()->baseUrl .'/assets/jldate/jldate.css');
?>
<div class="grid-view" id="<?php echo $this->ID; ?>"></div>


<script type="text/javascript">
$(document).ready(function(){

	$('#<?php echo $this->ID; ?>').gridView({
	
		baseUrl : '<?php echo Yii::app()->baseUrl; ?>/<?php echo $this->baseUrl; ?>',
		data : '<?php echo $this->parameters; ?>',
		header : new Array(
				<?php
				if(isset($this->headers) && is_array($this->headers) && !empty($this->headers)){
					$i = 0;
					foreach($this->headers AS $h){
						if($i == 0){ $sep = ''; }else{ $sep = ','; }
						
						$gv_filter_data = '';
						if(isset($h['data']) && is_array($h['data']) && !empty($h['data'])){
							$gv_filter_data = array();
							foreach($h['data'] AS $k => $v){
								$gv_filter_data[] = ' '.$k.' : "'.$v.'" ';
							}	
							$gv_filter_data = implode(',',$gv_filter_data);
							$gv_filter_data = '{'.$gv_filter_data.'}';
						}else{
							$gv_filter_data = 'null';
						}
						?>
						
						<?php echo $sep; ?>{
							label : '<?php echo $h['label']; ?>',
							ordering : '<?php echo (isset($h['fieldOrder']))?$h['fieldOrder']:''; ?>',
							filter : '<?php echo (isset($h['filter']))?$h['filter']:'false'; ?>',
							type : '<?php echo (isset($h['type']))?$h['type']:'text'; ?>',
							data : <?php echo $gv_filter_data; ?>
						}
				<?php
				
						$i++;
				
					}
				}
				?>
				),
		pageSize:<?php echo $this->pageSize; ?>,
		orderBy:'<?php echo $this->orderBy; ?>',
		orderPosition: '<?php echo $this->orderPosition; ?>'
	
	});

});
</script>