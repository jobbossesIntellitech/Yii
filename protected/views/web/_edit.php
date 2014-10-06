<div class="list-page">
	<div class="list-subcategories">
		<div class="title-box" style="border:none;">
			<span class="titillium" style="font-size:20px;"><?php echo Jii::t('My Account'); ?></span> 
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
$locations = Location::model()->findAll();
$locations = Location::completelocation($locations);

$location = Location::model()->findByPk($model->locationid);
$area = 0;
$city = 0;
if($location->loc_type == 'Area'){
	$area = $location->loc_id;
	$city = Location::model()->findByPk($location->loc_parentid)->loc_id;
}else if($location->loc_type == 'City'){
	$city = $location->loc_id;
}

Yii::app()->clientScript->registerScriptFile( 'http://maps.google.com/maps/api/js?sensor=false');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets/scripts/locationpicker.js');

$h = new Html($model,$this,array(
	'id'=>'member-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('web/editprofile'),
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));

$user = Member::model()->findByPk(Jii::app()->user->id);
if(isset($user->mbr_image) && !empty($user->mbr_image)){
	$gal = '/assets/uploads/members/'.$user->mbr_image;
	if(isset($gal) && !empty($gal)){
		$img = new ImageProcessor(Jii::app()->params['rootPath'].$gal);
		$img->setIdentity('account_image2');
		$img->resizeInto(100,100);
		$gal_text = '<img style="float:left; padding-left:5px; top:5px; position:relative;" width="100" height="100" src="'.$img->output(IMAGETYPE_PNG).'"/>';
	}else{
		$gal_text = '<img style="float:left; padding-left:5px; top:5px; position:relative;" width="100" height="100" src="'.Jii::app()->baseUrl.'/assets/member.jpg"/>';
	}
						
	$image = '<div class="field">'.$gal_text.'
	<div class="clear"></div>
	</div>
	<div class="clear"></div>';
}else{
	$image = '<div class="field">
	<img style="float:left; padding-left:5px; top:5px; position:relative;" width="100" height="100" src="'.Jii::app()->baseUrl.'/assets/member.jpg" />
	<div class="clear"></div>
	</div>
	<div class="clear"></div>';
}

$h->begin();
echo $h->section(Jii::t('Member Form'),array(
	/*$h->finder('image',array(
		'only'=>1,
		'dimension'=>'400x400',
		'type'=>'jpg,png,gif',
	)),*/
	$h->hidden('id'),
	$h->hidden('locationid'),
	$h->text('firstname'),
	$h->text('lastname'),
	$h->dropDownList('gender',Member::gender()->getList(),array('prompt'=>'-- Select Gender --')),
	$h->text('phone'),	
	
	$h->dropDownList('country',Location::getCountry(),array()),
	$h->dropDownList('city',array(),array('prompt'=>'-- Please Select City --')),
	$h->dropDownList('area',array(),array('prompt'=>'-- Please Select Area --')),
	
	$h->text('address',array('id'=>'address_mapping')),
	//$h->dropDownList('status',Member::status()->getList()),

	$h->file('image'),
	$image,	
));


	
	
	
echo $h->section(Jii::t('Authentication'),array(
	$h->text('username'),
	$h->text('email'),
	$h->password('password'),
	$h->password('confirmpassword'),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>
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
		
		var selected_city = '<?php echo $city; ?>';
		var selected_area = '<?php echo $area; ?>';
		
		
		
		$(".pickermap").css("z-index","1000");
		$("input#address_mapping").trigger("focus").trigger("blur");
		
		$('#MemberForm_country').change(function(){
			if($(this).val() != ''){
				ajaxSearch('getCities',{country:$(this).val()},function(data){
					var city = $('#MemberForm_city');
					city.empty();
					city.append('<option value="">-- Please Select City --</option>');
					for(var i in data.list){
						city.append('<option value="'+i+'">'+data.list[i]+'</option>');
					}
					$('#MemberForm_city').val(selected_city);
					$('#MemberForm_city').trigger('change');
				});
			}
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		$('#MemberForm_country').trigger('change');
		
		$('#MemberForm_city').change(function(){
			if($(this).val() != ''){
				ajaxSearch('getCities',{country:$(this).val()},function(data){
					var city = $('#MemberForm_area');
					city.empty();
					city.append('<option value="">-- Please Select Area --</option>');
					for(var i in data.list){
						city.append('<option value="'+i+'">'+data.list[i]+'</option>');
					}
					$('#MemberForm_area').val(selected_area);
					$('#MemberForm_area').trigger('change');
				});
			}
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		$('#MemberForm_area').trigger('change');
		
		
		$('#MemberForm_area').change(function(){
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		
		$('#MemberForm_city').parent().parent().find('label').remove();
		$('#MemberForm_area').parent().parent().find('label').remove();
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
				$('.loader').show();
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