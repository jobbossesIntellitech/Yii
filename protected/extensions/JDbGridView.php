<?php
class JDbGridView extends CDbCriteria
{
	public function execute($controller,$class,$param = array(),$view = 'list'){
		if(isset($_POST['orderBy']) && $_POST['orderPosition']){
			$this->order = $_POST['orderBy']." ".$_POST['orderPosition'];
		}
		if($_POST['f_key'] != '' && $_POST['f_value'] != ''){
			$this->addCondition($_POST['f_key'].' LIKE "'.$_POST['f_value'].'"');	
		}
		$pages = new CPagination(call_user_func(array($class,'model'))->count($this));
		if(isset($_POST['page']) && $_POST['page'] > 0){
			$pages -> setCurrentPage($_POST['page']-1);
		}
		$pages -> pageSize = $_POST['pageSize'];
		$pages -> applyLimit($this);
		$pages -> params = $param;
		$list =  call_user_func(array($class,'model'))->findAll($this);
		$html  = $controller->widget('wBegin',array('headers'=>$_POST['headers']),true);
		$html .= $controller->renderPartial($view,array('list'=>$list),true,true);
		$html .= $controller->widget('wEnd',array('pages'=>$pages),true);
		return $html;	
	}	
}
?>