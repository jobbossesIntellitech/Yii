<?php
class UserController extends SController{
	
	public $family;
	public function init(){
		parent::init();
		$this->family = Jii::app()->user->id;
		if(Jii::param('f') && Jii::param('f') != ''){
			$this->family = Jii::param('f');	
		}	
	}
	
	public function actionIndex(){
		if(Jii::isAjax()){
			Log::trace('Access Users List');
			$criteria = new JDbGridView;
			$criteria->addCondition('usr_parent = '.$this->family);
			echo $criteria->execute($this,'User',array('f'=>$this->family),'list');	
		}else{
			Log::trace('Access Users Page');
			$this->pageTitle = Jii::t('Manage Users');
			$this->render('index');	
		}		
	}
	
	public function actionAdd(){
		$this->pageTitle = Jii::t('Add new user');
		$model = new UserForm;
		$model->setScenario('create');
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$u = new User;
				$u->usr_image = isset($model->image[0])?$model->image[0]:Jii::notfound();
				$u->usr_firstname = $model->firstname;
				$u->usr_lastname = $model->lastname;
				$u->usr_username = $model->username;
				$password = new Password($model->password);
				$u->usr_password = $password->getHash();
				$u->usr_saltpassword = $password->getSalt();
				$u->usr_status = $model->status;
				$u->usr_color = $model->color;
				$u->usr_parent = $model->parent;
				$res = $u->save();
				$u->setPrimaryKey($u->primaryKey);
				Log::trace('Save User');
				if($res){
					Log::success('The user has been added successfully');
				}else{
					Log::error('The user hasnt been added');	
				}
				$this->redirect(array('user/index','f'=>$this->family));		
			}else{
				$this->render('add',array('model'=>$model));	
			}
 		}else{
			Log::trace('Open user form');
			$model->parent = $this->family;
			$model->color = Jii::app()->user->color;
			$this->render('add',array('model'=>$model));
		}
	}
	
	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit user');
		$model = new UserForm;
		$model->setScenario('update');
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$u = User::model()->findByPk($model->id);
				$u->usr_image = isset($model->image[0])?$model->image[0]:Jii::notfound();
				$u->usr_firstname = $model->firstname;
				$u->usr_lastname = $model->lastname;
				$u->usr_username = $model->username;
				if(!empty($model->password)){
					$password = new Password($model->password);
					$u->usr_password = $password->getHash();
					$u->usr_saltpassword = $password->getSalt();
				}
				$u->usr_status = $model->status;
				$u->usr_color = $model->color;
				$u->usr_parent = $model->parent;
				$res = $u->save();
				$u->setPrimaryKey($u->primaryKey);
				Log::trace('Save User');
				if($res){
					Log::success('The user has been edited successfully');
				}else{
					Log::error('The user hasnt been edited');	
				}
				$this->redirect(array('user/index','f'=>$this->family));		
			}else{
				$this->render('edit',array('model'=>$model));	
			}
 		}else{
			Log::trace('Open user form');
			if(Jii::param('id')){
				$u = User::model()->findByPk(Jii::param('id'));
				$model->id = $u->usr_id;
				$model->username = $u->usr_username;
				$model->firstname = $u->usr_firstname;
				$model->lastname = $u->usr_lastname;
				$model->status = $u->usr_status;
				$model->color = $u->usr_color;
				$model->parent = $u->usr_parent;
				$model->image = array($u->usr_image);
				$this->render('edit',array('model'=>$model));
			}else{
				$this->redirect(array('user/index','f'=>$this->family));		
			}
		}
	}
	
	public function actionDelete(){
		Log::trace('Access delete user');
		$this->pageTitle = Jii::t('Delete User');
		$user = User::model()->findByPk(Jii::param('id'));
		if(isset($user->usr_id)){
			$res = $user->delete();
			if($res){
				Log::success('The user has been deleted successfully');	
			}else{
				Log::error('The user hasnt been deleted');	
			}	
		}else{
			Log::warning('User not found');	
		}
		$this->redirect(array('user/index','f'=>$this->family));	
	}
	
	public function actionStatus(){
		Log::trace('Access change status of user');
		$this->pageTitle = Jii::t('Change status of user');
		$user = User::model()->findByPk(Jii::param('id'));
		if(isset($user->usr_id)){
			$user->usr_status = Jii::param('status');
			$res = $user->save();
			if($res){
				Log::success('The user has been changed status successfully');	
			}else{
				Log::error('The user hasnt been changed status');	
			}	
		}else{
			Log::warning('User not found');	
		}
		$this->redirect(array('user/index','f'=>$this->family));		
	}
	
	public function actionPermission(){
		Log::trace('Access permission of user');
		$this->pageTitle = Jii::t('Permission of user');
		if(Jii::param('save')){
			$permission = Jii::param('permission');
			PermissionTable::model()->deleteAllByAttributes(array('permission_userid'=>Jii::param('id')));
			Log::trace('Delete old permissions of user');
			if(!empty($permission) && is_array($permission)){
				foreach($permission AS $controller => $actions){
					if(!empty($actions) && is_array($actions)){
						foreach($actions AS $action=>$user){
							$p = new PermissionTable;
							$p->permission_userid = $user;
							$p->permission_controllerid = $controller;
							$p->permission_actionid = $action;
							$res = $p->save();
							if($res){
								Log::trace('Insert new permission');
							}else{
								Log::trace('Insert new permission failed');		
							}
						}	
					}		
				}
				Log::success('Permission of user has been added successfully');	
			}else{
				Log::warning('Permission of user hasnt been added');		
			}
			$this->redirect(array('user/index','f'=>$this->family));			
		}else{
			$criteria = new CDbCriteria;
			$criteria->addCondition('permission_userid = '.Jii::param('id'));
			$permissions = PermissionTable::model()->findAll($criteria);
			$permission = array();
			if(!empty($permissions) && is_array($permissions)){
				foreach($permissions AS $p){
					$permission[$p->permission_actionid] = true;		
				}	
			}
			$criteria = new CDbCriteria;
			if($this->family > 1){
				$criteria->with = array(
					'actiontable'=>array(
						'with'=>array(
							'permission'=>array(
								'with'=>array(
									'user'=>array(
										'condition'=>'usr_id = '.$this->family
									)
								)
							)
						)
					)
				);
			}else{
				$criteria->with = array('actiontable');		
			}
			$controllers = ControllerTable::model()->findAll($criteria);

			$this->render('permission',array('controllers'=>$controllers,'permission'=>$permission));			
		}
				
	}
			
}
?>