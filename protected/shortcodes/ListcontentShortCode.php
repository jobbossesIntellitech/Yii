<?php
class ListcontentShortCode extends JShortCode{
	private static $firstTime = true;
	public function process(){
		extract($this->fillDefault(array(
			'id'=>NULL,
			'parent'=>NULL,
			'category'=>NULL,
			'status'=>NULL,
			'tags'=>NULL,
			'search'=>NULL,
			'language'=>NULL,
			'slug'=>NULL,
			'order'=>NULL,
			'orderby'=>NULL,
			'limit'=>NULL,
			'offset'=>NULL
		)));
		$criteria = new CDbCriteria;
		if($id != NULL){ $criteria->addCondition('con_id = '.$id); }
		if($parent != NULL){ $criteria->addCondition('con_parentid = '.$parent); }
		if($category != NULL){ $criteria->addCondition('con_categoryid = '.$category); }
		if($status != NULL){ $criteria->addCondition('con_status = '.Content::status()->getItem($status)->getValue()); }
		if($tags != NULL){ 
			$tags = explode(',',$tags);
			$like = array();
			if(!empty($tags) && is_array($tags)){
				foreach($tags AS $tag){
					$like[] = 'con_tags like "%'.$tag.'%"';
				}
				$tags = implode(' OR ',$like);
			}
			$criteria->addCondition($tags); 
		}
		if($search != NULL){ 
			$criteria->addCondition('content_lang.lng_title like "%'.$search.'%" OR content_lang.lng_excerpt like "%'.$search.'%" OR content_lang.lng_text like "%'.$search.'%"');
			$criteria->addCondition('content_lang.lng_title not like "%'.htmlentities($this->getCode()).'%" AND content_lang.lng_excerpt not like "%'.htmlentities($this->getCode()).'%" AND content_lang.lng_text not like "%'.htmlentities($this->getCode()).'%"');
		}
		if($language == NULL){
			$language = Jii::app()->language;
		}else{
			$language = Language::model()->findByAttributes(array('lng_iso = "'.$language.'"'));
			if(isset($language->lng_id))
				$language = $language->lng_id;		
		}
		if($slug != NULL){ $criteria->addCondition('con_slug = "'.$slug.'"'); }
		if($order != NULL && $orderby != NULL){ $criteria->order = $orderby.' '.$order; }
		if($limit != NULL){ $criteria->limit = $limit; }
		if($offset != NULL){ $criteria->offset = $offset; }
		$criteria->with = array('content_lang:'.$language,'comment','dates');
		$contents = Content::model()->findAll($criteria);
		$html = '';
		if(!empty($contents) && is_array($contents)){
			$html .= '<ul class="sc-list-content">';
			foreach($contents AS $content){
				$html .= $this->displayItem($content);
			}
			$html .= '</ul>';
			if(self::$firstTime){ $html .= $this->displayCss(); self::$firstTime = false; }
		}
		return $html;
	}
	protected function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['attr']['id']='content id(1|2|...)';
		self::$documentation[$this->getName()]['attr']['parent']='parent id of content(0|1|2|...)';
		self::$documentation[$this->getName()]['attr']['category']='category id of content(1|2|...)';
		self::$documentation[$this->getName()]['attr']['status']='status of content(draft|publish|hot|archive|delete)';
		self::$documentation[$this->getName()]['attr']['tags']='list of tags(tag1,tag2,...)';
		self::$documentation[$this->getName()]['attr']['search']='search word or expression';
		self::$documentation[$this->getName()]['attr']['language']='language iso code(en|ar|fr|...)';
		self::$documentation[$this->getName()]['attr']['slug']='unique slug';
		self::$documentation[$this->getName()]['attr']['order']='order position(asc|desc)';
		self::$documentation[$this->getName()]['attr']['orderby']='order by attribute(con_id|con_slug|con_tags|lng_excerpt|lng_text|dat_creation)';
		self::$documentation[$this->getName()]['attr']['limit']='number of items of contents(1|2|3|...)';
		self::$documentation[$this->getName()]['attr']['offset']='limit start from nth item(0|1|2|...)';
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().' attributes(name="value" ...)][/'.$this->getName().']';
		self::$documentation[$this->getName()]['remark'] = '';
		self::$documentation[$this->getName()]['description'] = 'Display list of contents (title,excerpt,read more) filtering by attributes criteria';
	}
	private function displayItem($content){
		ob_start();
		?>
		<li class="outer-item">
			<div class="inner-item">
				<h3 class="title"><?php echo $content->content_lang->lng_title; ?></h3>
				<div class="excerpt"><?php echo $content->content_lang->lng_excerpt; ?></div>
				<div class="more">
					<a href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>$content->con_id)); ?>">
						<?php echo Jii::t('more...'); ?>
					</a>
				</div>
			</div>
		</li>
		<?php
		$content = ob_get_clean();
		return $content;
	}
	private function displayCss(){
		ob_start();
		?>
		<style type="text/css">
			.sc-list-content{ padding:5px; position:relative; margin:0; display:block;}
			.sc-list-content li.outer-item{ list-style:none; padding:5px;}
			.sc-list-content li.outer-item .inner-item{ padding:5px; background:#f5f5f5;}
			.sc-list-content li.outer-item .inner-item h3.title{ height:36px; line-height:36px; padding:0 20px; border-bottom:1px solid #999; color:#999;}
			.sc-list-content li.outer-item .inner-item .excerpt{ padding:5px; font-size:12px; color:#666;}
			.sc-list-content li.outer-item .inner-item .more{ background:#eee;}
			.sc-list-content li.outer-item .inner-item .more a{ display:block; text-align:center; color:#333; padding:5px; background:#eee;}
			.sc-list-content li.outer-item .inner-item .more a:hover{ background:#fabb02; color:#363092;}
		</style>
		<?php
		$css = ob_get_clean();
		return $css;
	}
}
?>