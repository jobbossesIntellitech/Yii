<?php
class FacebookShortCode extends JShortCode{
	
	private static $root = NULL;
	
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['attr']['action'] = 'like,send,follow,comments,share,activity,facepile';
		self::$documentation[$this->getName()]['attr']['send'] = 'true,false';
		self::$documentation[$this->getName()]['attr']['faces'] = 'true,false';
		self::$documentation[$this->getName()]['attr']['layout'] = 'standard,button_count,box_count';
		self::$documentation[$this->getName()]['attr']['width'] = 'Integer number : 450 ,...';
		self::$documentation[$this->getName()]['attr']['height'] = 'Integer Number : 300 ,...';
		self::$documentation[$this->getName()]['attr']['posts'] = 'Posts number in comments : 10 ,...';
		self::$documentation[$this->getName()]['attr']['username'] = 'account username';
		self::$documentation[$this->getName()]['attr']['header'] = 'true,false';
		self::$documentation[$this->getName()]['attr']['target'] = '_blank,_top,_parent';
		self::$documentation[$this->getName()]['attr']['recommendation'] = 'true,false';
		self::$documentation[$this->getName()]['attr']['rows'] = 'Integer rows number 1,2,3,...';
		self::$documentation[$this->getName()]['attr']['size'] = 'small,medium,large';
		self::$documentation[$this->getName()]['attr']['appid'] = 'Application id';
		self::$documentation[$this->getName()]['attr']['list'] = 'A comma separated list of actions';
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().' (name="value" ...) /]';
		self::$documentation[$this->getName()]['description'] = 'Facebook Plugins';
	}
	
	private function curPageURL() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	private function domain() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		$pageURL .= $_SERVER["SERVER_NAME"];
		return $pageURL;
	}
	
	public function process(){
			$actions = array('like','send','follow','comments','share','activity','facepile');
			extract($this->fillDefault(array(
				'action'=>NULL,
				'send'=>'true',
				'faces'=>'true',
				'layout'=>'standard',
				'width'=>'450',
				'posts'=>'10',
				'username'=>'',
				'height'=>'300',
				'header'=>'true',
				'target'=>'_blank',
				'recommendation'=>'false',
				'rows'=>'5',
				'size'=>'medium', // small, medium, large
				'appid'=>'',
				'list'=>'og_runkeeper:run',
			)));
			if(self::$root == NULL){
				self::$root = '<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=460241200712807";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, "script", "facebook-jssdk"));</script>';
			}
			if(!empty($action) && in_array($action,$actions)){
				$html = self::$root;
				switch($action){
					case 'like':
						$html .= $this->getLike($width,$layout,$send,$faces);
					break;
					case 'send':
						$html .= $this->getSend();
					break;
					case 'follow':
						$html .= $this->getFollow($username,$width,$layout,$faces);
					break;
					case 'comments':
						$html .= $this->getComments($width,$posts);
					break;
					case 'share':
						$html .= $this->getShare();
					break;
					case 'activity':
						$html .= $this->getActivity($width,$height,$header,$target,$recommendation,$appid,$list);
					break;
					case 'facepile':
						$html .= $this->getFacepile($username,$width,$rows,$size,$appid,$list);
					break;
				}
				
				return $html;
			}
			return '';			
		
	}
	
	private function getLike($width,$layout,$send,$faces){
		return '<div class="fb-like" data-href="'.$this->curPageURL().'" data-send="'.$send.'" data-width="'.$width.'" data-show-faces="'.$faces.'" data-layout="'.$layout.'"></div>';
	}
	
	private function getSend(){
		return '<div class="fb-send" data-href="'.$this->curPageURL().'"></div>';
	}
	
	private function getFollow($username,$width,$layout,$faces){
		return '<div class="fb-follow" data-href="https://www.facebook.com/'.$username.'" data-show-faces="'.$faces.'" data-width="'.$width.'" data-layout="'.$layout.'"></div>';
	}
	
	private function getComments($width,$posts){
		return '<div class="fb-comments" data-href="'.$this->curPageURL().'" data-width="'.$width.'" data-num-posts="'.$posts.'"></div>';
	}
	
	private function getShare(){
		return '<a href="javascript://" class="fb-chare" 
					  onclick="
						window.open(
						  \'https://www.facebook.com/sharer/sharer.php?u=\'+encodeURIComponent(\''.$this->curPageURL().'\'), 
						  \'facebook-share-dialog\', 
						  \'width=626,height=436\'); 
						return false;">
					  Share on Facebook
					</a>';
	}
	
	private function getActivity($width,$height,$header,$target,$recommendation,$appid,$list){
		return '<div class="fb-activity" data-width="'.$width.'" data-height="'.$height.'" data-header="'.$header.'" data-linktarget="'.$target.'" data-recommendations="'.$recommendation.'" data-site="'.$this->domain().'" data-app-id="'.$appid.'" data-action="'.$list.'"></div>';
	}
	
	private function getFacepile($username,$width,$rows,$size,$appid,$list){
		return '<div class="fb-facepile" data-href="http://facebook.com/'.$username.'" data-max-rows="'.$rows.'" data-width="'.$width.'" data-size="'.$size.'" data-app-id="'.$appid.'" data-action="'.$list.'"></div>';
	}
}
?>