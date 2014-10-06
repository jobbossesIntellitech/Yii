<?php
class SearchController extends SController{
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
		
		$this->pageTitle = Jii::t('Search Forms');
		Log::trace('Access Search Forms');
		$this->render('index',array('f'=>$this->form));
		
	}
	
	public function actionGetsearchline(){
		if(Jii::param('itemid') && Jii::param('n')){
			/*$item = Item::model()->findByPk(Jii::param('itemid'));
			//echo $item->itm_formid;
			$criteria = new CDbCriteria;
			$criteria->addCondition('form_id = '.$item->itm_formid);
			$criteria->with = array('section'=>array('with'=>array('field')));
			$criteria->addCondition('form_status = '.Form::status()->getItem('publish')->getValue());
			$form = Form::model()->with()->find($criteria);
			
			$message = '';
			if(isset($form->section) && is_array($form->section) && !empty($form->section)){
				$message .= '<div class="field">';
					$message .= '<div class="input">';
						$message .= '<select class="fieldlist">';
						foreach($form->section AS $section){
							//$message .= '<tr><th colspan="2" style="background:#fabc00; color:#874700; padding:5px;">'.$section->sec_title.'</th></tr>';
							if(isset($section->field) && is_array($section->field) && !empty($section->field)){
								$message .= '<option value=""> -- Please Select Field -- </option>';
								foreach($section->field AS $field){
									$message .= '<option value="'.$field->fld_id.'">'.$field->fld_label.'</option>';
								}
							}
						}
						$message .= '</select>';
					$message .= '</div>';
					
					$message .= '<div class="input">';
						$types = Search::type()->getList();
						$message .= '<select class="typelist">';
							$message .= '<option value=""> -- Please Select Type -- </option>';
							foreach($types AS $k=>$v){
								$message .= '<option value="'.$k.'">'.$v.'</option>';
							}
						$message .= '</select>';
					$message .= '</div>';
					
					$message .= '<div class="input">';
						$message .= '<div class="labels">';
							$message .='<label style="color:#fff;">Label1</label><input id="label1" name="label1" type="text" />';
						$message .= '</div>';
					$message .= '</div>';
					
					$message .= '<div class="input">';
						$message .= '<div class="options_radio">';
							$message .='<label style="color:#fff;">Options Inherit From Forms</label><div class="clear"></div>';
							$message .='<input type="radio" name="option'.Jii::param('n').'" value="0" /><label style="color:#fff; margin-right:20px;">disable</label>';
							$message .='<input type="radio" name="option'.Jii::param('n').'" value="1"  checked="checked"/><label style="color:#fff;">enable</label>';
						$message .= '</div>';
					$message .= '</div>';
					
					$message .= '<div class="clear"></div>';
					$message .= '<div class="options fields" style="display:none;">';
						$message .= '<a class="add_new_option" href="javascript://">+</a>';
					$message .= '</div>';
					
				$message .= '</div>';
				
			}
			echo $message;
		*/	
		}
	}

	
}
?>