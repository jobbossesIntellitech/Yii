<?php
class HelpController extends Scontroller{
	
	public function actionSave(){
		if(Jii::isAjax()){
			$c = Jii::param('c');
			$a = Jii::param('a');
			$data = Jii::param('data');
			$help = new Help($c,$a);
			$help->write($data);
			echo $help->content();
		}
	}
	
}
?>