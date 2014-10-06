<div class="big-title titillium"><a href="<?php echo Jii::app()->createUrl('cms/category',array('id'=>'2'));?>"><?php echo Jii::t("SoChivi ");?><span><?php echo Jii::t(" Blog");?></span></a></div>
<!--<div class="more-all-news titillium"><a href="javascript://"><?php //echo Jii::t('So Chivi News');?></a></div>-->
<div class="clear"></div>
<?php
if(isset($news) && !empty($news) && is_array($news)){
	$i = 0;
	foreach($news as $n){
	?>
		<div class="news-box">
			<div class="desc">
				<div class="title titillium">
					<a class="titillium" href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>$n->con_id));?>"><?php echo $n->content_lang->lng_title;?></a>
				</div>
				<div class="text titillium">
					<?php //echo $n->content_lang->lng_excerpt;?>
					<a class="titillium" href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>$n->con_id));?>">
					<?php 
						$strip = $n->content_lang->lng_excerpt;
						$part = 190;
						$len = strlen($strip);
						if($len <= $part ){
							echo $strip;
						}else{
							echo substr($strip,0,$part).'...';
						} 
					?>
					</a>
				</div>
				<div class="clear"></div>
				<a class="titillium" href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>$n->con_id));?>">Continue...</a>
			</div>
			<div class="image">
				<a class="titillium" href="<?php echo Jii::app()->createUrl('cms/view',array('id'=>$n->con_id));?>">
				<?php 
					$image = json_decode($n->con_gallery);
					if(isset($image[0]) && !empty($image[0])){
						$img = new ImageProcessor(Jii::app()->basePath.'/..'.$image[0]);
						$img->setIdentity('news');
						$img->resizeInto(155,110);
						echo '<img data-index="0" src="'.$img->output(IMAGETYPE_PNG).'"/>';
					}else{
						echo '<img src="'.Yii::app()->request->baseUrl.'/assets/notfound.jpg">';
					}
				?>
				</a>
			</div>
		</div>
	<?php
	if($i == 0){ echo '<div class="sep"></div>'; $i++;}
	}
}
?>
<!--<div class="news-box">
	<div class="desc">
		<div class="title titillium">Designing For Emotion With Hover Effects</div>
		<div class="text titillium">Of the many factors that must be considered in Web design, emotiobut frequently neglected, component. In the real world, we experience the sensual interaction of design all the time.</div>
		<div class="clear"></div>
		<a class="titillium" href="javascript://">Continue...</a>
	</div>
	<div class="image">
		<img src="<?php //echo Yii::app()->request->baseUrl; ?>/assets/finder/files/news1.png" />
	</div>
</div>
<div class="sep"></div>
<div class="news-box">
	<div class="desc">
		<div class="title titillium">IPhone 5  For Emotion With Hover Effects</div>
		<div class="text titillium">Of the many factors that must be considered in Web design, emotiobut frequently neglected, component. In the real world, we experience the sensual interaction of design all the time.</div>
		<div class="clear"></div>
		<a class="titillium" href="javascript://">Continue...</a>
	</div>
	<div class="image">
		<img src="<?php //echo Yii::app()->request->baseUrl; ?>/assets/finder/files/news2.png" />
	</div>
</div>-->