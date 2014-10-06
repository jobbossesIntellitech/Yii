<div class="form-generator" id="formGenerator_<?php echo $this->id; ?>">
	<form method="post" action="<?php echo Jii::app()->createUrl('formgenerator/save',array('id'=>$this->id)); ?>">
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
						echo $section['title'];
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
					echo '<table>'.$f.'</table>';
					?>
				</fieldset>
				<?php
			}
		}
		?>
		<div class="submit">
			<input type="submit" value="Send" id="send_<?php echo $this->id; ?>" />
			<div class="clear"></div>
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
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
				return res; 
			}
		});
		return res;
	});
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