<div class="panel">
    <div class="logo"></div>
	<div class="form">
        <?php
		$h = new Html($model,$this,array(
			'id'=>'user-form',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
		));
		echo $h->text('username');
		echo $h->password('password');
		echo $h->dropDownList('language',Language::get());
		echo $h->submit(Jii::t('Login'));
		$h->end();
		?>
    </div>		
</div>