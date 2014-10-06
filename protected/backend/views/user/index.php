<?php
$bread = User::breadcrumb($this->family);
$bloc = Layout::bloc($bread);
echo $bloc;
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/user/index',
  'parameters'=>'f='.$this->family,
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'usr_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Image'),'fieldOrder'=>'','filter'=>false),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'usr_firstname','filter'=>true),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'usr_status','filter'=>true,'type'=>'list','data'=>User::status()->getList()),
			array('label'=>Jii::t('Last'),'fieldOrder'=>'usr_lastlogin ','filter'=>true,'type'=>'date'),
			array('label'=>Jii::t('Color'),'fieldOrder'=>'','filter'=>false),
			array('label'=>
			CHtml::link(Jii::t('Add'),Jii::app()->createUrl('user/add',array('f'=>$this->family)))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'usr_id',
  'orderPosition'=>'asc'
  
)); ?>