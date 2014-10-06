<?php
class Layout{
	
	public static function buildContainer($content,$class){
		$res = '
        <div class="outer-'.$class.'">
        	<div class="inner-'.$class.'">
			';
			if(is_array($content) && !empty($content)){
				foreach($content AS $c){
					$res .= $c;	
				}	
			}else{
				$res .= $content;	
			}
		$res .= '		
            </div>
        </div>
       	';
		return $res;		
	}
	public static function bloc($content){
		return self::buildContainer($content,'bloc');		
	}
			
}
?>