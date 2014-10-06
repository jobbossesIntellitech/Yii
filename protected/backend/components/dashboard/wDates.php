<?php
class wDates extends CWidget{
	public $dashboard;
	public function init(){	
		parent::init();	
	}
	public function run(){
		//$date = Date::get($this->id);
		$list = array();
		$extends = Setting::get('system','extends_JActiveRecord');
		$extends = explode(',',$extends);
		/*if(!empty($extends) && is_array($extends)){
			foreach($extends AS $extend){
				$extend = trim($extend);
				list($extend,$attrs) = explode(':',$extend);
				$attrs = explode('|',$attrs);
				$data = $extend::model()->with('dates')->findAll();
				if(!empty($data) && is_array($data)){
					if(!isset($list[$extend])){ 
						$list[$extend] = array();	
					}
					foreach($data AS $d){
						$name = '';
						if(!empty($attrs) && is_array($attrs)){
							foreach($attrs AS $attr){
								$name .= $d->$attr.' ';
							}
						}
						$list[$extend][] = array(
							'id'=>$d->primaryKey,
							'name'=>$name,
							'create'=>$d->dates->dat_creation,
							'update'=>json_decode($d->dates->dat_update),
						);
					}
				}
			}
		}*/
		//Jii::print_r($list);
		$this->render('vDates',array('list'=>$list));	
	}
}
?>