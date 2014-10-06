<div class="list-page">
	<div class="list-subcategories">
		<div class="title-box" style="border:none;">
			<span class="titillium" style="font-size:20px;"><?php echo Jii::t('View Member Profile'); ?></span> 
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="member-page">
	<div class="member-image">
		<?php
			if(isset($user->mbr_image) && !empty($user->mbr_image)){
			
				$image = '/assets/uploads/members/'.$user->mbr_image;
				if(isset($image) && !empty($image)){
					$img = new ImageProcessor(Jii::app()->params['rootPath'].$image);
					$img->setIdentity('list_member_image');
					$img->resizeInto(100,100);
					echo '<img src="'.$img->output(IMAGETYPE_PNG).'"/>';
				}else{
					echo '<img src="'.Jii::app()->baseUrl.'/assets/member.jpg"/>';
				}
			}else{
				echo '<img src="'.Jii::app()->baseUrl.'/assets/member.jpg" />';
			}
		?>
	</div>
	<div class="clear" style="height:10px;"></div>
	<!--<div style="float:right; right:0;" class="rw-ui-container rw-urid-<?php //echo '0000'.$l->ads_memberid;?>"></div>-->
	<div class="clear" style="height:10px;"></div>
	<div class="member-name">
		<div class="listed-title"><?php echo Jii::t('Fullname: ');?></div>
		<div class="listed-text"><?php echo $user->mbr_firstname.' '.$user->mbr_lastname;?></div>
	</div>
	<div class="member-name">
		<div class="listed-title"><?php echo Jii::t('Gender: ');?></div>
		<div class="listed-text"><?php echo ($user->mbr_gender == 1)?'male':'female';?></div>
	</div>
	<div class="member-name">
		<div class="listed-title"><?php echo Jii::t('Member Since: ');?></div>
		<div class="listed-text"><?php echo date('d F, Y',strtotime($user->dates->dat_creation));?></div>
	</div>
	<div class="clear" style="height:10px;"></div>
	<div class="member-location">
		<?php echo 'Located: '.Location::breadcrumblocation($user->mbr_locationid,true,$user->mbr_address);?>
	</div>
	<div class="clear" style="height:10px;"></div>
	<div style="float:left; left:0;" class="rw-ui-container rw-userid-<?php echo $user->mbr_id;?>"></div>
</div>