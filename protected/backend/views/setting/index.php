 <?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/setting/index',
  'parameters'=>'',
  'headers'=>array(
			array('label'=>Jii::t('ID'),'fieldOrder'=>'set_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Key'),'fieldOrder'=>'set_key','filter'=>true),
			array('label'=>Jii::t('Value'),'fieldOrder'=>'set_value','filter'=>true),
			array('label'=>Jii::t('Section'),'fieldOrder'=>'set_section','filter'=>true,'type'=>'list','data'=>Setting::section()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),Jii::app()->createUrl('setting/add'))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'set_id',
  'orderPosition'=>'asc'
)); ?>