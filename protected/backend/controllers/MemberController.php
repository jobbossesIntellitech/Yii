<?php
class MemberController extends SController{
	
	public function init(){
		parent::init();
	}
	
	public function actionIndex(){
		if(Jii::isAjax()){
			Log::trace('Access Members List');
			$criteria = new JDbGridView;
			echo $criteria->execute($this,'Member',array(),'list');	
		}else{
			Log::trace('Access Members Page');
			$this->pageTitle = Jii::t('Manage Members');
			$this->render('index');	
		}		
	}
	
	public function actionAdd(){
		$this->pageTitle = Jii::t('Add new Member');
		$model = new MemberForm;
		$model->setScenario('create');
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$u = new Member;
				$u->mbr_image = isset($model->image[0])?$model->image[0]:Jii::notfound();
				$u->mbr_firstname = $model->firstname;
				$u->mbr_lastname = $model->lastname;
				$u->mbr_username = $model->username;
				$u->mbr_email = $model->email;
				$password = new Password($model->password);
				$u->mbr_hashpassword = $password->getHash();
				$u->mbr_saltpassword = $password->getSalt();
				$u->mbr_gender = $model->gender;
				$u->mbr_phone = $model->phone;
				$u->mbr_locationid = $model->locationid;
				$u->mbr_status = $model->status;
				$res = $u->save();
				$u->setPrimaryKey($u->primaryKey);
				if(!is_dir(Jii::app()->basePath.'/../../assets/uploads/')){
					mkdir(Jii::app()->basePath.'/../../assets/uploads/',0777);	
				}
				if(!is_dir(Jii::app()->basePath.'/../../assets/uploads/members/')){
					mkdir(Jii::app()->basePath.'/../../assets/uploads/members/',0777);	
				}
				Log::trace('Save Member');
				if($res){
					if(isset($_FILES["MemberForm"]["name"]["image"]) && !empty($_FILES["MemberForm"]["name"]["image"])){
						$info = pathinfo($_FILES["MemberForm"]["name"]["image"]);
						$newname = time().'_'.round(rand()*10000).'.'.$info['extension'];
						$success = move_uploaded_file($_FILES["MemberForm"]["tmp_name"]["image"], Jii::app()->basePath.'/../../assets/uploads/members/'.$newname);
						if($success){
							$u->mbr_image = $newname;
							$res = $u->save();
							Log::success('The member has been added successfully');
						}
					}
					Log::success('The member has been added successfully');
				}else{
					Log::error('The member hasnt been added');	
				}
				$this->redirect(array('member/index'));		
			}else{
				$this->render('add',array('model'=>$model));	
			}
 		}else{
			Log::trace('Open member form');
			$this->render('add',array('model'=>$model));
		}
	}
	
	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit member');
		$model = new MemberForm;
		$model->setScenario('update');
		$this->ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$u = Member::model()->findByPk($model->id);
				$u->mbr_image = $model->image;
				$u->mbr_firstname = $model->firstname;
				$u->mbr_lastname = $model->lastname;
				$u->mbr_username = $model->username;
				$u->mbr_email = $model->email;
				if(!empty($model->password)){
					$password = new Password($model->password);
					$u->mbr_hashpassword = $password->getHash();
					$u->mbr_saltpassword = $password->getSalt();
				}
				$u->mbr_gender = $model->gender;
				$u->mbr_phone = $model->phone;
				$u->mbr_locationid = $model->locationid;
				$u->mbr_status = $model->status;
				$res = $u->save();
				$u->setPrimaryKey($u->primaryKey);
				if(!is_dir(Jii::app()->basePath.'/../../assets/uploads/')){
					mkdir(Jii::app()->basePath.'/../../assets/uploads/',0777);	
				}
				if(!is_dir(Jii::app()->basePath.'/../../assets/uploads/members/')){
					mkdir(Jii::app()->basePath.'/../../assets/uploads/members/',0777);	
				}
				Log::trace('Save Member');
				if($res){
					if(isset($_FILES["MemberForm"]["name"]["image"]) && !empty($_FILES["MemberForm"]["name"]["image"])){
						$info = pathinfo($_FILES["MemberForm"]["name"]["image"]);
						$newname = time().'_'.round(rand()*10000).'.'.$info['extension'];
						$success = move_uploaded_file($_FILES["MemberForm"]["tmp_name"]["image"], Jii::app()->basePath.'/../../assets/uploads/members/'.$newname);
						if($success){
							$u->mbr_image = $newname;
							$res = $u->save();
							Log::success('The member has been added successfully');
						}
					}
					Log::success('The member has been edited successfully');
				}else{
					Log::error('The member hasnt been edited');	
				}
				$this->redirect(array('member/index'));		
			}else{
				$this->render('edit',array('model'=>$model));	
			}
 		}else{
			Log::trace('Open member form');
			if(Jii::param('id')){
				$u = Member::model()->findByPk(Jii::param('id'));
				$model->id = $u->mbr_id;
				$model->username = $u->mbr_username;
				$model->email = $u->mbr_email;
				$model->firstname = $u->mbr_firstname;
				$model->lastname = $u->mbr_lastname;
				$model->status = $u->mbr_status;
				$model->gender = $u->mbr_gender;
				$model->phone = $u->mbr_phone;
				$model->locationid = $u->mbr_locationid;
				$model->image = $u->mbr_image;
				$this->render('edit',array('model'=>$model));
			}else{
				$this->redirect(array('member/index'));		
			}
		}
	}
	
	public function actionDelete(){
		Log::trace('Access delete member');
		$this->pageTitle = Jii::t('Delete Member');
		$member = Member::model()->findByPk(Jii::param('id'));
		if(isset($member->mbr_id)){
			$res = $member->delete();
			if($res){
				Log::success('The member has been deleted successfully');	
			}else{
				Log::error('The member hasnt been deleted');	
			}	
		}else{
			Log::warning('Member not found');	
		}
		$this->redirect(array('member/index'));	
	}
	
	public function actionStatus(){
		Log::trace('Access change status of member');
		$this->pageTitle = Jii::t('Change status of member');
		$member = Member::model()->findByPk(Jii::param('id'));
		if(isset($member->mbr_id)){
			$member->mbr_status = Jii::param('status');
			$res = $member->save();
			if($res){
				Log::success('The member has been changed status successfully');	
			}else{
				Log::error('The member hasnt been changed status');	
			}	
		}else{
			Log::warning('Member not found');	
		}
		$this->redirect(array('member/index'));		
	}
	
}
?>