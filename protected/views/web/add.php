<?php
$cs=Jii::app()->clientScript;
$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/scripts/jquery.maskedinput.min.js');

$locations = Location::model()->findAll();
$locations = Location::completelocation($locations);

Yii::app()->clientScript->registerScriptFile( 'http://maps.google.com/maps/api/js?sensor=false');
Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl.'/assets/scripts/locationpicker.js');


$h = new Html($model,$this,array(
	'id'=>'register-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('web/register'),
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
$h->begin();
echo $h->section(Jii::t('Member Form'),array(
	/*$h->finder('image',array(
		'only'=>1,
		'dimension'=>'400x400',
		'type'=>'jpg,png,gif',
	)),*/
	$h->text('firstname',array('placeholder'=>'Your First name')),
	$h->text('lastname',array('placeholder'=>'Your Last name')),
	$h->dropDownList('gender',Member::gender()->getList(),array('prompt'=>'Please Select Gender')),
	
	//$h->text('phone',array('placeholder'=>'Your Phone')),	
	$h->text('country_code',array('style'=>' width:50px;')),
	$h->text('mobile_code',array('style'=>'width:50px;')),
	$h->text('mobile_number',array('style'=>'width:85px;')),
	'<div class="clear"></div>',
	
	$h->dropDownList('country',Location::getCountry(),array('prompt'=>'Please Select Country')),
	$h->dropDownList('city',array(),array('prompt'=>'Please Select City')),
	//$h->dropDownList('area',array(),array('prompt'=>'Please Select Area')),
	
	$h->text('address',array('id'=>'address_mapping')),
	
	
	//$h->dropDownList('status',Member::status()->getList()),
	
));

echo $h->section(Jii::t('Member Photo'),array(
	$h->file('image',array('placeholder'=>'Upload Your Image')),
));
echo $h->section(Jii::t('Authentication'),array(
	$h->text('username',array('placeholder'=>'Your Username')),
	$h->text('email',array('placeholder'=>'Your Email address')),
	$h->password('password',array('placeholder'=>'Your Password')),
	$h->password('confirmpassword',array('placeholder'=>'Confirm your Password')),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>
<style type="text/css">
/*#body #register-form .j-form .field .label label{display:none!important;}*/
</style>

<script type="text/javascript">
	$(document).ready(function(){
		//$('#MemberForm_phone').mask('000-000-000000000');
		$('#MemberForm_country_code').parent().parent().css('width','50px');
		$('#MemberForm_country_code').parent().parent().css('float','left');
		$('#MemberForm_country_code').parent().parent().css('margin-left','10px');
		$('#MemberForm_mobile_code').parent().parent().css('width','50px');
		$('#MemberForm_mobile_code').parent().parent().css('float','left');
		$('#MemberForm_mobile_code').parent().parent().css('margin-left','10px');
		$('#MemberForm_mobile_number').parent().parent().css('width','100px');
		$('#MemberForm_mobile_number').parent().parent().css('float','left');
		$('#MemberForm_mobile_number').parent().parent().css('margin-left','10px');
		
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
		
		
		$('#MemberForm_country').change(function(){
			if($(this).val() != ''){
				ajaxSearch('getCities',{country:$(this).val()},function(data){
					var city = $('#MemberForm_city');
					var area = $('#MemberForm_area');
					city.empty();
					area.empty();
					city.append('<option value="">Please Select City</option>');
					area.append('<option value="">Please Select Area</option>');
					for(var i in data.list){
						if(data.list[i]['id'] != undefined){
							city.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
						}
					}
				});
			}else{
				var city = $('#MemberForm_city');
				var area = $('#MemberForm_area');
				city.empty();
				area.empty();
				city.append('<option value="">Please Select City</option>');
				area.append('<option value="">Please Select Area</option>');
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
					city.append('<option value="">Please Select Area</option>');
					if(data.list != ''){
						for(var i in data.list){
							if(data.list[i]['id'] != undefined){
								city.append('<option value="'+data.list[i]['id']+'">'+data.list[i]['name']+'</option>');
							}
						}
					}
				});
			}
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		$('#MemberForm_city').trigger('change');
		
		$('#MemberForm_area').change(function(){
			$("input#address_mapping").val(res[$(this).val()]);
			$(".pickermap").css("z-index","1000");
			$("input#address_mapping").trigger("focus").trigger("blur");
		});
		
		$(".pickermap").css("z-index","1000");
		$("input#address_mapping").trigger("focus").trigger("blur");
		
		
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