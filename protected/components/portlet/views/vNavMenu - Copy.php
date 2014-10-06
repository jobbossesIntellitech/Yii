<?php
$c = strtolower(Jii::app()->controller->id);
$a = strtolower(Jii::app()->controller->action->id);
$id = isset($_GET['id'])?$_GET['id']:'0';

function subcategories($parentid){
	$criteria = new CDbCriteria;
	$criteria->addCondition('itm_parentid = '.$parentid);
	$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getValue());
	$criteria->addCondition('itm_type = '.Item::type()->getItem('category')->getValue());
	$sub = Item::model()->findAll($criteria);
	if(!empty($sub) && is_array($sub)){
		echo '<ul>';
		foreach($sub as $s){
		?>
			<li>
				<a href="<?php echo Jii::app()->createUrl('item/list',array('itemid'=>$s->itm_id));?>"><?php echo $s->itm_name;?></a>
				<?php subcategories($s->itm_id);?>
			</li>
		<?php
		}
		echo '</ul>';
	}
}
?>
<div id="main-navigation">

<ul>

	<li>
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="javascript://"></a>
		<span class="titillium" id="motors">motors</span>
		<div></div>
		<?php subcategories(1);?>
	</li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="javascript://"></a>
		<span class="titillium" id="classifieds">classifieds</span>
		<div></div>
		<?php subcategories(2);?>
    </li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="javascript://"></a>
		<span class="titillium" id="properties">properties</span>
		<div></div>
		<?php subcategories(6);?>
	</li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="javascript://"></a>
		<span class="titillium" id="jobs">jobs</span>
		<div></div>
		<?php subcategories(10);?>
    </li>
    
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="javascript://"></a>
		<span class="titillium" id="community">community</span>
		<div></div>
		<?php subcategories(11);?>
    </li>
	
	<li class="sep">
        <a <?php echo (($c == 'cms' && $a == 'view' && $id == 100))?'class="selected"':''; ?> href="javascript://"></a>
		<span class="titillium" id="deals">deals</span>
		<div></div>
		<?php subcategories(12);?>
    </li>
</ul>
</div>