<?php
class wMenu extends CWidget{
	public $hook = 'main';
	public function init(){
		parent::init();
	}
	public function run(){
		$menu = Menu::get($this->hook);
		$this->render('vMenu',array('menu'=>$menu));
	}
	
	public function tree($menu,$first = true){
		$h = '';
		if(isset($menu) && is_array($menu) && !empty($menu)){
			$child = (!$first)?'class="child"':'';
			$h .= '<ul '.$child.'>';
			foreach($menu AS $k=>$m){
				$inline = ($first && $k == 0)?'style="display: inline !important;"':'';
				$parent = 'class="parent"';
				$target = ($m['target'] == 0)?'':'target="'.MenuField::target()->getKeyByValue($m['target']).'"';
				$h .= '<li '.$inline.' '.$parent.'>';
					$h .= '<a href="'.$m['url'].'" '.$target.'>'.$m['label'].'</a>';
					$h .= $this->tree($m['children'],false);
				$h .= '</li>';
			}
			$h .= '</ul>';
		}
		return $h;
	}
}
?>