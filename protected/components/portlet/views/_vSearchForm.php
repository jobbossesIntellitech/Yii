<?php
	$item = Item::model()->findByPk(Jii::param('itemid'));
	$links = array();
	if(isset($item) && !empty($item)){
		$parent_item = get_category_parent($item->itm_parentid,$links);
		array_push($parent_item, Jii::param('itemid'));
	}
	
	if(isset($data['category']) && !empty($data['category'])){
		$first_category = $data['category'];
	}else if(isset($parent_item[0]) && !empty($parent_item[0])){
		$first_category = $parent_item[0];
	}else{
		$first_category  = '';
	}
	if(isset($parent_item[1]) && !empty($parent_item[1])){ $second_category  = $parent_item[1];}else{$second_category  = ' ';}
	if(isset($parent_item[2]) && !empty($parent_item[2])){ $third_category  = $parent_item[2];}else{$third_category  = ' ';}
	if(isset($parent_item[3]) && !empty($parent_item[3])){ $forth_category = $parent_item[3];}else{$forth_category  = ' ';}
	//echo $first_category.' - '.$second_category.' - '.$third_category.' - '.$forth_category;
	
	function get_category_parent($itemid, $links){
		$this_item = Item::model()->findByPk($itemid);
		
		if(isset($this_item->itm_parentid) && ($this_item->itm_parentid > 0)){
			$links = get_category_parent($this_item->itm_parentid, $links);
		}
		if(isset($this_item->itm_parentid)) array_push($links, $this_item->itm_id);
		return $links;
	}
	
?>
<div class="find titillium"><?php echo Jii::t('Find a:');?></div>
<?php echo CHtml::beginForm(Yii::app()->createUrl("search/index",array('type'=>'search','country'=>Jii::param('country'),'city'=>Jii::param('city'))),'get',array('name'=>'searchForm')); ?>
<div class="sp-field search-lot sep search-form">
	<div class="input">
		<input type="text" id="keywords" name="keywords" value="<?php echo Jii::param('keywords') ?>" placeholder="keywords" />
		<span class="ex">eg. BMW, Appartment, Closet...</span>
	</div>
	<div class="input">
		<input type="text" id="reference" name="reference" value="<?php echo Jii::param('reference') ?>" placeholder="Reference Nb" />
	</div>
	<div class="sp-field">
        <div class="input">
			<?php echo CHtml::dropDownList('category',$first_category,$data['categories'],array('prompt'=>'-- Select Category -- ')); ?>	
        </div>
    </div>
	<div class="sp-field">
        <div class="input">
        	<?php echo CHtml::dropDownList('subcategory',$data['subcategory'],array(),array('prompt'=>'-- Select Sub Category -- ')); ?>	
        </div>
    </div>
	<div class="sp-field">
        <div class="input">
        	<?php echo CHtml::dropDownList('subsubcategory',$data['subsubcategory'],array(),array('prompt'=>'-- Specify Category -- ')); ?>	
        </div>
    </div>
	<div class="sp-field" style="display:none;">
        <div class="input">
        	<?php echo CHtml::dropDownList('subsubsubcategory',$data['subsubsubcategory'],array(),array('prompt'=>'-- Specify Category -- ')); ?>	
        </div>
    </div>
	
	<div class="sp-field">
        <div class="input">
        	<?php echo CHtml::dropDownList('country',$data['country'],$data['countries']); ?>	
        </div>
    </div>
	<div class="sp-field">
        <div class="input">
        	<?php echo CHtml::dropDownList('city',$data['city'],array(),array('prompt'=>'-- Specify City -- ')); ?>	
        </div>
    </div>
	
	<div class="submit">
    	<a href="javascript://" class="submitSearchForm"><?php echo Jii::t("Search Ads"); ?></a>
    </div>
	
	<div class="simple">
		<div class="fields"></div>
	</div>
	
	<div class="advanced">
		<a href="javascript://" style="display:none;"><?php echo Jii::t('Advanced'); ?></a>
		<div class="fields"></div>
		<div class="submit"style="display:none;">
			<a href="javascript://" class="submitSearchForm"><?php echo Jii::t("Search Ads"); ?></a>
		</div>
	</div>
	
	<div class="loader"></div>
</div>
<?php echo CHtml::endForm();?>

<script type="text/javascript">
$(document).ready(function(){
	var page_itemid = '<?php echo Jii::param('itemid');?>';
	
	
	$('#category').change(function(){
		if($(this).val() != ''){
			ajaxSearch('getSubCategories',{category:$(this).val()},function(data){
				var subcategory = $('#subcategory');
				var subsubcategory = $('#subsubcategory');
				var subsubsubcategory = $('#subsubsubcategory');
				var subcategory_selected = '<?php echo (isset($data['subcategory']) && !empty($data['subcategory']))?$data['subcategory']:$second_category;?>';
				subcategory.empty();
				subsubcategory.empty();
				subsubsubcategory.empty();
				subsubsubcategory.parent().parent().hide();
				subcategory.append('<option value="">-- Select Sub Category --</option>');
				subsubcategory.append('<option value="">-- Specify Category --</option>');
				subsubsubcategory.append('<option value="">-- Specify Category --</option>');
				for(var i in data.list){
					subcategory.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
				}
				$('#subcategory').val(subcategory_selected);
				$('#subcategory').trigger('change');
			});
		}
	});
	$('#category').trigger('change');
	$('#subcategory').change(function(){
		if($(this).val() != ''){
			var valeur = $(this).val();
			ajaxSearch('getSubCategories',{category:$(this).val()},function(data){
				var subcategory = $('#subsubcategory');
				var subsubcategory = $('#subsubsubcategory');
				var subcategory_selected = '<?php echo (isset($data['subsubcategory']) && !empty($data['subsubcategory']))?$data['subsubcategory']:$third_category;?>';
				subcategory.empty();
				subsubcategory.empty();
				subsubcategory.parent().parent().hide();
				subcategory.append('<option value="">-- Specify Category --</option>');
				subsubcategory.append('<option value="">-- Specify Category --</option>');
				for(var i in data.list){
					subcategory.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
				}
				if(data != ''){
					$('#subsubcategory').val(subcategory_selected);
					$('#subsubcategory').trigger('change');
				}
				
				
				if(data == ''){
					ajaxSearch('getSearchFields',{category:valeur},function(data2){
						//alert(fetchObject(data,'-','\n','\t\t'));
						$('.search-form .fields').html('');
						$('.search-form .fields').hide();
						$('.search-form .advanced .submit').hide();
						if(data2.advanced == undefined || data2.advanced.length == 0){
							$('.search-form .advanced > a').hide();
						}else{
							$('.search-form .advanced > a').show();
						}
						var prev = null;
						for(var i in data2){
							$('.search-form .simple .fields').show();
							prev = new SearchFormBuilderPreview('.'+i+' .fields',data2[i]);
							prev.create();
						}
					});
					//$('#subcategory').val(subcategory_selected);
					//$('#subcategory').trigger('change');
				}
				
				
			});
		}
	});
	$('#subsubcategory').change(function(){
		if($(this).val() != ''){
			ajaxSearch('getSearchFields',{category:$(this).val()},function(data){
				//alert(fetchObject(data,'-','\n','\t\t'));
				$('.search-form .fields').html('');
				$('.search-form .fields').hide();
				$('.search-form .advanced .submit').hide();
				if(data.advanced == undefined || data.advanced.length == 0){
					$('.search-form .advanced > a').hide();
				}else{
					$('.search-form .advanced > a').show();
				}
				var prev = null;
				for(var i in data){
					$('.search-form .simple .fields').show();
					prev = new SearchFormBuilderPreview('.'+i+' .fields',data[i]);
					prev.create();
				}
			});
			
			var valeur = $(this).val();
			ajaxSearch('getSubCategories',{category:$(this).val()},function(data){
				var subcategory = $('#subsubsubcategory');
				var subcategory_selected = '<?php echo (isset($data['subsubsubcategory']) && !empty($data['subsubsubcategory']))?$data['subsubsubcategory']:$forth_category;?>';
				subcategory.empty();
				subcategory.parent().parent().hide();
				subcategory.append('<option value="">-- Specify Category --</option>');
				for(var i in data.list){
					subcategory.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
				}
				if(data != ''){
					$('#subsubsubcategory').val(subcategory_selected);
					$('#subsubsubcategory').trigger('change');
					subcategory.parent().parent().show();
				}
				
				if(data == ''){
					ajaxSearch('getSearchFields',{category:valeur},function(data2){
						//alert(fetchObject(data,'-','\n','\t\t'));
						$('.search-form .fields').html('');
						$('.search-form .fields').hide();
						$('.search-form .advanced .submit').hide();
						if(data2.advanced == undefined || data2.advanced.length == 0){
							$('.search-form .advanced > a').hide();
						}else{
							$('.search-form .advanced > a').show();
						}
						var prev = null;
						for(var i in data2){
							$('.search-form .simple .fields').show();
							prev = new SearchFormBuilderPreview('.'+i+' .fields',data2[i]);
							prev.create();
						}
					});
					//$('#subcategory').val(subcategory_selected);
					//$('#subcategory').trigger('change');
				}
				
				
			});
		}
	});
	$('#subsubsubcategory').change(function(){
		if($(this).val() != ''){
			ajaxSearch('getSearchFields',{category:$(this).val()},function(data){
				//alert(fetchObject(data,'-','\n','\t\t'));
				$('.search-form .fields').html('');
				$('.search-form .fields').hide();
				$('.search-form .advanced .submit').hide();
				if(data.advanced == undefined || data.advanced.length == 0){
					$('.search-form .advanced > a').hide();
				}else{
					$('.search-form .advanced > a').show();
				}
				var prev = null;
				for(var i in data){
					$('.search-form .simple .fields').show();
					prev = new SearchFormBuilderPreview('.'+i+' .fields',data[i]);
					prev.create();
				}
			});
		}
	});
	$('#country').change(function(){
		if($(this).val() != ''){
			ajaxSearch('getCities',{country:$(this).val()},function(data){
				var city = $('#city');
				var city_selected = '<?php echo (isset($data['city']))?$data['city']:' ';?>';
				if(city_selected == '') city_selected = <?php echo Jii::app()->user->location;?>;
				city.empty();
				city.append('<option value="">-- Specify City -- </option>');
				for(var i in data.list){
					city.append('<option value="'+i+'">'+data.list[i]+'</option>');
				}
				$('#city').val(city_selected);
			});
		}
	});
	$('#country').trigger('change');
	$('.search-form .advanced > a').click(function(){
		$('.search-form .advanced .fields').toggle();
		$('.search-form .advanced .submit').toggle();
	});
	$('.submitSearchForm').click(function(){
		if($('#subcategory').val() == ''){
			if($('#keywords').val() != '' || $('#reference').val() != ''){
				submitSearchForm();
			}else{
				alert('You Must Specify a Category!!!!');
			}
		}else{
			submitSearchForm();
		}
	});
});
function ajaxSearch(action,data,success){
	var url = '<?php echo Jii::app()->createAbsoluteUrl('search/--ACTION--'); ?>';
	url = url.replace('--ACTION--',action);
	$.ajax({
		type : 'post',
		url : url,
		data : data,
		dataType : 'json',
		beforeSend : function(){
			$('.loader').hide();
		},
		completed : function(){
			$('.loader').hide();
		},
		success : function(data){
			success(data);
			$('.loader').hide();
		},
		error : function(){
			$('.loader').hide();
		}
	});
}

function fetchObject(data,padding,line,space){
	var r = '';
	for(var i in data){
		r += padding+' '+i+' : ';
		if(typeof(data[i]) == 'object'){
			r += line+fetchObject(data[i],padding+space,line,space);
		}else
		if(typeof(data[i]) == 'array'){
			r += line+fetchObject(data[i],padding+space,line,space);
		}else{
			r += data[i];
		}
		r += line;
	}
	return r;
}
function submitSearchForm(){
	document.searchForm.submit();
	/*var keywords = $('#keywords').attr('value');
	var category_id = $('#category').attr('value');
	var subcategory_id = $('#subcategory').attr('value');
	var subsubcategory_id = $('#subsubcategory').attr('value');
	var country_id = $('#country').attr('value');
	var city_id = $('#city').attr('value');
	var field = '';*/
	
	//document.location.href = '<?php echo Jii::app()->createUrl('item/search');?>?keywords='+keywords+'&category='+category_id+'&subcategory='+subcategory_id+'&subsubcategory='+subsubcategory_id+'&country='+country_id+'&city='+city_id;
	// first validate
	// second submit form
}
</script>