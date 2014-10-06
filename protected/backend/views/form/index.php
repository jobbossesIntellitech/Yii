<?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/form/index',
  'parameters'=>'',
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'form_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Title'),'fieldOrder'=>'form_title','filter'=>true),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'form_status','filter'=>true,'type'=>'list','data'=>Form::status()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),urlencode(Jii::app()->createUrl('form/add'))),'fieldOrder'=>'','filter'=>false),
			),
  'pageSize'=>5,
  'orderBy'=>'form_id',
  'orderPosition'=>'desc'
  
));
?>