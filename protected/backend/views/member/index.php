<?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/member/index',
  'parameters'=>'',
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'mbr_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Image'),'fieldOrder'=>'','filter'=>false),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'mbr_firstname','filter'=>true),
			array('label'=>Jii::t('Email'),'fieldOrder'=>'mbr_email ','filter'=>true),
			array('label'=>Jii::t('Phone'),'fieldOrder'=>'mbr_phone','filter'=>false),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'mbr_status','filter'=>true,'type'=>'list','data'=>Member::status()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),Jii::app()->createUrl('member/add',array()))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'mbr_id',
  'orderPosition'=>'asc'
  
)); ?>