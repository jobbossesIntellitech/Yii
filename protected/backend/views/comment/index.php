<?php
$form = '<table border="0"><tr><td>';
$form .= CHtml::beginForm(Jii::app()->createUrl('comment/index'),'GET',
array('name'=>'form1'));
	$form .= '<table border="0"><tr>';
	$form .= '<td>';
		$form .= CHtml::dropDownList('c1',$this->category,$this->categories,array('onchange'=>'document.form1.submit();'));
	$form .= '</td>';
	$form .= '</tr></table>';
$form .= CHtml::endForm();
$form .= '</td><td>';
$form .= CHtml::beginForm(Jii::app()->createUrl('comment/index'),'GET',
array('name'=>'form2'));
	$form .= CHtml::hiddenField('c1',$this->category);
	$form .= '<table border="0"><tr>';
	$form .= '<td>';
		$form .= CHtml::dropDownList('c2',$this->content,$this->contents,array('onchange'=>'document.form2.submit();'));
	$form .= '</td>';
	$form .= '</tr></table>';
$form .= CHtml::endForm();
$form .= '</td></tr></table>';
$option = Layout::bloc($form);
echo $option;
/* -- .................................................................................... -- */
if($this->category > 0 && $this->content > 0){
	$this->widget('wGridView',array(								  
	  'baseUrl'=>INDEX.'/comment/index',
	  'parameters'=>'c1='.$this->category.'&c2='.$this->content,
	  'headers'=>array(
				array('label'=>Jii::t('ID'),'fieldOrder'=>'com_id','filter'=>true,'type'=>'int'),
				array('label'=>Jii::t('Replay'),'fieldOrder'=>'com_parentid','filter'=>true,'type'=>'int'),
				array('label'=>Jii::t('Title'),'fieldOrder'=>'com_title','filter'=>true),
				array('label'=>Jii::t('Text'),'fieldOrder'=>'com_text','filter'=>true),
				array('label'=>Jii::t('Name'),'fieldOrder'=>'com_name','filter'=>true),
				array('label'=>Jii::t('Email'),'fieldOrder'=>'com_email','filter'=>true),
				array('label'=>Jii::t('Status'),'fieldOrder'=>'con_status','filter'=>true,'type'=>'list','data'=>Content::status()->getList()),
			),
	  'pageSize'=>5,
	  'orderBy'=>'com_id',
	  'orderPosition'=>'desc'
	  
	)); 
}
?>