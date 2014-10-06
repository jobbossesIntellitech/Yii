<?php
class FormMenuOption extends JMenuOption{
	public function process(){
		$list = array('title'=>Jii::t('Forms'),'list'=>array());
		$criteria = new CDbCriteria;
		$criteria->addCondition('form_status = '.Form::status()->getItem('publish')->getValue());
		$forms = Form::model()->findAll($criteria);
		if(isset($forms) && is_array($forms) && !empty($forms)){
			foreach($forms AS $form){
				$i = count($list['list']);
				$list['list'][$i] = array();
				$list['list'][$i]['label'] = $form->form_title;
				$list['list'][$i]['link'] = Jii::app()->createUrl('formgenerator/view',array('id'=>$form->form_id));
			}
		}
		return $list;
	}	
}
?>