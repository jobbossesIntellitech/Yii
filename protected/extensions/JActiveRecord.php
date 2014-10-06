<?php
class JActiveRecord extends CActiveRecord{
	public function afterSave(){
		parent::afterSave();
		$this->setPrimaryKey($this->primaryKey);
		if($this->isNewRecord){
			$id = Date::store();
			$sql = 'update '.$this->tableName().' SET date_id = '.$id.' where '.$this->tableSchema->primaryKey.' = '.$this->primaryKey;
			Jii::app()->db->createCommand($sql)->execute();
		}else{
			$id = Date::store($this->date_id);
		}
		return true;
	}
	public function afterDelete(){
		parent::afterDelete();
		return Date::remove($this->date_id);
	}
}
?>