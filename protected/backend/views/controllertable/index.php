<?php
$list = array();
if(isset($actions) && is_array($actions) && !empty($actions)){
	$path = Yii::app()->basePath.'/controllers/';
	foreach($actions AS $a){
		$classname = ucfirst($a->controllertable->controller_name).'Controller';
		if(!isset($list[$a->controllertable->controller_id])){
			$list[$a->controllertable->controller_id] = array();
			$list[$a->controllertable->controller_id]['name'] = $a->controllertable->controller_name;
			$list[$a->controllertable->controller_id]['exist'] = is_file($path.$classname.'.php');
			$list[$a->controllertable->controller_id]['actions'] = array();
			if($list[$a->controllertable->controller_id]['exist']){
				try{
					if($classname == 'ControllertableController'){
						$class = $this;		
					}else{
						include($path.$classname.'.php');
						$class = eval("return new $classname(".time().");");
					}
				}catch(Exception $e){}		
			}	
		}
		$list[$a->controllertable->controller_id]['actions'][$a->action_id] = array();
		$list[$a->controllertable->controller_id]['actions'][$a->action_id]['name'] = $a->action_name;
		$list[$a->controllertable->controller_id]['actions'][$a->action_id]['exist'] = (isset($class) && method_exists($class,'action'.ucfirst($a->action_name)));			
	}
}
if(Jii::hasPermission('controllertable','synchronize')){
	?>
    <div class="btn">
        <a href="<?php echo Jii::app()->createUrl('controllertable/synchronize'); ?>"><?php echo Jii::t('Synchronize'); ?></a>
    </div>
	<?php
}
?>
<div class="controller-table">
<?php
if(isset($list) && is_array($list) && !empty($list)){
	foreach($list AS $k=>$c){
		?>
        <div class="outer-bloc-controller">
        	<div class="inner-bloc-controller">
            	<h3 class="controller-title">
					<?php 
					echo $c['name'];
					if(!$c['exist'] && Jii::hasPermission('controllertable','removecontroller')){ 
						?>
                		<a href="<?php echo Jii::app()->createUrl('controllertable/removecontroller',array('id'=>$k)); ?>" class="remove">
							<?php echo Jii::t('X'); ?>
                        </a>
                    	<?php
					}
					?>
                </h3>
				<?php
				if(isset($c['actions']) && is_array($c['actions']) && !empty($c['actions'])){
				?>
                <ul>
                <?php
				foreach($c['actions'] AS $kk=>$a){
					?>
                    <li>
                    	<?php
							echo $a['name'];
							if($c['exist'] && !$a['exist'] && Jii::hasPermission('controllertable','removeaction')){
								?>
                                <a href="<?php echo Jii::app()->createUrl('controllertable/removeaction',array('id'=>$kk)); ?>" class="remove">
									<?php echo Jii::t('X'); ?>
                                </a>
                                <?php	
							}
						?>
                    </li>
                    <?php	
				}
				?>	
                </ul>
                <?php
				}
				?>
            </div>
        </div>
        <?php	
	}	
}
?>
</div>