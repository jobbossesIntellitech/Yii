<h1 class="cms-title"><?php echo Category::breadcrumbpage($category->cat_id); ?></h1>
<?php
if(!empty($contents) && is_array($contents)){
	?>
	<div class="content-list">
		<ul>
		<?php
		foreach($contents AS $content){
			?>
			<li>
				<a href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>$content->con_id)); ?>">
					<?php echo $content->content_lang->lng_title; ?>
				</a>
                <div class="text"><?php echo $content->content_lang->lng_text; ?></div>
			</li>
			<?php	
		}
		?>
		</ul>
		<div class="clr"></div>
	</div>
	<?php
}
?>
<?php
if(!empty($category->children) && is_array($category->children)){
	?>
	<div class="category-list">
		<ul>
		<?php
		foreach($category->children AS $child){
			?>
			<li>
				<a href="<?php echo Jii::app()->createUrl('cms/category',array('id'=>$child->cat_id)); ?>">
					<?php echo $child->category_lang->lng_name; ?>
				</a>
			</li>
			<?php	
		}
		?>
		</ul>
		<div class="clr"></div>
	</div>
	<?php
}
?>