<?php
$form = '';
$form .= CHtml::beginForm(Jii::app()->createUrl('content/index'),'GET',
array('name'=>'form'));
	$form .= '<table border="0"><tr>';
	$form .= '<td>';
		$form .= CHtml::dropDownList('c',$this->category,$this->categories,array('onchange'=>'document.form.submit();'));
	$form .= '</td>';
	$bread = Content::breadcrumb($this->family,$this->category);
	if(!empty($bread)){
		$form .= '<td>'.$bread.'</td>';
	}
	$form .= '</tr></table>';
$form .= CHtml::endForm();
$option = Layout::bloc($form);
echo $option;
/* -- .................................................................................... -- */
if($this->category > 0){
	$this->widget('wGridView',array(								  
	  'baseUrl'=>INDEX.'/content/index',
	  'parameters'=>'f='.$this->family.'&c='.$this->category,
	  'headers'=>array(
				
				array('label'=>Jii::t('ID'),'fieldOrder'=>'con_id','filter'=>true,'type'=>'int'),
				array('label'=>Jii::t('Slug'),'fieldOrder'=>'con_slug','filter'=>true),
				array('label'=>Jii::t('Title'),'fieldOrder'=>'lng_title','filter'=>true),
				array('label'=>Jii::t('Status'),'fieldOrder'=>'con_status','filter'=>true,'type'=>'list','data'=>Content::status()->getList()),
				array('label'=>Jii::t('Comments'),'fieldOrder'=>'con_hascomments','filter'=>true,'type'=>'list','data'=>Content::comment()->getList()),
				array('label'=>
				CHtml::link(Jii::t('Add'),urlencode(Jii::app()->createUrl('content/add',array('f'=>$this->family,'c'=>$this->category))))
				,'fieldOrder'=>'','filter'=>false),
				
				),
	  'pageSize'=>5,
	  'orderBy'=>'con_id',
	  'orderPosition'=>'desc'
	  
	)); 
}
?>