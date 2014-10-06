<?php
class CategoryController extends SController{
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
			$criteria->with = array('category_lang:'.Jii::app()->language);
			$criteria->addCondition('cat_parentid = '.$this->family);
			echo $criteria->execute($this,'Category',array('f'=>$this->family),'list');
		}else{
			$this->pageTitle = Jii::t('Categories');
			Log::trace('Access Categories');
			$this->render('index');
		}
	}

	public function actionAdd(){
		$this->pageTitle = Jii::t('Add New Category');
		$model = new CategoryForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = new Category;
				$c->cat_status = $model->status;
				$c->cat_parentid = $model->parentid;
				$c->cat_slug = Jii::slug($model->name);
				$res = $c->save();
				Log::trace('Save new category record');
				if($res){
					$l = new CategoryLang;
					$l->lng_name = $model->name;
					$l->lng_description = $model->description;
					$l->lng_languageid = Jii::app()->language;
					$l->lng_categoryid = $c->cat_id;
					$l->save();
					Log::success('The category has been added successfully');	
				}else{
					Log::success('The category hasnt been added');	
				}
				$this->redirect(array('category/index','f'=>$this->family));	
			}else{
				Log::warning('Category form inputs error');
				$this->render('add',array('model'=>$model));		
			}
		}else{
			Log::trace('Access category form');
			$model->parentid = $this->family;
			$this->render('add',array('model'=>$model));	
		}
	}

	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit Category');
		$model = new CategoryForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = Category::model()->findByPk($model->id);
				$c->cat_status = $model->status;
				$c->cat_parentid = $model->parentid;
				$c->cat_slug = Jii::slug($model->name);
				$res = $c->save();
				Log::trace('Saved category record');
				if($res){
					$l = CategoryLang::model()->findByAttributes(array('lng_languageid'=>Jii::app()->language,'lng_categoryid'=>$c->cat_id));
					$l->lng_name = $model->name;
					$l->lng_description = $model->description;
					$l->save();
					Log::success('The category has been edited successfully');	
				}else{
					Log::success('The category hasnt been edited');	
				}
				$this->redirect(array('category/index','f'=>$this->family));	
			}else{
				Log::warning('Category form inputs error');
				$this->render('edit',array('model'=>$model));		
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access category form');
				$c = Category::model()->with('category_lang:'.Jii::app()->language)->findByPk(Jii::param('id'));
				$model->id = $c->cat_id;
				$model->status = $c->cat_status;
				$model->parentid = $c->cat_parentid;
				$model->name = $c->category_lang->lng_name;
				$model->description = $c->category_lang->lng_description;
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('category/index','f'=>$this->family));		
			}	
		}
	}

	public function actionDelete(){
		Log::trace('Access delete category');
		$this->pageTitle = Jii::t('Delete Category');
		$c = Category::model()->findByPk(Jii::param('id'));
		if(isset($c->cat_id)){
			$res = $c->delete();
			if($res){
				Log::success('The category has been deleted successfully');	
			}else{
				Log::error('The category hasnt been deleted');	
			}	
		}else{
			Log::warning('Category not found');	
		}
		$this->redirect(array('category/index','f'=>$this->family));	
	}

	public function actionStatus(){
		Log::trace('Access change status of category');
		$this->pageTitle = Jii::t('Change status of category');
		$c = Category::model()->findByPk(Jii::param('id'));
		if(isset($c->cat_id)){
			$c->cat_status = Jii::param('status');
			$res = $c->save();
			if($res){
				Log::success('The category has been changed status successfully');	
			}else{
				Log::error('The category hasnt been changed status');	
			}	
		}else{
			Log::warning('Category not found');	
		}
		$this->redirect(array('category/index','f'=>$this->family));	
	}
	
	public function actionTranslate(){
		if(Jii::param('id')){
			Log::trace('Access translate category');	
			$this->pageTitle = Jii::t('Translate category');
			$languages = Language::without(Jii::app()->language);
			if(Jii::param('language')){
				$language = Jii::param('language');
			}else{
				reset($languages);
				$language = key($languages);
			}
			$l = CategoryLang::model()->findByAttributes(array('lng_languageid'=>Jii::app()->language,'lng_categoryid'=>Jii::param('id')));
			$model = new CategoryForm;
			Jii::ajaxValidation($model);
			if(Jii::param(get_class($model))){
				$model->attributes = Jii::param(get_class($model));
				if($model->validate()){
					$c = CategoryLang::model()->findByAttributes(array('lng_languageid'=>$language,'lng_categoryid'=>Jii::param('id')));
					if(!isset($c->lng_id)){
						$c = new CategoryLang;
						$c->lng_languageid = $language;
						$c->lng_categoryid = Jii::param('id');
					}
					$c->lng_name = $model->name;
					$c->lng_description = $model->description;
					$c->save();
					Log::success('The category translation has been saved successfully');	
				}
			}else{
				$s = CategoryLang::model()->findByAttributes(array('lng_languageid'=>$language,'lng_categoryid'=>Jii::param('id')));
				if(isset($s->lng_id)){
					$model->name = $s->lng_name;
					$model->description = $s->lng_description;	
				}
			}
			$this->render('translate',array('model'=>$model,'language'=>$language,'languages'=>$languages,'l'=>$l));
		}else{
			Log::warning('Category not found');
			$this->redirect(array('category/index','f'=>$this->family));	
		}
	}
}
?>