<?php
$bread = Item::breadcrumb($this->family);
if(!empty($bread)){
	$bloc = Layout::bloc($bread);
	echo $bloc;
}
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/item/index',
  'parameters'=>'f='.$this->family.'&uws='.Jii::param('uws'),
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'itm_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'itm_name','filter'=>true),
			//array('label'=>Jii::t('Type'),'fieldOrder'=>'itm_type','filter'=>true,'type'=>'list','data'=>Item::type()->getList()),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'itm_status','filter'=>true,'type'=>'list','data'=>Item::status()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),urlencode(Jii::app()->createUrl('item/add',array('f'=>$this->family,'uws'=>Jii::param('uws')))))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'itm_id',
  'orderPosition'=>'desc'
  
)); ?>