<?php
$locations = Location::model()->findAll();
$locations = Location::completelocation($locations);

Yii::app()->clientScript->registerScriptFile( 'http://maps.google.com/maps/api/js?sensor=false');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets/scripts/locationpicker.js');
?>
<div class="list-page">
	<div class="list-subcategories">
		<div class="title-box" style="border:none;">
			<span class="titillium" style="font-size:20px;"><?php echo Jii::t('Place an Ad'); ?></span> 
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="form-generator" id="formGenerator_<?php echo $this->id; ?>">
	<form method="post" action="<?php echo Jii::app()->createUrl('web/ads',array('id'=>$this->id,'itemid'=>$this->itemid)); ?>" enctype="multipart/form-data" >
		<?php if(!empty($form['title']) && $this->title){ ?>
			<h1 class="title"><?php echo $form['title']; ?></h1>
		<?php
		}
		if(isset($form['sections']) && !empty($form['sections']) && is_array($form['sections'])){
			foreach($form['sections'] AS $k=>$section){
				?>
				<fieldset>
					<legend>
					<?php 
					if(!empty($section['title'])){
						echo 'place an ad in - '.$section['title'].' - step 2/2';
					}
					?>
					</legend>
					<?php
					if(isset($section['fields']) && is_array($section['fields']) && !empty($section['fields'])){
						$h = '';
						$f = '';
						foreach($section['fields'] AS $g=>$field){
							switch($field['type']){
								case 'hidden':
									$h .= '<input type="hidden" name="field['.$g.']" value="'.$field['defaultvalue'].'" />';
								break;
								case 'text':
									$f .= $this->template('text',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'password':
									$f .= $this->template('password',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'select':
									$f .= $this->template('select',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'checkbox':
									$f .= $this->template('checkbox',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'radio':
									$f .= $this->template('radio',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'date':
									$f .= $this->template('date',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'time':
									$f .= $this->template('time',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'datetime':
									$f .= $this->template('datetime',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'textarea':
									$f .= $this->template('textarea',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'email':
									$f .= $this->template('email',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'number':
									$f .= $this->template('number',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'editor':
									$f .= $this->template('editor',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'poll':
									$f .= $this->template('poll',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'tags':
									$f .= $this->template('tags',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
								case 'mask':
									$f .= $this->template('mask',array('field'=>$field,'sec_id'=>$k,'fld_id'=>$g));
								break;
							}
						}
					}
					echo $h;
					
					$currencies = Currency::model()->findAll();
					$curr = '';
					if(isset($currencies) && !empty($currencies) && is_array($currencies)){
						$curr .='<tr>';
							$curr .= '<th><label>Currency</label></th>';
							$curr .= '<td>';
								$curr .= '<select id="currency" name="currency">';
									foreach($currencies as $c){
										$curr .= '<option value="'.$c->cur_id.'">'.$c->cur_name.'</option>';
									}
								$curr .= '</select>';
							$curr .= '</td>';
						$curr .= '</tr>';
					}
					
					$locats = Location::model()->getCountry();
					$loc = '';
					if(isset($locats) && !empty($locats) && is_array($locats)){
						$loc .='<tr>';
							$loc .= '<th><label>Location</label></th>';
							$loc .= '<td>';
								$loc .= '<select id="country" name="country">';
									foreach($locats as $k=>$v){
										$loc .= '<option value="'.$k.'">'.$v.'</option>';
									}
								$loc .= '</select>';
							$loc .= '</td>';
						$loc .= '</tr>';
						
						$loc .='<tr>';
							$loc .= '<th><label></label></th>';
							$loc .= '<td>';
								$loc .= '<select id="city" name="city">';
									
								$loc .= '</select>';
							$loc .= '</td>';
						$loc .= '</tr>';
						
						$loc .='<tr>';
							$loc .= '<th><label></label></th>';
							$loc .= '<td>';
								$loc .= '<select id="area" name="area">';
									
								$loc .= '</select>';
							$loc .= '</td>';
						$loc .= '</tr>';
					}
					
					$ref = '
					<tr>
						<th><label>Reference</label><span class="required">*</span></th>
						<td><input id="reference" type="text" name="reference" class="validate required" /><div class="error-message error">This Field is required!!</div></td>
					</tr>';
					
					echo '<table>
					<tr>
						<th><label>Title</label><span class="required">*</span></th>
						<td><input id="name" type="text" name="name" class="validate required" /><div class="error-message error">This Field is required!!</div></td>
					</tr>
					<tr>
						<th><label>Price</label><span class="required">*</span></th>
						<td><input id="price" type="text" name="price" class="validate required" /><div class="error-message error">This Field is required!!</div></td>
					</tr>
					
					<tr>
						<th><label>Phone</label><span class="required">*</span></th>
						<td>
							<input type="radio" id="phone1" name="phone_number" class="validate required" checked="selected" value="phone1" />
							<label for="phone1" style="margin-right:45px;">Registered Phone no.</label>
							
							<input type="radio" id="phone2" name="phone_number" class="validate required" value="phone2"  />
							<label for="phone2" style="margin-right:45px;">Add a new Phone no.</label>
							
							<input type="radio" id="phone3" name="phone_number" class="validate required" value="phone3"  />
							<label for="phone3">Do not show a phone no.</label>
							<div class="error-message error">This Field is required!!</div>
						</td>
					</tr>
					<tr style="display:none;">
						<th><label></label></th>
						<td><input id="newphone" type="text" name="newphone" class="validate" placeholder="Add new Phone number" /></td>
					</tr>
					
					'.$curr .'
					'.$f.'
					<tr>
						<th><label>Description</label><span class="required">*</span></th>
						<td>
							<textarea id="description" name="description" class="validate required"></textarea>
							<div id="fake_description" contenteditable="true"></div>
							<div class="error-message error">This Field is required!!</div>
						</td>
					</tr>
					'.$loc.'
					<tr>
						<th><label>Map</label><span class="required">*</span></th>
						<td><input id="address_mapping" type="text" name="address_mapping" class="validate required" /><div class="error-message error">This Field is required!!</div></td>
					</tr>
					<tr>
						<th><label>Image</label></th>
						<td style="width:550px;">
							<input id="image1" type="file" name="image[]" />
							<input id="image2" type="file" name="image[]" />
							<input id="image3" type="file" name="image[]" />
							<input id="image4" type="file" name="image[]" />
							<input id="image5" type="file" name="image[]" />
							<input id="image6" type="file" name="image[]" />
						</td>
					</tr>
					</table>';
					?>
				</fieldset>
				<?php
			}
		}
		?>
		<div class="submit">
			<input type="submit" value="Submit to View your Ad" id="send_<?php echo $this->id; ?>" />
			<div class="clear"></div>
		</div>
	</form>
</div>

<style scoped>
	#description{display:none;}
	#fake_description{ padding:5px; background:#fff; border:1px solid #F0EFEF; min-height:50px;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fake_description").live("keyup change", function(e) {
			$('#description').val(strip_tags($("#fake_description").html(),'<br>'));
		});
		
		/*$("#fake_description").live("mouseup mouseout", function(e) {
			$('#description').val(strip_tags($("#fake_description").html(),'<br>'));
		});
		
		$("html").live("mouseover", function(e) {
			$('#description').val(strip_tags($("#fake_description").html(),'<br>'));
		});*/
		
		$("#fake_description").bind("paste", function(e){
			$('#description').val(strip_tags($("#fake_description").html(),'<br>'));
		});
	});
	function strip_tags(input, allowed) {
		allowed = (((allowed || '') + '')
		.toLowerCase()
		.match(/<[a-z][a-z0-9]*>/g) || [])
		.join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
		commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	  return input.replace(commentsAndPhpTags, '')
		.replace(tags, function($0, $1) {
		  return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
		});
	}

</script>
<script type="text/javascript">
	$(document).ready(function(){
		$("input#address_mapping").locationPicker();
		
		var res = [];
		<?php 
			if(isset($locations) && !empty($locations) && is_array($locations)){
				foreach($locations as $k=>$v){
					?>
						res[<?php echo $k;?>] = '<?php echo $v;?>';
					<?php
				}
			}
		?>
		
		$('.form-generator #country').val(3);
		$('.form-generator #country').trigger('click');
		
		$('.form-generator #country').change(function(){
			if($(this).val() != ''){
				ajaxSearch('getCities',{country:$(this).val()},function(data){
					var city = $('.form-generator #city');
					var area = $('.form-generator #area');
					city.empty();
					area.empty();
					city.append('<option value="">Please Select City</option>');
					area.append('<option value="">Please Select Area</option>');
					for(var i in data.list){
						if(data.list[i]['id'] != undefined){
							city.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
						}
					}
					if($('.form-generator #country').val() == 3){
						$('.form-generator #city').val(5);
						$('.form-generator #city').trigger('click');
						$('.form-generator #city').trigger('change');
					}
				});
			}
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		$('.form-generator #country').trigger('change');
		
		$('.form-generator #city').change(function(){
			if($(this).val() != ''){
				ajaxSearch('getCities',{country:$(this).val()},function(data){
					var area = $('.form-generator #area');
					area.empty();
					area.append('<option value="">Please Select Area</option>');
					if(data.list != ''){
						for(var i in data.list){
							if(data.list[i]['id'] != undefined){
								area.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
							}
						}	
					}
				});
			}
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		$('.form-generator #city').trigger('change');
		
		$('.form-generator #area').change(function(){
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		
		$(".pickermap").css("z-index","1000");
		$("input#address_mapping").trigger("focus").trigger("blur");
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
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#formGenerator_<?php echo $this->id; ?> tr th span.required').html('');
	
	if($('#formGenerator_<?php echo $this->id; ?> .validate').length == 0){
		$('#formGenerator_<?php echo $this->id; ?> .submit').remove();
	}
	$('#formGenerator_<?php echo $this->id; ?> .validate').each(function(i,e){
		$(e).bind('blur keyup',function(){
			validate<?php echo $this->id; ?>Item(e);	
		});
	});
	$('#send_<?php echo $this->id; ?>').click(function(){
		var res = true;
		$('#formGenerator_<?php echo $this->id; ?> .validate').each(function(i,e){
			res = validate<?php echo $this->id; ?>Item(e);
			if(res == false){ 
				window.scrollTo($(e),0);
				return res; 
			}
		});
		return res;
	});
	$('#phone2').click(function(){
		$('#newphone').parent().parent().show();
	});
	$('#phone1,#phone3').click(function(){
		$('#newphone').parent().parent().hide();
	});
	
	var this_formid = '<?php echo Jii::param('itemid');?>';
	var parent_formid = '<?php echo Item::model()->findByPk(Jii::param('itemid'))->itm_parentid;?>';
	
	//Jobs
	if(parent_formid == '10'){
		//salary field 
		$('.form-generator #price').parent().parent().find('label').html('Salary');
		$('.form-generator #price').parent().parent().hide();
		$('.form-generator #price').val(0);
		
		//currency field
		$('.form-generator #currency').parent().parent().hide();
		//$('.form-generator #image1').parent().parent().hide();
		/*$('.form-generator #field_206_1395').click(function(){
			$('.form-generator #price').val($(this).val());
		});*/
	}
	
	//properties for sale
	if(parent_formid == '18'){
		//$('.form-generator #field_198_1319')
		// calculate price/sqft
		$('.form-generator #price').change(function(){
			var price = $(this).val();
			var size = $('.form-generator #field_198_1319').val();
			var price_per_sqft = $('.form-generator #field_198_1326');
			if(size != ''){
				price_per_sqft.val(Math.round(price/size));
			}
		});
		// calculate price/sqft
		$('.form-generator #field_198_1319').change(function(){
			var size = $(this).val();
			var price = $('.form-generator #price').val();
			var price_per_sqft = $('.form-generator #field_198_1326');
			if(size != ''){
				price_per_sqft.val(Math.round(price/size));
			}
		});
		
		// Listed By owner or agent
		$('.form-generator #field_198_1325').change(function(){
			var value = $(this).val();
			if(value == 'Agent'){
				$('#field_198_1327').parent().parent().show();
			}else{
				$('#field_198_1327').val(' ');
				$('#field_198_1327').parent().parent().hide();
			}
		});
	}
	
	//properties for rent
	if(parent_formid == '29'){
		// Listed By owner or agent
		$('.form-generator #field_199_1336').change(function(){
			var value = $(this).val();
			if(value == 'Agent'){
				$('#field_199_1339').parent().parent().show();
			}else{
				$('#field_199_1339').val(' ');
				$('#field_199_1339').parent().parent().hide();
			}
		});
	}
	
	//Cell Phones & Accessories(remove features from accessories)
	if(this_formid == '463'){
		// Listed By owner or agent
		$('.form-generator #field_181_1205').parent().parent().hide();
	}
	
	//block Number of bathrooms & bedrooms from properties
	var blocked_items = new Array("337", "339", "338", "457", "458", "459", "342", "344", "343", "453");
	if(blocked_items.indexOf(this_formid) != -1)
	{  
		$('#field_198_1321').val(0);
		$('#field_198_1320').val(0);
		$('#field_199_1332').val(0);
		$('#field_199_1331').val(0);
		$('#field_198_1321').parent().parent().hide();
		$('#field_198_1320').parent().parent().hide();
		$('#field_199_1332').parent().parent().hide();
		$('#field_199_1331').parent().parent().hide();
	}

});
function validate<?php echo $this->id; ?>Item(e){
	var res = true;
	if( $(e).hasClass('required')){
		if($(e).val() == '' ){
			$(e).parent().find('.error-message').show();
			res = false;
		}else{
			$(e).parent().find('.error-message').hide();
		}
	}
	if( $(e).hasClass('email')){
		var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		if(!pattern.test($(e).val())){
			if(res){
				$(e).parent().find('.email-message').show();
				res = false;
			}else{
				$(e).parent().find('.email-message').hide();
				res = false;
			}
		}else{
			$(e).parent().find('.email-message').hide();
		}
	}
	if( $(e).hasClass('number')){
		if(!$.isNumeric($(e).val())){
			if(res){
				$(e).parent().find('.number-message').show();
				res = false;
			}else{
				$(e).parent().find('.number-message').hide();
				res = false;
			}
		}else{
			$(e).parent().find('.number-message').hide();
		}
	}
	return res;
}
</script>
<script type="text/javascript">
    $(document).ready(function () {
        window.scrollTo(0,0);
    });
</script>