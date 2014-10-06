<?php
class CommentController extends SController{
	
	public $category;
	public $categories;
	public $content;
	public $contents;
	
	public function init(){
		parent::init();
		$this->categories = Category::tree();
		$this->category = 0;
		if(Jii::param('c1') && Jii::param('c1') > 0){
			$this->category = Jii::param('c1');
		}else{
			if(!empty($this->categories) && is_array($this->categories)){
				reset($this->categories);
				$this->category = key($this->categories);
			}
		}
		$this->contents = Content::tree($this->category);
		$this->content = 0;
		if(Jii::param('c2') && Jii::param('c2') > 0){
			$this->content = Jii::param('c2');
		}else{
			if(!empty($this->contents) && is_array($this->contents)){
				reset($this->contents);
				$this->content = key($this->contents);
			}
		}
	}
	
	public function actionIndex(){
		if(Jii::isAjax()){
			$criteria = new JDbGridView();
			$criteria->addCondition('com_contentid = '.$this->content);
			echo $criteria->execute($this,'Comment',array('c1'=>$this->category,'c2'=>$this->content),'list');
		}else{
			$this->pageTitle = Jii::t('Comments');
			Log::trace('Access Comments');
			$this->render('index');
		}
	}
	
	public function actionStatus(){
		Log::trace('Access change status of comment');
		$this->pageTitle = Jii::t('Change status of comment');
		$c = Comment::model()->findByPk(Jii::param('id'));
		if(isset($c->com_id)){
			$c->com_status = Jii::param('status');
			$res = $c->save();
			if($res){
				Log::success('The comment has been changed status successfully');	
			}else{
				Log::error('The comment hasnt been changed status');	
			}	
		}else{
			Log::warning('Comment not found');	
		}
		$this->redirect(array('comment/index','c1'=>$this->category,'c2'=>$this->content));	
	}
	
}
?>