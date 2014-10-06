<?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/log/index',
  'parameters'=>'',
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'log_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Message'),'fieldOrder'=>'log_message','filter'=>true),
			array('label'=>Jii::t('Date'),'fieldOrder'=>'log_date','filter'=>true,'type'=>'date'),
			array('label'=>Jii::t('IP'),'fieldOrder'=>'log_ip','filter'=>true),
			array('label'=>Jii::t('Url'),'fieldOrder'=>'log_url','filter'=>true),
			array('label'=>Jii::t('Type'),'fieldOrder'=>'log_type','filter'=>true,'type'=>'list','data'=>Log::type()),
			
			),
  'pageSize'=>20,
  'orderBy'=>'log_date',
  'orderPosition'=>'desc'
  
)); ?>