<?php
$form = '';
$form .= CHtml::beginForm(Jii::app()->createUrl('translation/index'),'GET',array('name'=>'form'));
	$form .= '<table border="0"><tr>';
	$form .= '<td>';
		$form .= CHtml::dropDownList('a',$this->application,$this->applications,array('onchange'=>'document.form.submit();'));
	$form .= '</td><td>';
		$form .= CHtml::dropDownList('k',$this->key,$this->keys,array('onchange'=>'document.form.submit();'));
	$form .= '</td>';
	$form .= '</tr></table>';
$form .= CHtml::endForm();
$option = Layout::bloc($form);
echo $option;

if(isset($languages) && is_array($languages) && !empty($languages)){
	echo CHtml::beginForm(Jii::app()->createUrl('translation/save',array('a'=>$this->application,'k'=>$this->key)),'POST');
	echo '<div class="j-form">
		<div class="outer-section">
			<fieldset class="inner-section">
				<legend class="title">
					<div class="l"></div>'.$this->application.'/'.$this->key.'<div class="r"></div>
				</legend>
				<div class="fields">';
					foreach($languages AS $id=>$name){
						$value = (isset($values[$id]))?$values[$id]:'';
						echo '
							<div class="field">
								<div class="label">
									<label for="'.$name.'">'.$name.'</label>
								</div>
								<div class="input">
									<input type="text" value="'.$value.'" id="'.$name.'" 
									name="data['.$this->application.']['.$this->key.']['.$id.']">
								</div>
								<div class="clear"></div>
							</div>
						';
					}
	echo '
				</div>
			</fieldset>
		</div>
		<div class="submit">
			<input type="reset" value="'.Jii::t('Reset').'" name="reset">&nbsp;&nbsp;
			<input type="submit" value="'.Jii::t('Save').'" name="submit">
		</div>
	</div>';
	echo CHtml::endForm();
}
?>