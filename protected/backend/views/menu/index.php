<?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/menu/index',
  'parameters'=>'',
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'menu_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'menu_name','filter'=>true),
			array('label'=>Jii::t('Hook'),'fieldOrder'=>'menu_hook','filter'=>true),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'menu_status','filter'=>true,'type'=>'list','data'=>Menu::status()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),urlencode(Jii::app()->createUrl('menu/add'))),'fieldOrder'=>'','filter'=>false),
			),
  'pageSize'=>5,
  'orderBy'=>'menu_id',
  'orderPosition'=>'desc'
  
));
?>