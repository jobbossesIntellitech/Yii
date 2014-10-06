<?php
class SController extends VController{
	public $layout = 'main';
	public function init(){
		parent::init();
		if(Jii::app()->user->isGuest){
			$this->redirect(array('authentication/logout'));	
		}
		Jii::permissions();		
	}

	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules(){
		if(Yii::app()->user->id > 1){
			$permission = array();
			$permissions = Jii::getPermissions();
			if(!empty($permissions) && is_array($permissions)){
				foreach($permissions AS $c=>$actions){
					if(!empty($actions) && is_array($actions)){
						foreach($actions AS $a=>$id){
							$permission[] = $a;	
						}
					}
				}
			}
			if(empty($permission)){
				$member = array('deny',  // deny all users to perform 'list' and 'show' actions
					'users'=>array('@'),
					'actions'=>$permission,
					);
			}else{
				$member = array('allow',  // allow all users to perform 'list' and 'show' actions
					'users'=>array('@'),
					'actions'=>$permission,
					);
			}
		}else{
			$member = array('allow',  // allow all users to perform 'list' and 'show' actions
				'users'=>array('@'),
				);
		}
		return array(
			$member,
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	
}
?>