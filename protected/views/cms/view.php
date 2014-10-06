<h1 class="cms-title"><?php echo $view->content_lang->lng_title; ?></h1>


<div class="cms-text">
<?php 
$image = json_decode($view->con_gallery);
if(isset($image[0]) && !empty($image[0])){
	$img = new ImageProcessor(Jii::app()->basePath.'/..'.$image[0]);
	$img->setIdentity('news_view');
	$img->resizeInto(155,110);
	echo '<img data-index="0" src="'.$img->output(IMAGETYPE_PNG).'"/>';
}
?>

<?php echo JShortCode::filter($view->content_lang->lng_text); ?>
</div>




<?php
if($view->con_hascomments){
?>
<div class="cms-comments">
	<div class="form">
	<?php
	$model = new CommentForm;
	$model->parentid = 0;
	$model->contentid = $view->con_id;
	$model->user = 0;
	$h = new Html($model,$this,array(
		'id'=>'comment-form',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'action'=>Jii::app()->createUrl('cms/addcomment'),
		'htmlOptions'=>array(),
	));
	$h->begin();
	echo $h->hidden('parentid');
	echo $h->hidden('contentid');
	echo $h->hidden('user');
	echo $h->section(Jii::t('Add New Comment'),array(
		$h->text('name'),
		$h->text('email'),
		$h->text('title'),
		$h->textArea('text'),	
	),false);
	echo $h->submit(Jii::t('Send'));
	$h->end();
	?>
	</div>
	<?php
	if(isset($view->comment) && is_array($view->comment) && !empty($view->comment)){
		foreach($view->comment AS $comment){
			?>
			<div class="cms-comment">
				<div class="cms-h">
					<?php echo '<span>'.$comment->com_title.'</span> '.Jii::t('by').' '.$comment->com_name; ?>
				</div>
				<div class="cms-t"><?php echo $comment->com_text; ?></div>
			</div>
			<?php
		}
	}
	?>
</div>
<?php
}
?>