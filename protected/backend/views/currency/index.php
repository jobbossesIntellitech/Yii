<?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/currency/index',
  'parameters'=>'uws='.Jii::param('uws'),
  'headers'=>array(
			array('label'=>Jii::t('ID'),'fieldOrder'=>'cur_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'cur_name','filter'=>true),
			array('label'=>Jii::t('Sign'),'fieldOrder'=>'cur_sign','filter'=>true),
			array('label'=>Jii::t('Location'),'fieldOrder'=>'','filter'=>false),
			array('label'=>
			CHtml::link(Jii::t('Add'),urlencode(Jii::app()->createUrl('currency/add',array('uws'=>Jii::param('uws')))))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'cur_id',
  'orderPosition'=>'desc'
  
)); ?>