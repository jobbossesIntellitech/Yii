<?php
$bread = Category::breadcrumb($this->family);
if(!empty($bread)){
	$bloc = Layout::bloc($bread);
	echo $bloc;
}
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/category/index',
  'parameters'=>'f='.$this->family,
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'cat_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Slug'),'fieldOrder'=>'cat_slug','filter'=>true),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'lng_name','filter'=>true),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'cat_status','filter'=>true,'type'=>'list','data'=>Category::status()->getList()),
			array('label'=>
			CHtml::link(Jii::t('Add'),urlencode(Jii::app()->createUrl('category/add',array('f'=>$this->family))))
			,'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>5,
  'orderBy'=>'cat_id',
  'orderPosition'=>'desc'
  
)); ?>