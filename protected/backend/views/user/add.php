<?php
$h = new Html($model,$this,array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'action'=>Jii::app()->createUrl('user/add',array('f'=>$this->family)),
	'htmlOptions'=>array(),
));
$h->begin();
echo $h->section(Jii::t('User Form'),array(
	$h->hidden('parent'),
	$h->finder('image',array(
		'only'=>1,
		'dimension'=>'400x400',
		'type'=>'jpg,png,gif',
	)),
	$h->text('firstname'),
	$h->text('lastname'),
	$h->dropDownList('status',User::status()->getList()),
	$h->dropDownList('color',Theme::color()),	
));
echo $h->section(Jii::t('Authentication'),array(
	$h->text('username'),
	$h->password('password'),
	$h->password('confirmpassword'),	
));
echo $h->submit(Jii::t('Save'));
$h->end();
?>

<script type="text/javascript">
$(document).ready(function() {
    $('#UserForm_color option').each(function(i,e) {
        $(e).css('background','#'+$(e).text());
		$(e).text( '#'+$(e).text() );
    });
	if( $('#UserForm_color option:selected').length > 0 ){
		$('#UserForm_color').css('background', '#'+$('#UserForm_color option:selected').val() );		
	}else{
		$('#UserForm_color').css('background', '#'+$('#UserForm_color option:nth-child(1)').val() );	
	}
	
	$('#UserForm_color').change(function(){
		$('#UserForm_color').css('background', '#'+$('#UserForm_color option:selected').val() );		
	});
});
</script>