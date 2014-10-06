<?php
class FormController extends SController{
	
	public function actionIndex(){
		if(Jii::isAjax()){
			Log::trace('Access Forms list');
			$criteria = new JDbGridView;
			echo $criteria->execute($this,'Form',array(),'list');
		}else{
			Log::trace('Access Forms');
			$this->pageTitle = Jii::t('Form Generator');
			$this->render('index');
		}
	}
	
	public function actionAdd(){
		$this->pageTitle = Jii::t('Add new form');
		$model = new FormForm;
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$f = new Form;
				$f->form_title = $model->title;
				$f->form_status = $model->status;
				$f->form_sendto = $model->sendto;
				$f->form_email = $model->email;
				if($f->save()){
					Log::success('The Form has been created succesfully');	
				}else{
					Log::error('The Form hasnt been created');	
				}
				$this->redirect(array('form/index'));
			}else{
				Log::warning('Form inputs error');
				$this->render('add',array('model'=>$model));	
			}
		}else{
			Log::trace('Access add new form');
			$this->render('add',array('model'=>$model));
		}
	}
	
	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit form');
		$model = new FormForm;
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$f = Form::model()->findByPk($model->id);
				$f->form_title = $model->title;
				$f->form_status = $model->status;
				$f->form_sendto = $model->sendto;
				$f->form_email = $model->email;
				if($f->save()){
					Log::success('The Form has been edited succesfully');	
				}else{
					Log::error('The Form hasnt been edited');	
				}
				$this->redirect(array('form/index'));
			}else{
				Log::warning('Form inputs error');
				$this->render('edit',array('model'=>$model));	
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access edit form');
				$f = Form::model()->findByPk(Jii::param('id'));
				$model->id = $f->form_id;
				$model->title = $f->form_title;
				$model->status = $f->form_status;
				$model->sendto = $f->form_sendto;
				$model->email = $f->form_email;
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('form/index'));
			}
		}
	}
	
	public function actionStatus(){
		Log::trace('Access change status of form');
		$this->pageTitle = Jii::t('Change status of form');
		$f = Form::model()->findByPk(Jii::param('id'));
		if(isset($f->form_id)){
			$f->form_status = Jii::param('status');
			if($f->save()){
				Log::success('The form has been changed status successfully');	
			}else{
				Log::error('The form hasnt been changed status');	
			}	
		}else{
			Log::warning('Form not found');	
		}
		$this->redirect(array('form/index'));	
	}
	
	public function actionDelete(){
		Log::trace('Access delete form');
		$this->pageTitle = Jii::t('Delete Form');
		$f = Form::model()->findByPk(Jii::param('id'));
		if(isset($f->form_id)){
			$res = $f->delete();
			if($res){
				Log::success('The form has been deleted successfully');	
			}else{
				Log::error('The form hasnt been deleted');	
			}	
		}else{
			Log::warning('Form not found');	
		}
		$this->redirect(array('form/index'));	
	}
	
	public function actionManage(){
		Log::trace('Access Form Manager');
		$cs=Jii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/ui.js');
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/jquery.maskedinput.min.js');
		
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/jquery.tagsinput.min.js');
		
		$cs->registerCssFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/_samples/sample.css');
		$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/ckeditor.js');
		$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/_samples/sample.js');
		
		$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/js/b/formgenerator.js');
		
		$form = Form::get(Jii::param('id'));
		if(isset($form[Jii::param('id')]) && Form::status()->equal('draft',$form[Jii::param('id')]['status'])){
			$this->pageTitle = Jii::t('Manage Form').' '.$form[Jii::param('id')]['title'];		
			$this->render('manage',array('form'=>$form[Jii::param('id')]));
		}else{
			$this->redirect(array('form/index'));
		}
	}
	
	public function actionSave(){
		Log::trace('Save Form Generator');
		$form = Jii::param('form');
		$criteria = new CDbCriteria;
		$criteria->addCondition('sec_formid = '.Jii::param('id'));
		$sections = FormSection::model()->findAll($criteria);
		if(isset($sections) && !empty($sections) && is_array($sections)){
			foreach($sections AS $section){
				$section->delete();
			}
		}
		if($form && is_array($form) && !empty($form)){
			$pos = 0;
			foreach($form AS $section=>$field){
				$s = new FormSection;
				$s->sec_title = $section;
				$s->sec_position = ++$pos;
				$s->sec_formid = Jii::param('id');
				$res = $s->save();
				if($res){
					Log::success('The form section has been inserted successfully');
					if($res && is_array($field) && !empty($field)){
						foreach($field AS $k=>$e){
							$f = new FormField;
							$f->fld_sectionid = $s->sec_id;
							$f->fld_position = $k;
							$f->fld_label = isset($e['label'])?$e['label']:'';
							$f->fld_type = isset($e['type'])?FormField::type()->getItem($e['type'])->getValue():0;
							$f->fld_required = isset($e['require'])?$e['require']:0;
							$f->fld_options = isset($e['options'])?$e['options']:'';
							$f->fld_errormessage = isset($e['errormessage'])?$e['errormessage']:'';
							$f->fld_defaultvalue = isset($e['defaultvalue'])?$e['defaultvalue']:'';
							$res = $f->save();
							if($res){
								Log::success('The form field has been inserted successfully');
							}else{
								Log::error('The form field hasnt been inserted');
							}
						}
					}
				}else{
					Log::error('The form section hasnt been inserted');
				}
				if($res){
					Log::success('The form has been saved successfully');
				}else{
					Log::error('The form hasnt been saved completly');
				}
			}
		}else{
			Log::warning('Request lost required arguments, please try again');
		}
		$this->redirect(array('form/manage','id'=>Jii::param('id')));
	}
	
	public function actionResults(){
		if(Jii::param('id')){
			$criteria = new CDbCriteria;
			$criteria->addCondition('form_id = '.Jii::param('id') );
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
			$data = Form::model()->find($criteria);
			if(isset($data->form_id)){	
				$this->pageTitle = Jii::t('Results of form').' '.$data->form_title;
				$request = array();
				if(isset($data->section) && is_array($data->section) && !empty($data->section)){
					foreach($data->section AS $section){
						if(isset($section->field) && is_array($section->field) && !empty($section->field)){
							foreach($section->field AS $field){
								if(isset($field->save) && is_array($field->save) && !empty($field->save)){
									foreach($field->save AS $save){
										if(!isset($request[$save->save_requestkey])){
											$request[$save->save_requestkey] = array();
										}
										$label = $field->fld_label;
										$value = $save->save_value;
										if(FormField::type()->equal('hidden',$field->fld_type)){
											list($label,$value) = explode('||',$save->save_value);
										}
										$request[$save->save_requestkey][$field->fld_id] = array();
										$request[$save->save_requestkey][$field->fld_id]['label'] = $label;
										$request[$save->save_requestkey][$field->fld_id]['value'] = $value;
									}
								}	
							}
						}
					}
				}
				
				$criteria = new CDbCriteria;
				$criteria->with = array('dates','field'=>array('with'=>array('section'=>array('condition'=>'sec_formid = '.Jii::param('id')))));
				$criteria->group = 'save_requestkey';
				$list = FormSave::model()->findAll($criteria);
			
				$this->render('results',array('data'=>$request,'list'=>$list));
			}else{
				$this->redirect(array('form/index'));
			}
		}else{
			$this->redirect(array('form/index'));
		}
	}
	
}
?>