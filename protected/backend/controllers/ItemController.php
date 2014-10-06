<?php
class ItemController extends SController{
	public $family;
	public function init(){
		parent::init();
		$this->family = 0;
		if(Jii::param('f') && Jii::param('f') > 0){
			$this->family = Jii::param('f');
		}
	}

	public function actionIndex(){
		if(Jii::isAjax()){
			$criteria = new JDbGridView();
			$criteria->addCondition('itm_parentid = '.$this->family);
			echo $criteria->execute($this,'Item',array('f'=>$this->family,'uws'=>Jii::param('uws')),'list');
		}else{
			$this->pageTitle = Jii::t('Items');
			Log::trace('Access Items');
			$this->render('index');
		}
	}

	public function actionAdd(){
		$this->pageTitle = Jii::t('Add New Item');
		$model = new ItemForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				/*echo '<pre>';
				print_r($model);
				print_r($_POST);
				echo '</pre>';
				exit();*/
				$c = new Item;
				$c->itm_name = $model->name;
				$c->itm_status = $model->status;
				$c->itm_parentid = $model->parentid;
				$c->itm_position = $model->position;
				//$c->itm_options = $model->options;
				$c->itm_type = $model->type;
				$c->itm_formid = $model->formid;
				$c->itm_translate = json_encode($model->translate);
				$res = $c->save();

				/*for ($i=0; $i < count($_POST['field-name']); $i++) { 
					$f = new ItemField;
					$f->ifl_name = $_POST['field-name'][$i];
					$f->ifl_defaultvalue = $_POST['default-value'][$i];
					$f->ifl_itemid = $c->itm_id;
					$f->ifl_position = $_POST['field-pos'][$i];
					$f->save();
				}*/

				Log::trace('Save new item record');
				if($res){
					Log::success('The item has been added successfully');	
				}else{
					Log::success('The item hasnt been added');	
				}
				$this->redirect(array('item/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
			}else{
				Log::warning('Item form inputs error');
				$this->render('add',array('model'=>$model,'uws'=>Jii::param('uws')));		
			}
		}else{
			Log::trace('Access item form');
			$model->parentid = $this->family;
			$this->render('add',array('model'=>$model));	
		}
	}

	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit Item');
		$model = new ItemForm;
		Jii::ajaxValidation($model);

		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			
			if($model->validate()){
				$c = Item::model()->findByPk($model->id);

				$c->itm_name		= $model->name;
				$c->itm_status		= $model->status;
				$c->itm_parentid	= $model->parentid;
				$c->itm_position	= $model->position;
				//$c->itm_options		= $model->options;
				$c->itm_type = $model->type;
				$c->itm_formid = $model->formid;
				$c->itm_translate 	= json_encode($model->translate);
				
				/*for ($i=0; $i < count($_POST['fields']); $i++) {
					if(isset($_POST['field-deleted'][$i]) && !empty($_POST['field-deleted'][$i]) ){
						if($_POST['field-deleted'][$i] == 'true'){
							$f = ItemField::model()->findByPk($_POST['field-id'][$i]);
							if(isset($f->ifl_id)){
								$res = $f->delete();
							}
						}else{
							$f = ItemField::model()->findByPk($_POST['field-id'][$i]);
							$f->ifl_name = $_POST['field-name'][$i];
							$f->ifl_defaultvalue = $_POST['default-value'][$i];
							$f->ifl_itemid = $c->itm_id;
							$f->ifl_position = $_POST['field-pos'][$i];
							$f->save();
						}
					}else{
						$f = new ItemField;
						$f->ifl_name = $_POST['field-name'][$i];
						$f->ifl_defaultvalue = $_POST['default-value'][$i];
						$f->ifl_itemid = $c->itm_id;
						$f->ifl_position = $_POST['field-pos'][$i];
						$f->save();
					}
				}*/

				$res = $c->save();
				Log::trace('Saved item record');
				if($res){
					Log::success('The item has been edited successfully');	
				}else{
					Log::success('The item hasnt been edited');	
				}
				$this->redirect(array('item/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
			}else{
				Log::warning('Item form inputs error');
				$this->render('edit',array('model'=>$model));		
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access item form');
				$c = Item::model()->findByPk(Jii::param('id'));
				$model->id = $c->itm_id;
				$model->name = $c->itm_name;
				$model->status = $c->itm_status;
				$model->parentid = $c->itm_parentid;
				$model->position = $c->itm_position;
				$model->options = $c->itm_options;
				$model->type = $c->itm_type;
				$model->formid = $c->itm_formid;
				$model->translate = (array)json_decode($c->itm_translate);
				/*echo '<pre>';
				print_r($model);
				echo '</pre>';
				exit();*/
				/*criteria = new JDbGridView();
				$criteria->addCondition('ifl_itemid = '.Jii::param('id'));
				$f = ItemField::model()->findAll($criteria);*/
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('item/index','f'=>$this->family,'uws'=>Jii::param('uws')));		
			}	
		}
	}

	public function actionDelete(){
		Log::trace('Access delete item');
		$this->pageTitle = Jii::t('Delete Item');
		$c = Item::model()->findByPk(Jii::param('id'));
		if(isset($c->itm_id)){
			$res = $c->delete();
			if($res){
				Log::success('The item has been deleted successfully');	
			}else{
				Log::error('The item hasnt been deleted');	
			}	
		}else{
			Log::warning('Item not found');	
		}
		$this->redirect(array('item/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
	}

	public function actionStatus(){
		Log::trace('Access change status of item');
		$this->pageTitle = Jii::t('Change status of item');
		$c = Item::model()->findByPk(Jii::param('id'));
		if(isset($c->itm_id)){
			$c->itm_status = Jii::param('status');
			$res = $c->save();
			if($res){
				Log::success('The item has been changed status successfully');	
			}else{
				Log::error('The item hasnt been changed status');	
			}	
		}else{
			Log::warning('Item not found');	
		}
		$this->redirect(array('item/index','f'=>$this->family,'uws'=>Jii::param('uws')));	
	}
	
}
?>