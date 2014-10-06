<?php
class SearchController extends Controller{
	
	/*public function actionGetSubCategories(){
		if(Jii::isAjax()){
			$data = array();
			$criteria = new CDbCriteria();
			$criteria->addCondition('itm_parentid = '.Jii::param('category'));
			$data['list'] = CHtml::ListData(Item::model()->findAll($criteria),'itm_id','itm_name');
			echo json_encode($data);
		}
	}*/
	
	public function actionGetSubCategories(){
		if(Jii::isAjax()){
			$data = array();
			$criteria = new CDbCriteria();
			$criteria->addCondition('itm_parentid = '.Jii::param('category'));
			$criteria->order = 'itm_position DESC,itm_name ASC';
			$list = Item::model()->findAll($criteria);
			$list = CHtml::ListData($list,'itm_id','itm_name');
			
			$i = 0;
			foreach($list as $k=>$v){
				$data['list'][$i] = array();
				$data['list'][$i]['id'] = $k;
				$data['list'][$i]['name'] = $v;
				$i++;
			}
			//$data['list'] = CHtml::ListData($list,'itm_id','itm_name');
			echo json_encode($data);
		}
	}
	
	public function actionGetCities(){
		if(Jii::isAjax()){
			$list = array();
			$data = array();
			$criteria = new CDbCriteria();
			$criteria->addCondition('loc_parentid = '.Jii::param('country'));
			$criteria->order = 'loc_position DESC, loc_name ASC';
			$list = Location::model()->findAll($criteria);
			$list = CHtml::ListData($list,'loc_id','loc_name');
			
			$i = 0;
			foreach($list as $k=>$v){
				$data['list'][$i] = array();
				$data['list'][$i]['id'] = $k;
				$data['list'][$i]['name'] = $v;
				$i++;
			}
			//sort($data['list']);
			echo json_encode($data);
		}
	}
	
	public function actionGetSearchFields(){
		if(Jii::isAjax()){
			$data = array();
			$criteria = new CDbCriteria;
			$criteria->addCondition('fse_itemid='.Jii::param('category'));
			$criteria->with = array('item','field');
			$criteria->order = 'fse_view ASC, fse_position ASC';
			$fields = Search::model()->findAll($criteria);
			if(!empty($fields) && is_array($fields)){
				foreach($fields AS $field){
					if(!isset($data[$field->fse_view])){ $data[$field->fse_view] = array(); }
					$data[$field->fse_view][$field->fse_position] = array();
					$data[$field->fse_view][$field->fse_position]['item'] = $field->fse_itemid;
					$data[$field->fse_view][$field->fse_position]['field'] = $field->fse_fieldid;
					$data[$field->fse_view][$field->fse_position]['form'] = $field->item->itm_formid;
					$data[$field->fse_view][$field->fse_position]['type'] = $field->fse_type;
					$data[$field->fse_view][$field->fse_position]['label'] = json_decode($field->fse_label);
					$options = json_decode($field->fse_options);
					if(isset($options->inherit)){
						$options = $this->getInheritOptions($field->fse_fieldid);
					}
					$data[$field->fse_view][$field->fse_position]['options'] = $options;
				}
			}
			echo json_encode($data);
		}
	}
	
	private function getInheritOptions($id){
		$list = array();
		$field = FormField::model()->findByPk($id);
		if(isset($field->fld_id) && !empty($field->fld_options)){
			$options = explode('|-|',$field->fld_options);
			if(!empty($options) && is_array($options)){
				foreach($options AS $option){
					$option = explode(':=:',$option);
					if(!isset($option[1])){ $option[1] = $option[0]; }
					$list[] = array('value'=>$option[0],'label'=>$option[1]);
				}
			}
		}
		return $list;
	}
	
	/*public function actionIndex(){
		Jii::print_r(Jii::param());
	}*/
	
	public function actionIndex(){
		$query = '';
		$operation = 'AND';
		$params = array();
		$criteria = new CDbCriteria;
		
		if(Jii::param('keywords')){
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .="ads_description like '%".Jii::param('keywords')."%'";
			$query .= ' OR ';
			$query .="ads_name like '%".Jii::param('keywords')."%'";
			$query .= ' OR ';
			$query .= "mbr_firstname like '%".Jii::param('keywords')."%'";
			$query .= ' OR ';
			$query .= "mbr_lastname like '%".Jii::param('keywords')."%'";			
		}
		
		if(Jii::param('reference')){
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .="ads_reference like '%".Jii::param('reference')."%'";
		}
		
		if(Jii::param('field_only_with_photo') && Jii::param('field_only_with_photo') == 'yes'){
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .="ads_gallery != ''";
		}
		
		if(Jii::param('subsubsubcategory')){
			$criteria_subcategory = new CDbCriteria();
			$criteria_subcategory->addCondition('itm_parentid = '.Jii::param('subsubsubcategory'));
			$big_items = Item::model()->findAll($criteria_subcategory);
			$list_big_items = CHtml::ListData($big_items,'itm_id','itm_id');
			if(empty($list_big_items) && is_array($list_big_items)) $list_big_items = array(-1);
			
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .='ads_itemid in ('.implode(',',$list_big_items).','.Jii::param('subsubsubcategory').')';
		}elseif(Jii::param('subsubcategory')){
			$criteria_subcategory = new CDbCriteria();
			$criteria_subcategory->addCondition('itm_parentid = '.Jii::param('subsubcategory'));
			$big_items = Item::model()->findAll($criteria_subcategory);
			$list_big_items = CHtml::ListData($big_items,'itm_id','itm_id');
			if(empty($list_big_items) && is_array($list_big_items)) $list_big_items = array(-1);
			
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .='ads_itemid in ('.implode(',',$list_big_items).','.Jii::param('subsubcategory').')';
		}elseif(Jii::param('subcategory')){
			$criteria_subcategory = new CDbCriteria();
			$criteria_subcategory->addCondition('itm_parentid = '.Jii::param('subcategory'));
			$big_items = Item::model()->findAll($criteria_subcategory);
			$list_big_items = CHtml::ListData($big_items,'itm_id','itm_id');
			
			if(empty($list_big_items) && is_array($list_big_items)) $list_big_items = array(-1);
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .='ads_itemid in ('.implode(',',$list_big_items).')';
		}elseif(Jii::param('category')){
			$criteria_category = new CDbCriteria();
			$criteria_category->addCondition('itm_parentid = '.Jii::param('category'));
			$big_items = Item::model()->findAll($criteria_category);
			$list_big_items = CHtml::ListData($big_items,'itm_id','itm_id');
			
			$criteria_category = new CDbCriteria();
			$criteria_category->addCondition('itm_parentid in ('.implode(',',$list_big_items).')');
			$subbig_items = Item::model()->findAll($criteria_category);
			$list_subbig_items = CHtml::ListData($subbig_items,'itm_id','itm_id');
			
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .='ads_itemid in ('.implode(',',$list_subbig_items).')';
		}
		
		if(Jii::param('city')){
			$criteria_location = new CDbCriteria();
			$criteria_location->addCondition('loc_parentid = '.Jii::param('city'));
			$location = Location::model()->findAll($criteria_location);
			$locations = CHtml::ListData($location,'loc_id','loc_id');
			if(empty($locations) && is_array($locations)) $locations = array(-1);
			
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .='ads_locationid in ('.implode(',',$locations).','.Jii::param('city').')';
		}elseif(Jii::param('country')){
			$criteria_location = new CDbCriteria();
			$criteria_location->addCondition('loc_parentid = '.Jii::param('country'));
			$location = Location::model()->findAll($criteria_location);
			
			$locations = CHtml::ListData($location,'loc_id','loc_id');
			if(empty($locations) && is_array($locations)) $locations = array(-1);
			
			if($query != ''){ $query .= ' '.$operation.' '; }
			$query .='ads_locationid in ('.implode(',',$locations).')';
		}
		$criteria->with = array(
			'item'=>array(
				'with'=>array(
					'form'=>array(
						'with'=>array(
							'section'=>array(
								'with'=>array(
									'field'=>array(
										'with'=>array(
											'save',
										)
									)
								)
							)
						)
					)
				)
			),
			'member',
		);
		
		$lists = Jii::param('field');
		$advance_query = array();
		if($lists && !empty($lists) && is_array($lists)){
			foreach($lists as $list){
				foreach($list as $form_id=>$field){
					foreach($field as $fieldid=>$type){
						foreach($type as $value_k=>$value_v){
							if(is_numeric($fieldid)){
								if(is_array($value_v)){
									if(!empty($value_v[0]) && !empty($value_v[1]) && (in_array($value_k,array(3,8)))){
										$subcriteria = new CDbCriteria;
										$subcriteria->addCondition('save_fieldid ='.$fieldid.' AND save_value >= '.$value_v[0].' AND save_value <= '.$value_v[1]);
										$records = FormSave::model()->findAll($subcriteria);
										$saves = CHtml::ListData($records,'save_requestkey','save_requestkey');
										
										array_push($advance_query,'ads_saverequestkey in ("'.implode('","',$saves).'") AND save_fieldid ='.$fieldid.' AND save_value >= '.$value_v[0].' AND save_value <= '.$value_v[1]);
										/*$criteria->addCondition('ads_saverequestkey in ("'.implode('","',$saves).'")');
										$criteria->addCondition('save_fieldid ='.$fieldid.' AND save_value >= '.$value_v[0].' AND save_value <= '.$value_v[1]);*/
									}elseif(!empty($value_v) && (in_array($value_k,array(5)))){
										$subcriteria = new CDbCriteria;
										$subcriteria->addCondition('save_fieldid ='.$fieldid.' AND save_value in ("'.implode('","',$value_v).'")');
										$records = FormSave::model()->findAll($subcriteria);
										$saves = CHtml::ListData($records,'save_requestkey','save_requestkey');
										
										array_push($advance_query,'ads_saverequestkey in ("'.implode('","',$saves).'") AND save_fieldid ='.$fieldid.' AND save_value in ("'.implode('","',$value_v).'")');
										/*$criteria->addCondition('ads_saverequestkey in ("'.implode('","',$saves).'")');
										$criteria->addCondition('save_fieldid ='.$fieldid.' AND save_value in ("'.implode('","',$value_v).'")');*/
									}
								}else{
									if(!empty($value_v)){
										$subcriteria = new CDbCriteria;
										$subcriteria->addCondition('save_fieldid ='.$fieldid.' AND save_value = "'.$value_v.'"');
										$records = FormSave::model()->findAll($subcriteria);
										$saves = CHtml::ListData($records,'save_requestkey','save_requestkey');
										
										array_push($advance_query,'ads_saverequestkey in ("'.implode('","',$saves).'") AND save_fieldid ='.$fieldid.' AND save_value = "'.$value_v.'"');
										/*$criteria->addCondition('ads_saverequestkey in ("'.implode('","',$saves).'")');
										$criteria->addCondition('save_fieldid ='.$fieldid.' AND save_value = "'.$value_v.'"');*/
									}
								}
							}else{
								if(is_array($value_v)){
									if(!empty($value_v[0]) && !empty($value_v[1]))
										$criteria->addCondition($fieldid.' >= "'.$value_v[0].'" AND '.$fieldid.' <= "'.$value_v[1].'"');
								}else{
									if(!empty($value_v))
										$criteria->addCondition($fieldid.' = "'.$value_v.'"');
								}
							}
						}
					}
				}
			}
			
		}
		$criteria->addCondition($query);
		if(!empty($advance_query[0])){
			$criteria->addCondition(implode(' OR ',$advance_query));
			$criteria->together = true;
		}
		
		$criteria->order = 'ads_id DESC';
		if(Jii::param('sort') && Jii::param('order')){
			$criteria->order = Jii::param('sort').' '.Jii::param('order');
		}
		
		$criteria->addCondition('ads_status = '.Ads::status()->getItem('enable')->getValue());
		
		
		$pages = NULL;
		$pages = new CPagination(Ads::model()->count($criteria));
		$page = 0;
		if(Jii::param('page') && Jii::param('page') > 0){
			$pages->setCurrentPage(Jii::param('page')-1);
			$page = Jii::param('page')-1;
		}
		$criteria->limit = (Jii::param('number_ads') > 0)?Jii::param('number_ads'):5;
		$criteria->offset = $criteria->limit * $page;
		$pages -> pageSize = (Jii::param('number_ads') > 0)?Jii::param('number_ads'):5;
		//$pages -> applyLimit($criteria);
		$pages->params = array('subsubsubcategory'=>Jii::param('subsubsubcategory'),'subsubcategory'=>Jii::param('subsubcategory'),'subcategory'=>Jii::param('subcategory'),'category'=>Jii::param('category'),'city'=>Jii::param('city'),'country'=>Jii::param('country'),'reference'=>Jii::param('reference'),'keywords'=>Jii::param('keywords'),'field'=>Jii::param('field'),'sort'=>Jii::param('sort'),'order'=>Jii::param('order'),'number_ads'=>Jii::param('number_ads'));
		//Jii::print_r($criteria);
		//Jii::print_r($advance_query);
		$listads = Ads::model()->findAll($criteria);
		$this->render('searchresult',array('listads'=>$listads,'pages'=>$pages));
	}
	
}