<?php 
class SearchformbuilderController extends SController{
	public $form;
	public $forms;
	public function init(){
		parent::init();
		$this->forms = Item::tree(0);
		$this->form = 0;
		if(Jii::param('f') && Jii::param('f') > 0){
			$this->form = Jii::param('f');
		}else{
			if(!empty($this->forms) && is_array($this->forms)){
				reset($this->forms);
				$this->form = key($this->forms);
			}
		}
	}
	
	public function actionIndex(){
		$this->pageTitle = Jii::t('Search Form Builder');
		$item = Item::model()->findByPk($this->form);
		$criteria = new CDbCriteria;
		$criteria->addCondition('form_id = '.$item->itm_formid);
		$criteria->with = array('section'=>array('with'=>array('field')));
		$criteria->addCondition('form_status = '.Form::status()->getItem('publish')->getValue());
		$form = Form::model()->find($criteria);
		$fields = array();
		if(isset($form->section) && !empty($form->section) && is_array($form->section)){
			foreach($form->section AS $section){
				$fields[$section->sec_title] = array();
				if(isset($section->field) && !empty($section->field) && is_array($section->field)){
					foreach($section->field AS $field){
						$fields[$section->sec_title][$field->fld_id]=$field->fld_label.' -'.FormField::type()->getLabelByValue($field->fld_type).'';
					}
				}
			}
		}
		$fields = array('Table Fields'=>array(
			'ads_price'=>Jii::t('Price Field'),
			'ads_reference'=>Jii::t('Reference Field')
		))+$fields;
		$data = Search::model()->findAllByAttributes(array('fse_itemid'=>$this->form));
		$this->render('index',array('fields'=>$fields,'data'=>$data));
	}
	
	public function actionSave(){
		$this->pageTitle = Jii::t('Save Search Form Builder');
		$data = Jii::param('sfb');
		$this->save($this->form,$data);
		$duplicateto = Jii::param('duplicateto');
		if(!empty($duplicateto) && is_array($duplicateto)){
			foreach($duplicateto AS $duplicate){
				$this->save($duplicate,$data);
			}
		}
		Log::success('The Save Search Form Builder has been saved successfully');
		$this->redirect(array('searchformbuilder/index','f'=>$this->form));
	}
	
	private function save($item,$data){
		Search::model()->deleteAllByAttributes(array('fse_itemid'=>$item));
		if(!empty($data) && is_array($data)){
			foreach($data AS $area=>$fields){
				if(!empty($fields) && is_array($fields)){
					foreach($fields AS $i=>$field){
						$s = new Search;
						$s->fse_itemid = $item;
						$s->fse_view = $area;
						$s->fse_fieldid = $field['field'];
						$s->fse_type = $field['search'];
						$s->fse_position = $i;
						$s->fse_label = json_encode($field['label']);
						$s->fse_options = '';
						if(isset($field['integer'])){
							$s->fse_options = json_encode(array('integer'=>$field['integer']));
						}else
						if(isset($field['inherit'])){
							if($field['inherit']){
								$s->fse_options = json_encode(array('inherit'=>$field['inherit']));
							}else{
								$s->fse_options = json_encode($field['option']);
							}
						}
						$s->save();
					}
				}
			}
			return true;
		}
		return false;
	}
}