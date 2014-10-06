<div class="controller-table">
<?php
$exceptional = array('log','dashboard','profile');
if(!empty($controllers) && is_array($controllers)){
	?>
    <form method="post" action="<?php echo Jii::app()->createUrl('user/permission',array('f'=>$this->family,'id'=>Jii::param('id'))); ?>">
    	<div class="button">
            <input type="submit" value="<?php echo Jii::t('Save'); ?>" name="save"/>
        </div>
		<?php
        foreach($controllers AS $controller){
            ?>
            <div class="outer-bloc-controller">
                <div class="inner-bloc-controller">
                    <h3 class="controller-title">
                        <?php
                        if(!in_array(strtolower($controller->controller_name),$exceptional)){
                            ?>
                            <input  type="checkbox" name="selectall[<?php echo $controller->controller_id; ?>]"
                                    value = "<?php echo Jii::param('id'); ?>"
                                    id="selectall_<?php echo $controller->controller_id; ?>"
                                    class="selectall" />
                            <?php	
                        }
                        echo '
                            <label for="selectall_'.$controller->controller_id.'">
                            '.$controller->controller_name.'
                            </label>'; 
                        ?>
                    </h3>
                    <ul>
                    <?php
                    if(isset($controller->actiontable) && !empty($controller->actiontable) && is_array($controller->actiontable)){
                        foreach($controller->actiontable AS $action){
                            ?>
                            <li>
                                <?php
                                if(in_array(strtolower($controller->controller_name),$exceptional)){
                                    ?>
                                    <input  type="hidden" name="permission[<?php echo $controller->controller_id; ?>][<?php echo $action->action_id; ?>]"
                                            value = "<?php echo Jii::param('id'); ?>"
                                            id="permission_<?php echo $controller->controller_id; ?>_<?php echo $action->action_id; ?>" />
                                    <?php
                                }else{
									$checked = (isset($permission[$action->action_id]))?'checked="checked"':'';
                                    ?>
                                    <input  type="checkbox" name="permission[<?php echo $controller->controller_id; ?>][<?php echo $action->action_id; ?>]"
                                            value = "<?php echo Jii::param('id'); ?>" 
                                            id="permission_<?php echo $controller->controller_id; ?>_<?php echo $action->action_id; ?>"
                                            rel = "selectall_<?php echo $controller->controller_id; ?>"
                                            <?php echo $checked; ?> />
                                    <?php	
                                }
                                ?>
                                <?php 
                                    echo '
                                    <label for="permission_'.$controller->controller_id.'_'.$action->action_id.'">
                                    '.$action->action_name.'
                                    </label>'; 
                                ?>
                            </li>
                            <?php	
                        }	
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="clr"></div>
    </form>
    <?php	
}else{
	echo '<div class="notfound">'.Jii::t('Controllers not synchronized').'</div>';		
}
?>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.selectall').each(function(i, e) {
    	$(e).click(function() {
            if($(this).is(':checked')){
				$('input[rel='+$(this).attr('id')+']').attr('checked','checked');	
			}else{
				$('input[rel='+$(this).attr('id')+']').removeAttr('checked');	
			}
        });    
    });
});
</script>