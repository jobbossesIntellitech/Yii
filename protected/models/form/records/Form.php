<?php
class Form extends JActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'form_forms';
	}
	public function relations()
	{
		return array(
					'section'=>array(self::HAS_MANY,'FormSection','sec_formid'),
					'dates'=>array(self::BELONGS_TO,'Date','date_id'),
				);	
	}
	private static $status = NULL;
	public static function status(){
		if(self::$status == NULL){
			self::$status = new Status();
			self::$status->add('draft',0x00,Jii::t('Draft'),'Draft Form');
			self::$status->add('publish',0x01,Jii::t('Publish'),'Publish Form');
			self::$status->add('close',0x02,Jii::t('Close'),'Close Form');
			self::$status->add('delete',0x03,Jii::t('Delete'),'Delete Form');
		}
		return self::$status;	
	}
	
	private static $sendto = NULL;
	public static function sendto(){
		if(self::$sendto == NULL){
			self::$sendto = new Status();
			self::$sendto->add('db',0x00,Jii::t('DB Only'),'Send to db only');
			self::$sendto->add('email',0x01,Jii::t('Email & DB'),'Send to db and by email');
		}
		return self::$sendto;	
	}
	
	public function afterDelete(){
		parent::afterDelete();
		$criteria = new CDbCriteria;
		$criteria->addCondition('sec_formid = '.$this->form_id);
		$list = FormSection::model()->findAll($criteria);
		if(!empty($list) && is_array($list)){
			foreach($list AS $l){
				$l->delete();
			}
		}
	}
	
	public static function get($form_id,$without = NULL){
		$criteria = new CDbCriteria;
		$criteria->addCondition('form_id = '.$form_id);
		if($without != 'section'){
			$criteria->with = array('section');
		}
		if($without != 'field'){
			$criteria->with = array(
				'section'=>array(
					'with'=>array(
						'field'
					)
				)
			);
		}
		if($without != 'save'){
			$criteria->with = array(
				'section'=>array(
					'with'=>array(
						'field'=>array(
							'with'=>array(
								'save'
							)
						)
					)
				)
			);
		}
		$criteria->order = 'fld_position ASC';
		$form = self::model()->find($criteria);
		$list = array();
		if(isset($form->form_id)){
			$list[$form->form_id] = array();
			$list[$form->form_id]['title'] = $form->form_title;
			$list[$form->form_id]['sendto'] = $form->form_sendto;
			$list[$form->form_id]['email'] = $form->form_email;
			$list[$form->form_id]['status'] = $form->form_status;
			$list[$form->form_id]['sections'] = array();
			if(isset($form->section) && is_array($form->section) && !empty($form->section)){
				foreach($form->section AS $section){
					$list[$form->form_id]['sections'][$section->sec_id] = array();
					$list[$form->form_id]['sections'][$section->sec_id]['title'] = $section->sec_title;
					$list[$form->form_id]['sections'][$section->sec_id]['fields'] = array();
					if(isset($section->field) && is_array($section->field) && !empty($section->field)){
						foreach($section->field AS $field){
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id] = array();
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['position'] = $field->fld_position;
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['label'] = $field->fld_label;
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['type'] = FormField::type()->getKeyByValue($field->fld_type);
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['require'] = $field->fld_required;
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['options'] = $field->fld_options;
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['errormessage'] = $field->fld_errormessage;
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['defaultvalue'] = $field->fld_defaultvalue;
							$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['requests'] = array();
							if(isset($field->save) && is_array($field->save) && !empty($field->save)){
								foreach($field->save AS $save){
									if(!isset($list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['requests'][$save->save_requestkey])){
										$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['requests'][$save->save_requestkey] = array();
									}
									$list[$form->form_id]['sections'][$section->sec_id]['fields'][$field->fld_id]['requests'][$save->save_requestkey][$save->save_id] = $save->save_value;							
								}
							}
						}
					}
				}
			}
		}
		return $list;
	}
}
?>