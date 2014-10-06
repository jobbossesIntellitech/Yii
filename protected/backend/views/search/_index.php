<div class="j-form">
	<div class="error err"><div style="" id="SearchForm_error" class="errorMessage"></div></div>
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div>Search Forms<div class="r"></div>
			</legend>
			<div class="fields">
				<div class="field">
				<?php
				$items = $this->forms;
				if(isset($items) && is_array($items) && !empty($items)){
					?>
					<div class="input">
						<select id="itemform_id" name="itemform_id">
							<option value=""> -- Please Select Item -- </option>
							<?php
							foreach($items AS $k=>$v){
								?>
								<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
								<?php
							}
							?>	
						</select>
					</div>
					<a href="javascript://" class="add_form_button" id="add_simple_line"><?php echo Jii::t('Add New Simple'); ?></a>
					<a href="javascript://" class="add_form_button" id="add_advanced_line"><?php echo Jii::t('Add New Advanced'); ?></a>
					<a href="javascript://" class="add_form_button" id="add_draft_line"><?php echo Jii::t('Add New Draft'); ?></a>
					<?php
				}
				?>				
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div>Simple Search Forms<div class="r"></div>
			</legend>
			<div class="fields">
				<div id="simple_searchform_container" class="new_form_container">
					
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
				
	<div class="clear"></div>
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div>Advanced Search Forms<div class="r"></div>
			</legend>
			<div class="fields">
			<div id="advanced_searchform_container" class="new_form_container">
				
			</div>
			<div class="clear"></div>
			</div>
		</fieldset>
	</div>
	
	<div class="outer-section floatting">
		<fieldset class="inner-section">
			<legend class="title">
				<div class="l"></div>Draft Search Forms<div class="r"></div>
			</legend>
			<div class="fields">
				<div id="draft_searchform_container" class="new_form_container">
					
				</div>
				<div class="clear"></div>
				</div>
		</fieldset>
	</div>
	
	
</div>



<script type="text/javascript">
var n = 1;

$('document').ready(function(){
	$('.j-form #itemform_id option').click(function(){
		document.location.href = '<?php echo Jii::app()->createUrl('search/index');?>?f='+$(this).val();
	});
	
	
	
	$('.j-form .add_form_button').on('click',function(){
		var type = $(this).attr('id').split('_')[1];
		var item_id = $(this).attr('id').split('_')[2];
		//alert(item_id);
		
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('search/getsearchline');?>?itemid="+item_id+'&n='+n,
			type: "POST",
			data: '',
			success: function(data){
				//alert(data);
				if(data != ' '){
					$('#'+type+'_searchform_container').append('<div id="searchform_line_'+item_id+'_'+n+'" class="searchform_line"></div>');
					$('#'+type+'_searchform_container #searchform_line_'+item_id+'_'+n).append(data);
					n++;
				}else{
					//alert("This Item doesn't have Form !!!");
					$('.errorMessage').html('');
					$('.errorMessage').append("This Item doesn't have Form !!!");
					$('.error').css('display','block');
					window.setTimeout('disappear()',4000);
				}
			},
		});
		
	});
	
	$('.j-form .typeid').click(function(){
		alert();
	});
	
	
	
});
function disappear(){
	$('.error').css('display','none');
}
</script>
<style type="text/css">
.j-form .outer-section.floatting{width:1000px;}
.j-form .field .input{margin-left:5px;}
.j-form .field .input select{width:250px;}
.error{display:none;}

.new_form_container{position:relative; height:300px; display:block; background:#ccc;}
.new_form_container .searchform_line{position:relative; height:60px; display:block; background:#999; border:1px solid #000; margin-top:2px;}

.add_form_button{float:left; margin:5px 15px; padding:5px; background:#000; color:#fff; font-size:18px;}

</style>