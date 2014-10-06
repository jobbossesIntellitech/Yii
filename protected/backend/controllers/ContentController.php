<?php
class ContentController extends SController{
	public $family;
	public $categories;
	public $category;
	public function init(){
		parent::init();
		$this->family = 0;
		if(Jii::param('f') && Jii::param('f') > 0){
			$this->family = Jii::param('f');
		}
		$this->categories = Category::tree();
		$this->category = 0;
		if(Jii::param('c') && Jii::param('c') > 0){
			$this->category = Jii::param('c');
		}else{
			if(!empty($this->categories) && is_array($this->categories)){
				reset($this->categories);
				$this->category = key($this->categories);
			}
		}
	}

	public function actionIndex(){
		if(Jii::isAjax()){
			$criteria = new JDbGridView();
			$criteria->with = array('content_lang:'.Jii::app()->language,'comment');
			$criteria->addCondition('con_parentid = '.$this->family);
			$criteria->addCondition('con_categoryid = '.$this->category);
			echo $criteria->execute($this,'Content',array('f'=>$this->family,'c'=>$this->category),'list');
		}else{
			$this->pageTitle = Jii::t('Contents');
			Log::trace('Access Contents');
			$this->render('index');
		}	
	}

	public function actionAdd(){
		$this->pageTitle = Jii::t('Add New Content');
		$model = new ContentForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = new Content;
				$c->con_status = $model->status;
				$c->con_hascomments = $model->hascomments;
				$c->con_parentid = $model->parentid;
				$c->con_previd = $model->previd;
				$c->con_categoryid = $model->categoryid;
				$c->con_slug = Jii::slug($model->title);
				//$c->con_gallery = json_encode((!empty($model->gallery))?$model->gallery:array());
				$c->con_gallery = Content::correctGallery(json_encode((!empty($model->gallery))?$model->gallery:array()));
				$c->con_tags = json_encode((!empty($model->tags))?explode(',',$model->tags):array());
				$c->con_metatitle = $model->metatitle;
				$c->con_metadescription = $model->metadescription;
				$c->con_metakeywords = $model->metakeywords;
				$res = $c->save();
				Log::trace('Save new content record');
				if($res){
					$l = new ContentLang;
					$l->lng_title = $model->title;
					$l->lng_excerpt = $model->excerpt;
					$l->lng_text = $model->text;
					$l->lng_languageid = Jii::app()->language;
					$l->lng_contentid = $c->con_id;
					$l->save();
					Log::success('The content has been added successfully');	
				}else{
					Log::success('The content hasnt been added');	
				}
				$this->redirect(array('content/index','f'=>$this->family,'c'=>$this->category));	
			}else{
				Log::warning('Content form inputs error');
				$this->render('add',array('model'=>$model));		
			}
		}else{
			Log::trace('Access content form');
			$model->parentid = $this->family;
			$model->categoryid = $this->category;
			$this->render('add',array('model'=>$model));	
		}
	}

	public function actionEdit(){
		$this->pageTitle = Jii::t('Edit Content');
		$model = new ContentForm;
		Jii::ajaxValidation($model);
		if(Jii::param(get_class($model))){
			$model->attributes = Jii::param(get_class($model));
			if($model->validate()){
				$c = Content::model()->findByPk($model->id);
				$c->con_status = $model->status;
				$c->con_hascomments = $model->hascomments;
				$c->con_parentid = $model->parentid;
				$c->con_previd = $model->previd;
				$c->con_categoryid = $model->categoryid;
				$c->con_slug = Jii::slug($model->title);
				//$c->con_gallery = json_encode((!empty($model->gallery))?$model->gallery:array());
				$c->con_gallery = Content::correctGallery(json_encode((!empty($model->gallery))?$model->gallery:array()));
				$c->con_tags = json_encode((!empty($model->tags))?explode(',',$model->tags):array());
				$c->con_metatitle = $model->metatitle;
				$c->con_metadescription = $model->metadescription;
				$c->con_metakeywords = $model->metakeywords;
				$res = $c->save();
				Log::trace('Save content record');
				if($res){
					$l = ContentLang::model()->findByAttributes(array('lng_languageid'=>Jii::app()->language,'lng_contentid'=>$c->con_id));
					$l->lng_title = $model->title;
					$l->lng_excerpt = $model->excerpt;
					$l->lng_text = $model->text;
					$l->save();
					Log::success('The content has been edited successfully');	
				}else{
					Log::success('The content hasnt been edited');	
				}
				$this->redirect(array('content/index','f'=>$this->family,'c'=>$this->category));	
			}else{
				Log::warning('Content form inputs error');
				$this->render('edit',array('model'=>$model));		
			}
		}else{
			if(Jii::param('id')){
				Log::trace('Access content form');
				$c = Content::model()->with('content_lang:'.Jii::app()->language)->findByPk(Jii::param('id'));
				$model->id = $c->con_id;
				$model->status = $c->con_status;
				$model->hascomments = $c->con_hascomments;
				$model->parentid = $c->con_parentid;
				$model->previd = $c->con_previd;
				$model->categoryid = $c->con_categoryid;
				$model->gallery = json_decode($c->con_gallery);
				$model->tags = implode(',',json_decode($c->con_tags));
				$model->title = $c->content_lang->lng_title;
				$model->excerpt = $c->content_lang->lng_excerpt;
				$model->text = $c->content_lang->lng_text;
				$model->metatitle = $c->con_metatitle;
				$model->metadescription = $c->con_metadescription;
				$model->metakeywords = $c->con_metakeywords;
				$this->render('edit',array('model'=>$model));
			}else{
				Log::warning('Request lost required arguments, please try again');
				$this->redirect(array('content/index','f'=>$this->family,'c'=>$this->category));
			}	
		}
	}

	public function actionDelete(){
		Log::trace('Access delete content');
		$this->pageTitle = Jii::t('Delete Content');
		$c = Content::model()->findByPk(Jii::param('id'));
		if(isset($c->con_id)){
			$res = $c->delete();
			if($res){
				Log::success('The content has been deleted successfully');	
			}else{
				Log::error('The content hasnt been deleted');
			}	
		}else{
			Log::warning('Content not found');	
		}
		$this->redirect(array('content/index','f'=>$this->family,'c'=>$this->category));
	}

	public function actionStatus(){
		Log::trace('Access change status of content');
		$this->pageTitle = Jii::t('Change status of content');
		$c = Content::model()->findByPk(Jii::param('id'));
		if(isset($c->con_id)){
			$c->con_status = Jii::param('status');
			$res = $c->save();
			if($res){
				Log::success('The content has been changed status successfully');	
			}else{
				Log::error('The content hasnt been changed status');	
			}	
		}else{
			Log::warning('Content not found');	
		}
		$this->redirect(array('content/index','f'=>$this->family,'c'=>$this->category));	
	}
	
	public function actionHasComment(){
		Log::trace('Access change comments visibility of content');
		$this->pageTitle = Jii::t('Change comments visibility of content');
		$c = Content::model()->findByPk(Jii::param('id'));
		if(isset($c->con_id)){
			$c->con_hascomments = Jii::param('comment');
			$res = $c->save();
			if($res){
				Log::success('The content has been changed comments visibility successfully');	
			}else{
				Log::error('The content hasnt been changed comments visibility');	
			}	
		}else{
			Log::warning('Content not found');	
		}
		$this->redirect(array('content/index','f'=>$this->family,'c'=>$this->category));	
	}
	
	public function actionTranslate(){
		if(Jii::param('id')){
			Log::trace('Access translate content');	
			$this->pageTitle = Jii::t('Translate content');
			$languages = Language::without(Jii::app()->language);
			if(Jii::param('language')){
				$language = Jii::param('language');
			}else{
				reset($languages);
				$language = key($languages);
			}
			$l = ContentLang::model()->findByAttributes(array('lng_languageid'=>Jii::app()->language,'lng_contentid'=>Jii::param('id')));
			$model = new ContentForm;
			Jii::ajaxValidation($model);
			if(Jii::param(get_class($model))){
				$model->attributes = Jii::param(get_class($model));
				if($model->validate()){
					$c = ContentLang::model()->findByAttributes(array('lng_languageid'=>$language,'lng_contentid'=>Jii::param('id')));
					if(!isset($c->lng_id)){
						$c = new ContentLang;
						$c->lng_languageid = $language;
						$c->lng_contentid = Jii::param('id');
					}
					$c->lng_title = $model->title;
					$c->lng_excerpt = $model->excerpt;
					$c->lng_text = $model->text;
					$c->save();
					Log::success('The content translation has been saved successfully');	
				}
			}else{
				$s = ContentLang::model()->findByAttributes(array('lng_languageid'=>$language,'lng_contentid'=>Jii::param('id')));
				if(isset($s->lng_id)){
					$model->title = $s->lng_title;
					$model->excerpt = $s->lng_excerpt;
					$model->text = $s->lng_text;					
				}
			}
			$this->render('translate',array('model'=>$model,'language'=>$language,'languages'=>$languages,'l'=>$l));
		}else{
			Log::warning('Content not found');
			$this->redirect(array('content/index','f'=>$this->family,'c'=>$this->category));	
		}
	}	
}
?>