<?php
class Jii extends Yii{
	private static $param;
	private static $translate;
	private static $permissions;
	public static function initParam()
	{
		self::$param = array_merge($_GET,$_POST,$_REQUEST);		
	}
	public static function param( $k = NULL )
	{
		if($k == NULL)
		{
			return self::$param;	
		}
		else
		{
			return isset(self::$param[$k])?self::$param[$k]:false;
		}	
	}
	public static function changeLanguage($lang)
	{
		if ($lang)
		{
			self::app()->language = $lang;
			self::app()->session['_lang'] = self::app()->language;
			Jii::app()->user->setState('language',self::app()->language);
		}
		else
		{
			if(isset(self::app()->user->language)){
				self::app()->session['_lang'] = self::app()->user->language;	
			}
			self::app()->language = self::app()->session['_lang'];
			$criteria = new CDbCriteria;
			$criteria->addCondition('lng_id = "'.self::app()->language.'"');
			$criteria->addCondition('lng_status = '.Language::status()->getItem('enable')->getValue());
			$l = Language::model()->find($criteria);
			if(!isset($l->lng_id))
			{
				$criteria = new CDbCriteria;
				$criteria->addCondition('lng_status = '.Language::status()->getItem('enable')->getValue());
				$l = Language::model()->find($criteria);
				if(isset($l->lng_id))
				{
					self::app()->language = $l->lng_id;
					self::app()->session['_lang'] = self::app()->language;
					Jii::app()->user->setState('language',self::app()->language);
				}
				else
				{
					throw new CHttpException(404,'Language not found.');	
				}
			}else
			{
				self::app()->language = $l->lng_id;	
			}
		}		
	}
	public static function changeColor($color){
		if($color){
			Jii::app()->user->setState('color',$color);		
		}	
	}
	public static function loadTranslation()
	{
		self::$translate = Translate::get();	
	}
	public static function t($key,$message=null,$params = Array(), $source = NULL,$language = NULL){
		if(!isset(self::$translate[$key]))
		{
			self::$translate[$key] = $key;
			$criteria = new CDbCriteria;
			$criteria->addCondition('trs_key = "'.$key.'"');
			$criteria->addCondition('trs_languageid = "'.self::app()->language.'"');
			if(self::is_frontend())
			{
				$criteria->addCondition('trs_application = "frontend"');
			}
			else
			{
				$criteria->addCondition('trs_application = "backend"');	
			}
			$t = Translate::model()->find($criteria);
			if(!isset($t->trs_id))
			{
				$t = new Translate;
				$t->trs_key = $key;
				$t->trs_languageid = self::app()->language;
				$t->trs_application = self::application();
				$t->trs_value = self::$translate[$key];
				$res = $t->save();
			}
			else
			{
				self::$translate[$key] = $t->trs_value;		
			}
		}
		return self::$translate[$key];
	}
	public static function is_frontend()
	{
		return self::app()->params['frontend'];	
	}
	public static function is_backend()
	{
		return !self::app()->params['frontend'];	
	}
	public static function application()
	{
		return (self::is_frontend())?'frontend':'backend';		
	}
	public static function ajaxValidation($model)
	{
		if(self::param('ajax'))
		{
			echo CActiveForm::validate($model);
			self::app()->end();
		}	
	}
	public static function is_chrome()
	{
		return(preg_match("/chrome/i", $_SERVER['HTTP_USER_AGENT']));
	}
	public static function is_firefox()
	{
		return(preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT']));
	}
	public static function is_safari()
	{
		return(preg_match("/Safari/i", $_SERVER['HTTP_USER_AGENT']));
	}
	public static function is_opera()
	{
		return(preg_match("/Opera/i", $_SERVER['HTTP_USER_AGENT']));
	}
	public static function is_ie_greater_8(){
		preg_match('/MSIE\s([\d]+)/',$_SERVER['HTTP_USER_AGENT'],$matches);
		$version = isset($matches[1])?$matches[1]:0;
		return ($version > 8);
	}
	public static function valideBrowser(){
		return (self::is_chrome() || self::is_firefox() || self::is_safari() || self::is_opera() || self::is_ie_greater_8());
	}
	public static function getPermissions(){
		return self::$permissions;
	}
	public static function permissions(){
		self::$permissions = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition('permission_userid = '.Yii::app()->user->id);
		$criteria->with = array('controllertable','actiontable');
		$permissions = PermissionTable::model()->findAll($criteria);
		if(!empty($permissions) && is_array($permissions)){
			foreach($permissions AS $permission){
				$c = strtolower($permission->controllertable->controller_name);
				$a = strtolower($permission->actiontable->action_name);
				if(!isset(self::$permissions[$c])){
					self::$permissions[$c] = array();
				}
				self::$permissions[$c][$a] = $permission->permission_id;
			}
		}
	}
	public static function hasPermission($controller,$action){
		$has = false;
		if(Yii::app()->user->id > 1){
			if(isset(self::$permissions[strtolower($controller)][strtolower($action)])){ $has = true; }
		}else{
			$has = true;	
		}
		return $has;
	}
	public static function print_r($p){
		echo '<pre class="print_r">';
			print_r($p);
		echo '</pre>';
	}
	public static function isAjax(){
		return self::app()->request->isAjaxRequest;	
	}
	
	public static function notfound(){
		return '/assets/notfound.jpg';	
	}

	public static function slug($text){ 
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

	  // trim
	  $text = trim($text, '-');

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // lowercase
	  $text = strtolower($text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  if (empty($text))
	  {
		return 'n-a';
	  }

	  return $text;
	}	
	
	public static function file_size($a_bytes){
		if ($a_bytes < 1024) {
			return $a_bytes .' B';
		} elseif ($a_bytes < 1048576) {
			return round($a_bytes / 1024, 2) .' KB';
		} elseif ($a_bytes < 1073741824) {
			return round($a_bytes / 1048576, 2) . ' MB';
		} elseif ($a_bytes < 1099511627776) {
			return round($a_bytes / 1073741824, 2) . ' GB';
		} elseif ($a_bytes < 1125899906842624) {
			return round($a_bytes / 1099511627776, 2) .' TB';
		} elseif ($a_bytes < 1152921504606846976) {
			return round($a_bytes / 1125899906842624, 2) .' PB';
		} elseif ($a_bytes < 1180591620717411303424) {
			return round($a_bytes / 1152921504606846976, 2) .' EB';
		} elseif ($a_bytes < 1208925819614629174706176) {
			return round($a_bytes / 1180591620717411303424, 2) .' ZB';
		} else {
			return round($a_bytes / 1208925819614629174706176, 2) .' YB';
		}
	}
}
?>