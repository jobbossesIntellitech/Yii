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
                <div class="text">
					<?php 
                        $image = json_decode($content->con_gallery);
                        if(isset($image[0]) && !empty($image[0])){
                            $img = new ImageProcessor(Jii::app()->basePath.'/..'.$image[0]);
                            $img->setIdentity('category');
                            $img->resizeInto(155,110);
                            echo '<img data-index="0" src="'.$img->output(IMAGETYPE_PNG).'"/>';
                        }
					?>
					<?php echo $content->content_lang->lng_excerpt; ?>
					<a href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>$content->con_id)); ?>">
						<?php echo Jii::t('read more'); ?>
					</a>
				</div>
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