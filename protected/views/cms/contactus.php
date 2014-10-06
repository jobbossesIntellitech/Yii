<?php echo $contact;?>
<div class="contact">
   <div class="row-2">
        <div class="form left">
        	<?php
			CHtml::$afterRequiredLabel = ' <span class="required">(required)</span> ';
			$h = new Html($model,$this,array(
				'id'=>'contact-form',
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
				'htmlOptions'=>array('action'=>Jii::app()->createUrl('cms/contactus')),
			));
			$h->begin();
			echo $h->text('name');
			echo '<div class="sep"></div>';
			echo $h->text('email');
			echo '<div class="sep"></div>';
			echo $h->text('subject');
			echo $h->textArea('body');
			echo $h->submit(Jii::t('Send Email'));
			$h->end();
			?>  
        </div>
        <div class="clr"></div>
    </div>
</div>
