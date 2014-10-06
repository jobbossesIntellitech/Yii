<?php
$item = Item::model()->findByPk(Jii::param('itemid'));
$category_name = (isset($item))?' - '.$item->itm_name:'';
//$category_name = '';
/*$h = new Html($modelcategory,$this,array(
	'id'=>'ads-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('web/ads'),
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
$h->begin();
echo $h->section(Jii::t('place an ad in').$category_name.Jii::t(' - step 1/4'),array(
	$h->dropDownList('id',Item::tree(Jii::param('itemid'),'','',1),array('prompt'=>' -- Please Select Item -- ','label'=>'Category')),
));
echo $h->submit(Jii::t('Next'));
$h->end();*/

?>
<div class="list-page">
	<div class="list-subcategories">
		<div class="title-box" style="border:none;">
			<span class="titillium" style="font-size:20px;"><?php echo Jii::t('Place an Ad'); ?></span> 
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="j-form" id="placead_container">
	<div class="error err"><div style="" id="PlaceAd_error" class="errorMessage"></div></div>
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div><div class="text"><?php echo Jii::t('place an ad in').$category_name.Jii::t(' - step 1/2');?></div><div class="r"></div>
			</legend>
			<div class="fields">
				<div class="field">
					<?php
					$items = Item::tree(0,'','',1);
					if(isset($items) && is_array($items) && !empty($items)){
						?>
						<div class="input">
							<div class="label"><label style="color:#fff;">Category</label></div>
							<select id="category_id" name="itemform_id">
								<option value="">Select Category</option>
								<?php
								foreach($items AS $k=>$v){
									if($k != 12){
										?>
										<option <?php echo (isset($item) && ($item->itm_id == $k))?'selected="selected"':'';?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
										<?php
									}
								}
								?>	
							</select>
						</div>
						<?php
					}
					?>	
					<div class="input" style="display:none;">
						<div class="label"><label style="color:#fff;">Sub Category</label></div>
						<select id="subcategory_id" name="itemform_id">
						</select>
					</div>
					<div class="input" style="display:none;">
						<select id="subsubcategory_id" name="itemform_id">
						</select>
					</div>
					<div class="input" style="display:none;">
						<select id="subsubsubcategory_id" name="itemform_id">
						</select>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
		<div class="loader"></div>
	</div>
	
	<div class="clear"></div>
	<div class="submit">
    	<a href="javascript://" id="submitPlaceAd"><?php echo Jii::t("Submit Ad"); ?></a>
    </div>
	
	<input type="hidden" value="" id="item_id" />
</div>	
	
<script type="text/javascript">
$(document).ready(function(){
	$('#placead_container #category_id').change(function(){
		if($(this).val() != ''){
			ajaxAd('getSubCategories',{category:$(this).val()},function(data){
				var subcategory = $('#placead_container #subcategory_id');
				var subsubcategory = $('#placead_container #subsubcategory_id');
				var subsubsubcategory = $('#placead_container #subsubsubcategory_id');
				subcategory.empty();
				subsubcategory.empty();
				subsubsubcategory.empty();
				subcategory.append('<option value="">Select Sub Category</option>');
				subsubcategory.append('<option value="">Specify Category</option>');
				subsubsubcategory.append('<option value="">Specify Category</option>');
				if(data != ''){ 
					subcategory.parent().show();
				}else{
					subcategory.parent().hide();
					subsubcategory.parent().hide();
					subsubsubcategory.parent().hide();
				}
				for(var i in data.list){
					if(data.list[i]['id'] != undefined){
						subcategory.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
					}
				}
				$('#placead_container #subcategory_id').trigger('change');
			});
			
			$(this).find('option').click(function(){
				$('.title .text').html('place an ad in - '+$(this).html()+'  - step 1/2');
				$('#placead_container #item_id').val($(this).val());
			});
			if($(this).first().html() != 0) $('#placead_container #item_id').val($(this).first().val());
		}
	});
	$('#placead_container #category_id').trigger('change');
	
	$('#placead_container #subcategory_id').change(function(){
		if($(this).val() != ''){
			ajaxAd('getSubCategories',{category:$(this).val()},function(data){
				var subsubcategory = $('#placead_container #subsubcategory_id');
				var subsubsubcategory = $('#placead_container #subsubsubcategory_id');
				subsubcategory.empty();
				subsubsubcategory.empty();
				subsubcategory.append('<option value="">Specify Category</option>');
				subsubsubcategory.append('<option value="">Specify Category</option>');
				if(data != ''){ 
					subsubcategory.parent().show();
				}else{
					subsubcategory.parent().hide();
					subsubsubcategory.parent().hide();
				}
				for(var i in data.list){
					if(data.list[i]['id'] != undefined){
						subsubcategory.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
					}
				}
				$('#placead_container #subsubcategory_id').trigger('change');
			});
			
			$(this).find('option').click(function(){
				$('#placead_container #item_id').val($(this).val());
			});
			if($(this).first().html() != 0) $('#placead_container #item_id').val($(this).first().val());
		}
	});
	
	$('#placead_container #subsubcategory_id').change(function(){
		if($(this).val() != ''){
			ajaxAd('getSubCategories',{category:$(this).val()},function(data){
				var subsubsubcategory = $('#placead_container #subsubsubcategory_id');
				subsubsubcategory.empty();
				if(data != ''){ 
					subsubsubcategory.parent().show();
				}else{
					subsubsubcategory.parent().hide();
				}
				for(var i in data.list){
					if(data.list[i]['id'] != undefined){
						subsubsubcategory.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
					}
				}
				$('#placead_container #subsubsubcategory_id').trigger('change');
			});
			
			
			$(this).find('option').click(function(){
				$('#placead_container #item_id').val($(this).val());
			});
			if($(this).first().html() != 0) $('#placead_container #item_id').val($(this).first().val());
		}
	});
	
	$('#placead_container #subsubsubcategory_id').change(function(){
		if($(this).val() != ''){
			$(this).find('option').click(function(){
				$('#placead_container #item_id').val($(this).val());
			});
			if($(this).first().html() != 0) $('#placead_container #item_id').val($(this).first().val());
		}
	});
	
	$('#submitPlaceAd').click(function(){
		submitPlaceAd();
	});
});

function ajaxAd(action,data,success){
	var url = '<?php echo Jii::app()->createAbsoluteUrl('web/--ACTION--'); ?>';
	url = url.replace('--ACTION--',action);
	$.ajax({
		type : 'post',
		url : url,
		data : data,
		dataType : 'json',
		beforeSend : function(){
			$('#placead_container .loader').hide();
		},
		completed : function(){
			$('#placead_container .loader').hide();
		},
		success : function(data){
			success(data);
			$('#placead_container .loader').hide();
		},
		error : function(){
			$('#placead_container .loader').hide();
		}
	});
}

function submitPlaceAd(){
	var item_id = $('#item_id').attr('value');
	document.location.href = '<?php echo Jii::app()->createUrl('web/ads');?>?itemid='+item_id;
	// first validate
	// second submit form
}

</script>