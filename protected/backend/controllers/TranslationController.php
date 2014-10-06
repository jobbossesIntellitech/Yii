<?php
class TranslationController extends SController{
	
	public $application;
	public $applications;
	public $key;
	public $keys;
	
	public function init(){
		parent::init();
		$this->applications = Translate::applications();
		if(Jii::param('a') && in_array(Jii::param('a'),$this->applications)){
			$this->application = Jii::param('a');
		}else{
			reset($this->applications);
			$this->application = key($this->applications);
		}
		$this->keys = Translate::keys($this->application);
		if(Jii::param('k') && in_array(Jii::param('k'),$this->keys)){
			$this->key = Jii::param('k');
		}else{
			reset($this->keys);
			$this->key = key($this->keys);
		}
	}
	
	public function actionIndex(){
		Log::trace('Access Translation Page');
		$this->pageTitle = Jii::t('Translation');
		
		$languages = Language::get();
		$values = Translate::getKeyValues($this->application,$this->key);
		
		$this->render('index',array('languages'=>$languages,'values'=>$values));
	}
	
	public function actionSave(){
		Log::trace('Save Translation Item');
		$data = Jii::param('data');
		if($data && isset($data[$this->application][$this->key]) && !empty($data[$this->application][$this->key]) &&
		is_array($data[$this->application][$this->key])){
			foreach($data[$this->application][$this->key] AS $language=>$value){
				$criteria = new CDbCriteria;
				$criteria->addCondition('trs_application = "'.$this->application.'"');
				$criteria->addCondition('trs_key = "'.$this->key.'"');
				$criteria->addCondition('trs_languageid = "'.$language.'"');
				$t = Translate::model()->find($criteria);
				if(!isset($t->trs_id)){
					$t = new Translate;
					$t->trs_application = $this->application;
					$t->trs_key = $this->key;
					$t->trs_languageid = $language;				
				}
				$t->trs_value = $value;
				$res = $t->save();
			}
			Log::success('The translations has been saved successfully');	
		}else{
			Log::warning('Request lost required arguments, please try again');
		}
		$this->redirect(array('translation/index','a'=>$this->application,'k'=>$this->key));
	}
	
}
?>