<?php
class wSearchForm extends CWidget{
	public function init(){
		parent::init();
	}
	public function run(){
		$data = array();
		
		$data['category'] = Jii::param('category');
		$criteria = new CDbCriteria;
		$criteria->addCondition('itm_parentid = 0');
		$criteria->addCondition('itm_status = '.Item::status()->getItem('enable')->getvalue());
		$cat = Item::model()->findAll($criteria);
		$data['categories'] = CHtml::ListData($cat,'itm_id','itm_name');
		$data['subcategory'] = Jii::param('subcategory');
		$data['subsubcategory'] = Jii::param('subsubcategory');
		$data['subsubsubcategory'] = Jii::param('subsubsubcategory');

		$data['country'] = Jii::param('country');
		$criteria = new CDbCriteria;
		$criteria->addCondition('loc_parentid = 0');
		$criteria->addCondition('loc_status = '.Item::status()->getItem('enable')->getvalue());
		$criteria->order = 'loc_name ASC';
		$loc = Location::model()->findAll($criteria);
		
		$data['countries'] = CHtml::ListData($loc,'loc_id','loc_name');
		//sort($data['countries']);
		
		$data['city'] = Jii::param('city');
		
		$this->render('vSearchForm',array('data'=>$data));
	}

}
?>