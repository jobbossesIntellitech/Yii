<?php
class MaintenanceController extends Controller{
	
	public $layout = 'maintenance';
	
	public function actionIndex(){
		if(Setting::get('maintenance','mode') == 'on'){
			$this->pageTitle = Jii::t('Maintenance');
			$this->render('index');
		}else{
			$this->redirect(array('web/index'));
		}
	}
	
}
?>