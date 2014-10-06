<?php
class LActiveRecord extends CActiveRecord{
	public function scopes() {
		$langs = Language::model()->findAllByAttributes(array('lng_status'=>Language::status()->getItem('enable')->getValue()));
		$scope = array();
		if(isset($langs) && is_array($langs) && !empty($langs)){
			foreach($langs AS $lang){
				$scope[$lang->lng_id] = array('condition'=>'lng_languageid = "'.$lang->lng_id.'"');
			}
		}
		return $scope;
	}	
}
?>