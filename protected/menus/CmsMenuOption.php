<?php
class CmsMenuOption extends JMenuOption{
	public function process(){
		$list = array('title'=>Jii::t('CMS'),'list'=>array());
		$categories = Category::tree();
		if(!empty($categories) && is_array($categories)){
			foreach($categories AS $k=>$v){
				$v = str_replace('|---',$this->concat('&nbsp;',6),$v);
				$i = count($list['list']);
				$list['list'][$i] = array();
				$list['list'][$i]['label'] = $v.' <sup><i>category</i></sup>';
				$list['list'][$i]['link'] = Jii::app()->createUrl('cms/category',array('id'=>$k));
				
				$contents = Content::tree($k);
				if(!empty($contents) && is_array($contents)){
					foreach($contents AS $kk=>$vv){
						$vv = str_replace('|---',$this->concat('&nbsp;',6),$vv);
						$sep = substr_count($v,$this->concat('&nbsp;',6));
						$sep = $this->concat('&nbsp;',(6*$sep)+6);
						$i = count($list['list']);
						$list['list'][$i] = array();
						$list['list'][$i]['label'] = $sep.$vv;
						$list['list'][$i]['link'] = Jii::app()->createUrl('cms/view',array('id'=>$kk));
					}
				}
			}
		}
		return $list;
	}	
}
?>