<?php
class Date extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return Jii::app()->params['tablePrefix'].'sys_dates';
	}
	public static function store($id = NULL){
		$res = false;
		if($id == NULL){
			$d = new self;
			$d->dat_creation = date('Y-m-d H:i:s');
			$d->dat_update = json_encode(array());
			$d->save();
			$res = $d->dat_id;
		}else{
			$d = self::model()->findByPk($id);
			if(!isset($d->dat_id)){ 
				$res = self::store();
			}else{
				$updates = json_decode($d->dat_update);
				$updates[] = date('Y-m-d H:i:s');
				$d->dat_update = json_encode($updates);
				$d->save();
				$res = $d->dat_id;		
			}			
		}
		return $res;
	}
	public static function remove($id){
		$d = self::model()->findByPk($id);
		if(isset($d->dat_id)){
			return $d->delete();
		}
		return false;
	}
	
	public static function get($id){
		$d = self::model()->findByPk($id);
		if(isset($d->dat_id)){
			$list = array();
			$list['id'] = $d->dat_id;
			$list['create'] = $d->dat_creation;
			$list['update'] = json_decode($d->dat_update);
			return $list;
		}
		return false;
	}
}
?>