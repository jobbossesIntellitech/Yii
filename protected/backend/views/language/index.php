<?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/language/index',
  'parameters'=>'',
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'lng_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Iso'),'fieldOrder'=>'lng_iso','filter'=>true),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'lng_name','filter'=>true),
			array('label'=>Jii::t('Direction'),'fieldOrder'=>'lng_direction ','filter'=>true,'type'=>'list','data'=>Language::direction()->getList()),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'lng_status','filter'=>true,'type'=>'list','data'=>Language::status()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),Jii::app()->createUrl('language/add'))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'lng_id',
  'orderPosition'=>'asc'
)); ?>