<?php
$bread = Location::breadcrumb($this->family);
if(!empty($bread)){
	$bloc = Layout::bloc($bread);
	echo $bloc;
}
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/location/index',
  'parameters'=>'f='.$this->family.'&uws='.Jii::param('uws'),
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'loc_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'loc_name','filter'=>true),
			array('label'=>Jii::t('Type'),'fieldOrder'=>'loc_type','filter'=>true,'type'=>'list','data'=>Location::type()->getList()),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'loc_status','filter'=>true,'type'=>'list','data'=>Location::status()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),urlencode(Jii::app()->createUrl('location/add',array('f'=>$this->family,'uws'=>Jii::param('uws')))))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'loc_id',
  'orderPosition'=>'desc'
  
)); ?>