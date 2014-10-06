<?php
$this->widget('wGridView',array(								  
  'baseUrl'=>INDEX.'/ads/index',
  'parameters'=>'',
  'headers'=>array(
			
			array('label'=>Jii::t('ID'),'fieldOrder'=>'ads_id','filter'=>true,'type'=>'int'),
			array('label'=>Jii::t('Name'),'fieldOrder'=>'ads_name','filter'=>true),
			array('label'=>Jii::t('Item Category'),'fieldOrder'=>'ads_itemid','filter'=>true),
			//array('label'=>Jii::t('Type'),'fieldOrder'=>'itm_type','filter'=>true,'type'=>'list','data'=>Item::type()->getList()),
			array('label'=>Jii::t('Status'),'fieldOrder'=>'ads_status','filter'=>true,'type'=>'list','data'=>Ads::status()->getList()),
			array('label'=>
			Jii::t('Previews'),'fieldOrder'=>'','filter'=>false),
			
			),
  'pageSize'=>4,
  'orderBy'=>'ads_id',
  'orderPosition'=>'desc'
  
)); ?>