<?php
class JMenuOption{
	
	private static $list = NULL;
	
	public function __construct(){
		
	}
	
	public static function get(){
		if(self::$list == NULL){
			$path = Jii::app()->params['frontendPath'].'/menus/';
			if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))) {
					if(!in_array($file,array('.','..'))){
						$file = explode('MenuOption.php',$file);
						if(isset($file[0])){
							$file = strtolower($file[0]);
							$classname = ucfirst(strtolower($file)).'MenuOption';
							$ins = new $classname;
							self::$list[] = $ins->process();
						}
					}
				}
				closedir($handle);
			}
		}
		return self::$list;		
	}
	
	public function process(){
		return array();
	}
	
	protected function concat($str,$n){
		$res = '';
		for($i=0; $i < $n; $i++){
			$res .= $str;
		}
		return $res;
	}
	
}
?>