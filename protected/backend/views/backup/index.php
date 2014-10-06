<?php
$this->widget('wGridView',array(									  
	'baseUrl'=>INDEX.'/backup/index',
	'parameters'=>'',
	'headers'=>array(
			array('label'=>Jii::t('ID'),'fieldOrder'=>'','filter'=>false),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'','filter'=>false),
			array('label'=>Jii::t('Size'),'fieldOrder'=>'','filter'=>false),
			array('label'=>Jii::t('Creation Date'),'fieldOrder'=>'','filter'=>false),
			array('label'=>CHtml::link(Jii::t('Add'),Jii::app()->createUrl('backup/create')),'fieldOrder'=>'','filter'=>false),
			),
	'orderBy'=>'',
	'orderPosition'=>'',
	'pageSize'=> 5,
));
?>
