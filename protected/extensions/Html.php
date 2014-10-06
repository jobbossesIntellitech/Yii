<?php
class Html{
	public $model,$form,$controller;
	protected static $id = 0;
	public function __construct($model,$controller,$options = array()){
		$this->model = $model;
		$this->controller = $controller;
		$this->form = $this->controller->beginWidget('CActiveForm',$options);
		
	}
	public function getId(){
		return self::$id++;	
	}
	public function begin(){
		echo '<div class="j-form">';	
	}
	public function end(){
		echo '<div class="clear"></div></div>';
		$this->controller->endWidget();	
	}
	/* User Administration Forms */
	private function _label($name,$option){
		$res = '<div class="label">';
			$res .= $this->form->labelEx($this->model,$name,$option);
		$res.= '</div>';
		return $res;
	}
	private function _error($name){
		$res = '<div class="error err">';
			$res .= $this->form->error($this->model,$name);
		$res.= '</div>';
		return $res;	
	}
	private function _input($input){
		$error = (strpos($input,'error'))?' error':'';
		$res = '<div class="input'.$error.'">';
			$res .= $input;
		$res.= '</div>';
		return $res;	
	}
	private function _field($field){
		$res = '<div class="field">';
			$res.= $field;
			$res.= '<div class="clear"></div>';
		$res.= '</div>';
		return $res;	
	}
	private function _display($option){
		$res = '';
		if(isset($option['display'])){
			$res.= '<div class="outer-display">';
				$res.= '<div class="inner-display">';
					$res.= $option['display'];
				$res.= '</div>';
			$res.= '</div>';
		}
		$res .= '<div class="clear"></div>';
		return $res;	
	}
	/*
	* Submit Button
	*/
	public function submit($name,$reset = true){
		$res = '<div class="clear"></div><div class="submit">';
		if($reset){
			$res .= '<input type="reset" name="reset" value="'.Jii::t('Reset').'">&nbsp;&nbsp;';
		}
		$res .= '<input type="submit" name="submit" value="'.$name.'"></div>';
		return $res;		
	}
	/*
	*  File Field
	*/
	public function file($name,$option = array()){
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = $this->_input($this->form->fileField($this->model,$name,$option));
		$error = $this->_error($name);
		return $this->_field($label.$display.$input.$error);	
	}
	/*
	*  Text Field
	*/
	public function text($name,$option = array()){
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = $this->_input($this->form->textField($this->model,$name,$option));
		$error = $this->_error($name);
		return $this->_field($label.$display.$input.$error);	
	}
	/*
	*  Hidden Field
	*/
	public function hidden($name,$option = array()){
		return $this->form->hiddenField($this->model,$name,$option);
	}
	/*
	*  Password Field
	*/
	public function password($name,$option = array()){
		$label = $this->_label($name,$option);
		$input = $this->_input($this->form->passwordField($this->model,$name,$option));
		$display = $this->_display($option);
		$error = $this->_error($name);
		return $this->_field($label.$display.$input.$error);	
	}
	/*
	*  Checkbox Field
	*/
	public function checkbox($name,$option = array()){
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = $this->_input($this->form->checkbox($this->model,$name,$option));
		$error = $this->_error($name);
		return $this->_field('<div class="checkbox">'.$input.$label.$display.$error.'</div>');	
	}
	/*
	*  Empty Area Field
	*/
	public function emptyArea($name,$option = array()){
		$label = $this->_label($name,$option);
		$input = $this->_input('');
		return $this->_field($label.$input);	
	}
	/*
	*  radio Field
	*/
	public function radio($name,$option = array()){
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = $this->_input($this->form->radio($this->model,$name,$option));
		$error = $this->_error($name);
		return $this->_field($input.$label.$display.$error);	
	}
	/*
	*  Select box Field
	*/
	public function dropDownList($name,$data,$option = array()){
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = $this->_input($this->form->dropDownList($this->model,$name,$data,$option));
		$error = $this->_error($name);
		return $this->_field($label.$display.$input.$error);	
	}
	/*
	*  Text Area Field
	*/
	public function textArea($name,$option = array()){
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = $this->_input($this->form->textArea($this->model,$name,$option));
		$error = $this->_error($name);
		return $this->_field($label.$display.$input.$error);	
	}
	/*
	* Multi File Field
	*/
	public function multiFile($name,$option = array()){
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = '<div class="file-container">';
			$input.= '<div class="file-field">';
			$hint = isset($option['hint'])?$option['hint']:'';
				$input.= $this->_input($this->form->fileField($this->model,'[]'.$name,$option).'&nbsp;'.$hint);
				$input.= '<a href="javascript://" id="addnew" class="opt">'.Jii::t('Add New').'</a>';
			$input.= '</div>';
		$input.= '</div>';
		$error = $this->_error($name);
		$script = '
			<script type="text/javascript">
			var img = 0;
			$(document).ready(function(){
				$("#addnew").click(function(){
					img++;						
					var file = \''.$this->_input($this->form->fileField($this->model,'[]'.$name,$option).'&nbsp;'.$hint).'<a href="javascript://" class="rmv opt">'.Jii::t('Delete').'</a>\';
					var div = $("<div/>");
					div.addClass("file-field");
					var id = "container_"+img;
					div.attr("id",id);
					div.append(file);
					$(".file-container").append(div);
					$("#"+id).find("a.rmv").attr("onclick","removeFileField(\""+id+"\")");
				});						   
			});
			function removeFileField(id){
				$("#"+id).remove();	
			}
			</script>
		';
		return $this->_field($label.$display.$input.$error).$script;	
	}
	/*
	*  Tags Input Fields
	*/
	public function tags($name,$option = array(),$tagsoption = array()){
		$cs = Jii::app()->clientScript;
		$cs->registerCssFile(Yii::app()->baseUrl .'/assets/scripts/ui.css');
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/ui.js');
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/jquery.tagsinput.min.js');
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$id = 'tagsinput'.$this->getId();
		$option['id'] = (isset($option['id']))?$option['id']:$id;
		$input = $this->_input($this->form->textField($this->model,$name,$option));
		$error = $this->_error($name);
		$script = '
			<script type="text/javascript">
				$(document).ready(function(){
					if($("#'.$option['id'].'").length > 0){
						$("#'.$option['id'].'").tagsInput({
							autocomplete_url : '.(isset($tagsoption['autocomplete_url'])?'"'.$tagsoption['autocomplete_url'].'"':'null').', /* URL */
						   	autocomplete : '.(isset($tagsoption['autocomplete'])?$tagsoption['autocomplete']:'{selectFirst: false}').', /* {option:value,option:value,....} */
						   	height : "'.(isset($tagsoption['height'])?$tagsoption['height']:'100px').'",
						   	width : "'.(isset($tagsoption['width'])?$tagsoption['width']:'300px').'",
						   	interactive :'.(isset($tagsoption['interactive'])?$tagsoption['interactive']:'true').',
						   	defaultText : "'.(isset($tagsoption['defaultText'])?$tagsoption['defaultText']:'add a tag').'",
						   	onAddTag : '.(isset($tagsoption['onAddTag'])?$tagsoption['onAddTag']:'function(){}').',
						   	onRemoveTag : '.(isset($tagsoption['onRemoveTag'])?$tagsoption['onRemoveTag']:'function(){}').',
						   	onChange : '.(isset($tagsoption['onChange'])?$tagsoption['onChange']:'function(){}').',
						   	removeWithBackspace : '.(isset($tagsoption['removeWithBackspace'])?$tagsoption['removeWithBackspace']:'true').',
						   	minChars : '.(isset($tagsoption['minChars'])?$tagsoption['minChars']:'0').',
						   	maxChars : '.(isset($tagsoption['maxChars'])?$tagsoption['maxChars']:'0').',
						   	placeholderColor : "'.(isset($tagsoption['placeholderColor'])?$tagsoption['placeholderColor']:'#666666').'"					
						});
					}
				});
			</script>
		';
		$res = $this->_field($label.$display.$input.$error).$script;
		return $res;
	}
	/*
	*  Date Fields
	*/
	public function date($name,$option = array(),$dateoption = array()){
		$cs=Jii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/jldate/jldate.js');
		$cs->registerCssFile(Yii::app()->baseUrl .'/assets/jldate/jldate.css');
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$id = 'jldate'.$this->getId();
		$option['readonly'] = 'readonly';
		$option['id'] = (isset($option['id']))?$option['id']:$id;
		$input = $this->_input($this->form->textField($this->model,$name,$option));
		$error = $this->_error($name);
		$dateoption['date_format'] = isset($dateoption['date_format'])?$dateoption['date_format']:'yyyy-mm-dd';
		$dateoption['time_format'] = isset($dateoption['time_format'])?$dateoption['time_format']:'hh:ii:ss';
		$dateoption['has_time'] = isset($dateoption['has_time'])?$dateoption['has_time']:'false';
		$dateoption['from_date'] = isset($dateoption['from_date'])?$dateoption['from_date']:'null';
		$dateoption['to_date'] = isset($dateoption['to_date'])?$dateoption['to_date']:'null';
		$dateoption['display_type'] = isset($dateoption['display_type'])?$dateoption['display_type']:'normal';
		$dateoption['view_footer'] = isset($dateoption['view_footer'])?$dateoption['view_footer']:'true';
		$dateoption['clear_word'] = isset($dateoption['clear_word'])?$dateoption['clear_word']:Jii::t('Clear');
		$dateoption['close_word'] = isset($dateoption['close_word'])?$dateoption['close_word']:Jii::t('Close');
		$dateoption['today_word'] = isset($dateoption['today_word'])?$dateoption['today_word']:Jii::t('Today');
		$dateoption['afterClickDate'] = isset($dateoption['afterClickDate'])?$dateoption['afterClickDate']:'function(){}';
		$script = '
			<script type="text/javascript">
				$(document).ready(function(){
					if($("#'.$option['id'].'").length > 0){
						$("#'.$option['id'].'").jldate(
						{
							date_format     : "'.$dateoption['date_format'].'",
							time_format     : "'.$dateoption['time_format'].'",
							has_time        : '.$dateoption['has_time'].',
							months          : ["'.Jii::t('January').'","'.Jii::t('February').'","'.Jii::t('March').'",
												"'.Jii::t('April').'","'.Jii::t('May').'","'.Jii::t('June').'",
												"'.Jii::t('July').'","'.Jii::t('August').'","'.Jii::t('September').'",
												"'.Jii::t('October').'","'.Jii::t('November').'","'.Jii::t('December').'"],
							days            : ["'.Jii::t('Mo').'","'.Jii::t('Tu').'","'.Jii::t('We').'","'.Jii::t('Th').'","'.Jii::t('Fr').'","'.Jii::t('Sa').'","'.Jii::t('Su').'"],
							times           : ["'.Jii::t('Hour').'","'.Jii::t('Minute').'","'.Jii::t('Second').'"],
							from_date       :  '.$dateoption['from_date'].',
							to_date         :  '.$dateoption['to_date'].',
							display_type    : "'.$dateoption['display_type'].'", // normal,slide,fade
							view_footer     : '.$dateoption['view_footer'].',
							clear_word      : "'.$dateoption['clear_word'].'",
							close_word      : "'.$dateoption['close_word'].'",
							today_word      : "'.$dateoption['today_word'].'",
							afterClickDate  : '.$dateoption['afterClickDate'].'
						});
					}						   
				});
			</script>
		';
		$res = $this->_field($label.$display.$input.$error).$script;
		return $res;
	}
	/*
	*  Date Time Fields
	*/
	public function dateTime($name,$option = array(),$dateoption = array()){
		$hours = array();
		$hours['01'] = '01';
		$hours['02'] = '02';
		$hours['03'] = '03';
		$hours['04'] = '04';
		$hours['05'] = '05';
		$hours['06'] = '06';
		$hours['07'] = '07';
		$hours['08'] = '08';
		$hours['09'] = '09';
		$hours['10'] = '10';
		$hours['11'] = '11';
		$hours['12'] = '12';
		$minutes = array();
		$minutes['00'] = '00';
		$minutes['05'] = '05';
		$minutes['10'] = '10';
		$minutes['15'] = '15';
		$minutes['20'] = '20';
		$minutes['25'] = '25';
		$minutes['30'] = '30';
		$minutes['35'] = '35';
		$minutes['40'] = '40';
		$minutes['45'] = '45';
		$minutes['50'] = '50';
		$minutes['55'] = '55';
		$parts = array();
		$parts['AM'] = 'AM';
		$parts['PM'] = 'PM';
		$cs=Jii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/jldate/jldate.js');
		$cs->registerCssFile(Yii::app()->baseUrl .'/assets/jldate/jldate.css');
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$id = 'jldate'.$this->getId();
		$option['readonly'] = 'readonly';
		$option['id'] = (isset($option['id']))?$option['id']:$id;
		$input = $this->form->textField($this->model,$name,$option);
		$input .= $this->form->dropdownList($this->model,$name.'_h',$hours,array('style'=>'width:50px;'));
		$input .= $this->form->dropdownList($this->model,$name.'_m',$minutes,array('style'=>'width:50px;'));
		$input .= $this->form->dropdownList($this->model,$name.'_p',$parts,array('style'=>'width:50px;'));
		$input = $this->_input($input);
		$error = $this->_error($name);
		$dateoption['date_format'] = isset($dateoption['date_format'])?$dateoption['date_format']:'yyyy-mm-dd';
		$dateoption['time_format'] = isset($dateoption['time_format'])?$dateoption['time_format']:'hh:mm:ss';
		$dateoption['has_time'] = isset($dateoption['has_time'])?$dateoption['has_time']:'false';
		$dateoption['from_date'] = isset($dateoption['from_date'])?$dateoption['from_date']:'null';
		$dateoption['to_date'] = isset($dateoption['to_date'])?$dateoption['to_date']:'null';
		$dateoption['display_type'] = isset($dateoption['display_type'])?$dateoption['display_type']:'normal';
		$dateoption['view_footer'] = isset($dateoption['view_footer'])?$dateoption['view_footer']:'true';
		$dateoption['clear_word'] = isset($dateoption['clear_word'])?$dateoption['clear_word']:Jii::t('Clear');
		$dateoption['close_word'] = isset($dateoption['close_word'])?$dateoption['close_word']:Jii::t('Close');
		$dateoption['today_word'] = isset($dateoption['today_word'])?$dateoption['today_word']:Jii::t('Today');
		$dateoption['afterClickDate'] = isset($dateoption['afterClickDate'])?$dateoption['afterClickDate']:'function(){}';
		$script = '
			<script type="text/javascript">
				$(document).ready(function(){
					if($("#'.$option['id'].'").length > 0){
						$("#'.$option['id'].'").jldate(
						{
							date_format     : "'.$dateoption['date_format'].'",
							time_format     : "'.$dateoption['time_format'].'",
							has_time        : '.$dateoption['has_time'].',
							months          : ["'.Jii::t('January').'","'.Jii::t('February').'","'.Jii::t('March').'",
												"'.Jii::t('April').'","'.Jii::t('May').'","'.Jii::t('June').'",
												"'.Jii::t('July').'","'.Jii::t('August').'","'.Jii::t('September').'",
												"'.Jii::t('October').'","'.Jii::t('November').'","'.Jii::t('December').'"],
							days            : ["'.Jii::t('Mo').'","'.Jii::t('Tu').'","'.Jii::t('We').'","'.Jii::t('Th').'","'.Jii::t('Fr').'","'.Jii::t('Sa').'","'.Jii::t('Su').'"],
							from_date       :  '.$dateoption['from_date'].',
							to_date         :  '.$dateoption['to_date'].',
							display_type    : "'.$dateoption['display_type'].'", // normal,slide,fade
							view_footer     : '.$dateoption['view_footer'].',
							clear_word      : "'.$dateoption['clear_word'].'",
							close_word      : "'.$dateoption['close_word'].'",
							today_word      : "'.$dateoption['today_word'].'",
							afterClickDate  : '.$dateoption['afterClickDate'].'
						});
					}						   
				});
			</script>
		';
		$res = $this->_field($label.$display.$input.$error).$script;
		return $res;
	}
	/*
	*  Time zone Fields
	*/
	public function timeZone($name,$option=array()){
		$list = array();
		$list["Pacific/Pago_Pago"] = "(GMT-1100) American Samoa Time";
		$list["Pacific/Niue"] = "(GMT-1100) Niue Time";
		$list["Pacific/Midway"] = "(GMT-1100) United States Minor Outlying Islands (Midway) Time";
		$list["Pacific/Rarotonga"] = "(GMT-1000) Cook Islands Time";
		$list["Pacific/Tahiti"] = "(GMT-1000) French Polynesia (Tahiti) Time";
		$list["Pacific/Honolulu"] = "(GMT-1000) United States (Honolulu) Time";
		$list["Pacific/Johnston"] = "(GMT-1000) United States Minor Outlying Islands (Johnston) Time";
		$list["Pacific/Marquesas"] = "(GMT-0930) French Polynesia (Marquesas) Time";
		$list["Pacific/Gambier"] = "(GMT-0900) French Polynesia (Gambier) Time";
		$list["Pacific/Pitcairn"] = "(GMT-0800) Pitcairn Time";
		$list["America/Anchorage"] = "(GMT-0800) United States (Anchorage) Time";
		$list["America/Dawson_Creek"] = "(GMT-0700) Canada (Dawson Creek) Time";
		$list["America/Vancouver"] = "(GMT-0700) Canada (Vancouver) Time";
		$list["America/Whitehorse"] = "(GMT-0700) Canada (Whitehorse) Time";
		$list["America/Hermosillo"] = "(GMT-0700) Mexico (Hermosillo) Time";
		$list["America/Tijuana"] = "(GMT-0700) Mexico (Tijuana) Time";
		$list["America/Los_Angeles"] = "(GMT-0700) United States (Los Angeles) Time";
		$list["America/Phoenix"] = "(GMT-0700) United States (Phoenix) Time";
		$list["America/Belize"] = "(GMT-0600) Belize Time";
		$list["America/Edmonton"] = "(GMT-0600) Canada (Edmonton) Time";
		$list["America/Regina"] = "(GMT-0600) Canada (Regina) Time";
		$list["America/Yellowknife"] = "(GMT-0600) Canada (Yellowknife) Time";
		$list["America/Costa_Rica"] = "(GMT-0600) Costa Rica Time";
		$list["Pacific/Galapagos"] = "(GMT-0600) Ecuador (Galapagos) Time";
		$list["America/El_Salvador"] = "(GMT-0600) El Salvador Time";
		$list["America/Guatemala"] = "(GMT-0600) Guatemala Time";
		$list["America/Tegucigalpa"] = "(GMT-0600) Honduras Time";
		$list["America/Mazatlan"] = "(GMT-0600) Mexico (Mazatlan) Time";
		$list["America/Managua"] = "(GMT-0600) Nicaragua Time";
		$list["America/Denver"] = "(GMT-0600) United States (Denver) Time";
		$list["America/Winnipeg"] = "(GMT-0500) Canada (Winnipeg) Time";
		$list["America/Cayman"] = "(GMT-0500) Cayman Islands Time";
		$list["Pacific/Easter"] = "(GMT-0500) Chile (Easter) Time";
		$list["America/Bogota"] = "(GMT-0500) Colombia Time";
		$list["America/Guayaquil"] = "(GMT-0500) Ecuador (Guayaquil) Time";
		$list["America/Port-au-Prince"] = "(GMT-0500) Haiti Time";
		$list["America/Jamaica"] = "(GMT-0500) Jamaica Time";
		$list["America/Mexico_City"] = "(GMT-0500) Mexico (Mexico City) Time";
		$list["America/Panama"] = "(GMT-0500) Panama Time";
		$list["America/Lima"] = "(GMT-0500) Peru Time";
		$list["America/Chicago"] = "(GMT-0500) United States (Chicago) Time";
		$list["America/Caracas"] = "(GMT-0430) Venezuela Time";
		$list["America/Anguilla"] = "(GMT-0400) Anguilla Time";
		$list["America/Antigua"] = "(GMT-0400) Antigua and Barbuda Time";
		$list["America/Aruba"] = "(GMT-0400) Aruba Time";
		$list["America/Nassau"] = "(GMT-0400) Bahamas Time";
		$list["America/Barbados"] = "(GMT-0400) Barbados Time";
		$list["America/La_Paz"] = "(GMT-0400) Bolivia Time";
		$list["America/Boa_Vista"] = "(GMT-0400) Brazil (Boa Vista) Time";
		$list["America/Campo_Grande"] = "(GMT-0400) Brazil (Campo Grande) Time";
		$list["America/Cuiaba"] = "(GMT-0400) Brazil (Cuiaba) Time";
		$list["America/Manaus"] = "(GMT-0400) Brazil (Manaus) Time";
		$list["America/Porto_Velho"] = "(GMT-0400) Brazil (Porto Velho) Time";
		$list["America/Rio_Branco"] = "(GMT-0400) Brazil (Rio Branco) Time";
		$list["America/Tortola"] = "(GMT-0400) British Virgin Islands Time";
		$list["America/Iqaluit"] = "(GMT-0400) Canada (Iqaluit) Time";
		$list["America/Montreal"] = "(GMT-0400) Canada (Montreal) Time";
		$list["America/Toronto"] = "(GMT-0400) Canada (Toronto) Time";
		$list["America/Havana"] = "(GMT-0400) Cuba Time";
		$list["America/Dominica"] = "(GMT-0400) Dominica Time";
		$list["America/Santo_Domingo"] = "(GMT-0400) Dominican Republic Time";
		$list["America/Grenada"] = "(GMT-0400) Grenada Time";
		$list["America/Guadeloupe"] = "(GMT-0400) Guadeloupe Time";
		$list["America/Guyana"] = "(GMT-0400) Guyana Time";
		$list["America/Martinique"] = "(GMT-0400) Martinique Time";
		$list["America/Montserrat"] = "(GMT-0400) Montserrat Time";
		$list["America/Curacao"] = "(GMT-0400) Netherlands Antilles Time";
		$list["America/Puerto_Rico"] = "(GMT-0400) Puerto Rico Time";
		$list["America/St_Kitts"] = "(GMT-0400) Saint Kitts and Nevis Time";
		$list["America/St_Lucia"] = "(GMT-0400) Saint Lucia Time";
		$list["America/St_Vincent"] = "(GMT-0400) Saint Vincent and the Grenadines Time";
		$list["America/Port_of_Spain"] = "(GMT-0400) Trinidad and Tobago Time";
		$list["America/Grand_Turk"] = "(GMT-0400) Turks and Caicos Islands Time";
		$list["America/St_Thomas"] = "(GMT-0400) U.S. Virgin Islands Time";
		$list["America/New_York"] = "(GMT-0400) United States (New York) Time";
		$list["Antarctica/Palmer"] = "(GMT-0300) Antarctica (Palmer) Time";
		$list["Antarctica/Rothera"] = "(GMT-0300) Antarctica (Rothera) Time";
		$list["America/Argentina/Buenos_Aires"] = "(GMT-0300) Argentina (Buenos Aires) Time";
		$list["Atlantic/Bermuda"] = "(GMT-0300) Bermuda Time";
		$list["America/Araguaina"] = "(GMT-0300) Brazil (Araguaina) Time";
		$list["America/Bahia"] = "(GMT-0300) Brazil (Bahia) Time";
		$list["America/Belem"] = "(GMT-0300) Brazil (Belem) Time";
		$list["America/Fortaleza"] = "(GMT-0300) Brazil (Fortaleza) Time";
		$list["America/Maceio"] = "(GMT-0300) Brazil (Maceio) Time";
		$list["America/Recife"] = "(GMT-0300) Brazil (Recife) Time";
		$list["America/Sao_Paulo"] = "(GMT-0300) Brazil (Sao Paulo) Time";
		$list["America/Halifax"] = "(GMT-0300) Canada (Halifax) Time";
		$list["America/Santiago"] = "(GMT-0300) Chile (Santiago) Time";
		$list["Atlantic/Stanley"] = "(GMT-0300) Falkland Islands Time";
		$list["America/Cayenne"] = "(GMT-0300) French Guiana Time";
		$list["America/Thule"] = "(GMT-0300) Greenland (Thule) Time";
		$list["America/Asuncion"] = "(GMT-0300) Paraguay Time";
		$list["America/Paramaribo"] = "(GMT-0300) Suriname Time";
		$list["America/St_Johns"] = "(GMT-0230) Canada (St. John's) Time";
		$list["America/Noronha"] = "(GMT-0200) Brazil (Noronha) Time";
		$list["America/Godthab"] = "(GMT-0200) Greenland (Godthab) Time";
		$list["America/Miquelon"] = "(GMT-0200) Saint Pierre and Miquelon Time";
		$list["Atlantic/South_Georgia"] = "(GMT-0200) South Georgia and the South Sandwich Islands Time";
		$list["America/Montevideo"] = "(GMT-0200) Uruguay Time";
		$list["Atlantic/Cape_Verde"] = "(GMT-0100) Cape Verde Time";
		$list["Africa/Ouagadougou"] = "(GMT+0000) Burkina Faso Time";
		$list["Africa/Banjul"] = "(GMT+0000) Gambia Time";
		$list["Africa/Accra"] = "(GMT+0000) Ghana Time";
		$list["America/Danmarkshavn"] = "(GMT+0000) Greenland (Danmarkshavn) Time";
		$list["America/Scoresbysund"] = "(GMT+0000) Greenland (Scoresbysund) Time";
		$list["Africa/Conakry"] = "(GMT+0000) Guinea Time";
		$list["Africa/Bissau"] = "(GMT+0000) Guinea-Bissau Time";
		$list["Atlantic/Reykjavik"] = "(GMT+0000) Iceland Time";
		$list["Africa/Abidjan"] = "(GMT+0000) Ivory Coast Time";
		$list["Africa/Monrovia"] = "(GMT+0000) Liberia Time";
		$list["Africa/Bamako"] = "(GMT+0000) Mali Time";
		$list["Africa/Nouakchott"] = "(GMT+0000) Mauritania Time";
		$list["Africa/Casablanca"] = "(GMT+0000) Morocco Time";
		$list["Atlantic/Azores"] = "(GMT+0000) Portugal (Azores) Time";
		$list["Atlantic/St_Helena"] = "(GMT+0000) Saint Helena Time";
		$list["Africa/Sao_Tome"] = "(GMT+0000) Sao Tome and Principe Time";
		$list["Africa/Dakar"] = "(GMT+0000) Senegal Time";
		$list["Africa/Freetown"] = "(GMT+0000) Sierra Leone Time";
		$list["Africa/Lome"] = "(GMT+0000) Togo Time";
		$list["Africa/El_Aaiun"] = "(GMT+0000) Western Sahara Time";
		$list["Etc/GMT"] = "(GMT+0000) World (GMT) Time";
		$list["Africa/Algiers"] = "(GMT+0100) Algeria Time";
		$list["Africa/Luanda"] = "(GMT+0100) Angola Time";
		$list["Africa/Porto-Novo"] = "(GMT+0100) Benin Time";
		$list["Africa/Douala"] = "(GMT+0100) Cameroon Time";
		$list["Africa/Bangui"] = "(GMT+0100) Central African Republic Time";
		$list["Africa/Ndjamena"] = "(GMT+0100) Chad Time";
		$list["Africa/Brazzaville"] = "(GMT+0100) Congo - Brazzaville Time";
		$list["Africa/Kinshasa"] = "(GMT+0100) Congo - Kinshasa (Kinshasa) Time";
		$list["Africa/Malabo"] = "(GMT+0100) Equatorial Guinea Time";
		$list["Atlantic/Faroe"] = "(GMT+0100) Faroe Islands Time";
		$list["Africa/Libreville"] = "(GMT+0100) Gabon Time";
		$list["Europe/Dublin"] = "(GMT+0100) Ireland Time";
		$list["Africa/Niamey"] = "(GMT+0100) Niger Time";
		$list["Africa/Lagos"] = "(GMT+0100) Nigeria Time";
		$list["Europe/Lisbon"] = "(GMT+0100) Portugal (Lisbon) Time";
		$list["Atlantic/Canary"] = "(GMT+0100) Spain (Canary) Time";
		$list["Africa/Tunis"] = "(GMT+0100) Tunisia Time";
		$list["Europe/London"] = "(GMT+0100) United Kingdom Time";
		$list["Europe/Tirane"] = "(GMT+0200) Albania Time";
		$list["Europe/Andorra"] = "(GMT+0200) Andorra Time";
		$list["Europe/Vienna"] = "(GMT+0200) Austria Time";
		$list["Europe/Brussels"] = "(GMT+0200) Belgium Time";
		$list["Europe/Prague"] = "(GMT+0200) Czech Republic Time";
		$list["Europe/Copenhagen"] = "(GMT+0200) Denmark Time";
		$list["Africa/Cairo"] = "(GMT+0200) Egypt Time";
		$list["Europe/Paris"] = "(GMT+0200) France Time";
		$list["Europe/Berlin"] = "(GMT+0200) Germany Time";
		$list["Europe/Gibraltar"] = "(GMT+0200) Gibraltar Time";
		$list["Europe/Budapest"] = "(GMT+0200) Hungary Time";
		$list["Asia/Jerusalem"] = "(GMT+0200) Israel Time";
		$list["Europe/Rome"] = "(GMT+0200) Italy Time";
		$list["Europe/Vaduz"] = "(GMT+0200) Liechtenstein Time";
		$list["Europe/Luxembourg"] = "(GMT+0200) Luxembourg Time";
		$list["Europe/Malta"] = "(GMT+0200) Malta Time";
		$list["Europe/Monaco"] = "(GMT+0200) Monaco Time";
		$list["Africa/Windhoek"] = "(GMT+0200) Namibia Time";
		$list["Europe/Amsterdam"] = "(GMT+0200) Netherlands Time";
		$list["Europe/Oslo"] = "(GMT+0200) Norway Time";
		$list["Asia/Gaza"] = "(GMT+0200) Palestinian Territory Time";
		$list["Europe/Warsaw"] = "(GMT+0200) Poland Time";
		$list["Europe/Belgrade"] = "(GMT+0200) Serbia Time";
		$list["Africa/Ceuta"] = "(GMT+0200) Spain (Ceuta) Time";
		$list["Europe/Madrid"] = "(GMT+0200) Spain (Madrid) Time";
		$list["Europe/Stockholm"] = "(GMT+0200) Sweden Time";
		$list["Europe/Zurich"] = "(GMT+0200) Switzerland Time";
		$list["Africa/Harare"] = "(GMT+0200) Zimbabwe Time";
		$list["Antarctica/Syowa"] = "(GMT+0300) Antarctica (Syowa) Time";
		$list["Asia/Bahrain"] = "(GMT+0300) Bahrain Time";
		$list["Europe/Minsk"] = "(GMT+0300) Belarus Time";
		$list["Europe/Sofia"] = "(GMT+0300) Bulgaria Time";
		$list["Indian/Comoro"] = "(GMT+0300) Comoros Time";
		$list["Asia/Nicosia"] = "(GMT+0300) Cyprus Time";
		$list["Africa/Djibouti"] = "(GMT+0300) Djibouti Time";
		$list["Africa/Asmara"] = "(GMT+0300) Eritrea Time";
		$list["Europe/Tallinn"] = "(GMT+0300) Estonia Time";
		$list["Africa/Addis_Ababa"] = "(GMT+0300) Ethiopia Time";
		$list["Europe/Helsinki"] = "(GMT+0300) Finland Time";
		$list["Europe/Athens"] = "(GMT+0300) Greece Time";
		$list["Asia/Baghdad"] = "(GMT+0300) Iraq Time";
		$list["Asia/Amman"] = "(GMT+0300) Jordan Time";
		$list["Africa/Nairobi"] = "(GMT+0300) Kenya Time";
		$list["Asia/Kuwait"] = "(GMT+0300) Kuwait Time";
		$list["Europe/Riga"] = "(GMT+0300) Latvia Time";
		$list["Asia/Beirut"] = "(GMT+0300) Lebanon Time";
		$list["Europe/Vilnius"] = "(GMT+0300) Lithuania Time";
		$list["Indian/Antananarivo"] = "(GMT+0300) Madagascar Time";
		$list["Indian/Mayotte"] = "(GMT+0300) Mayotte Time";
		$list["Europe/Chisinau"] = "(GMT+0300) Moldova Time";
		$list["Asia/Qatar"] = "(GMT+0300) Qatar Time";
		$list["Europe/Bucharest"] = "(GMT+0300) Romania Time";
		$list["Europe/Kaliningrad"] = "(GMT+0300) Russia (Kaliningrad) Time";
		$list["Asia/Riyadh"] = "(GMT+0300) Saudi Arabia Time";
		$list["Africa/Mogadishu"] = "(GMT+0300) Somalia Time";
		$list["Africa/Khartoum"] = "(GMT+0300) Sudan Time";
		$list["Asia/Damascus"] = "(GMT+0300) Syria Time";
		$list["Africa/Dar_es_Salaam"] = "(GMT+0300) Tanzania Time";
		$list["Europe/Istanbul"] = "(GMT+0300) Turkey Time";
		$list["Africa/Kampala"] = "(GMT+0300) Uganda Time";
		$list["Europe/Kiev"] = "(GMT+0300) Ukraine (Kiev) Time";
		$list["Asia/Aden"] = "(GMT+0300) Yemen Time";
		$list["Asia/Tehran"] = "(GMT+0330) Iran Time";
		$list["Asia/Yerevan"] = "(GMT+0400) Armenia Time";
		$list["Asia/Tbilisi"] = "(GMT+0400) Georgia Time";
		$list["Indian/Mauritius"] = "(GMT+0400) Mauritius Time";
		$list["Asia/Muscat"] = "(GMT+0400) Oman Time";
		$list["Indian/Reunion"] = "(GMT+0400) Reunion Time";
		$list["Europe/Moscow"] = "(GMT+0400) Russia (Moscow) Time";
		$list["Europe/Samara"] = "(GMT+0400) Russia (Samara) Time";
		$list["Indian/Mahe"] = "(GMT+0400) Seychelles Time";
		$list["Asia/Dubai"] = "(GMT+0400) United Arab Emirates Time";
		$list["Asia/Kabul"] = "(GMT+0430) Afghanistan Time";
		$list["Antarctica/Mawson"] = "(GMT+0500) Antarctica (Mawson) Time";
		$list["Asia/Baku"] = "(GMT+0500) Azerbaijan Time";
		$list["Indian/Kerguelen"] = "(GMT+0500) French Southern Territories Time";
		$list["Asia/Aqtau"] = "(GMT+0500) Kazakhstan (Aqtau) Time";
		$list["Asia/Aqtobe"] = "(GMT+0500) Kazakhstan (Aqtobe) Time";
		$list["Indian/Maldives"] = "(GMT+0500) Maldives Time";
		$list["Asia/Karachi"] = "(GMT+0500) Pakistan Time";
		$list["Asia/Dushanbe"] = "(GMT+0500) Tajikistan Time";
		$list["Asia/Ashgabat"] = "(GMT+0500) Turkmenistan Time";
		$list["Asia/Tashkent"] = "(GMT+0500) Uzbekistan (Tashkent) Time";
		$list["Asia/Calcutta"] = "(GMT+0530) India Time";
		$list["Asia/Colombo"] = "(GMT+0530) Sri Lanka Time";
		$list["Asia/Katmandu"] = "(GMT+0545) Nepal Time";
		$list["Antarctica/Vostok"] = "(GMT+0600) Antarctica (Vostok) Time";
		$list["Asia/Dhaka"] = "(GMT+0600) Bangladesh Time";
		$list["Asia/Thimphu"] = "(GMT+0600) Bhutan Time";
		$list["Indian/Chagos"] = "(GMT+0600) British Indian Ocean Territory Time";
		$list["Asia/Almaty"] = "(GMT+0600) Kazakhstan (Almaty) Time";
		$list["Asia/Bishkek"] = "(GMT+0600) Kyrgyzstan Time";
		$list["Asia/Yekaterinburg"] = "(GMT+0600) Russia (Yekaterinburg) Time";
		$list["Indian/Cocos"] = "(GMT+0630) Cocos Islands Time";
		$list["Asia/Rangoon"] = "(GMT+0630) Myanmar Time";
		$list["Antarctica/Davis"] = "(GMT+0700) Antarctica (Davis) Time";
		$list["Asia/Phnom_Penh"] = "(GMT+0700) Cambodia Time";
		$list["Indian/Christmas"] = "(GMT+0700) Christmas Island Time";
		$list["Asia/Jakarta"] = "(GMT+0700) Indonesia (Jakarta) Time";
		$list["Asia/Vientiane"] = "(GMT+0700) Laos Time";
		$list["Asia/Hovd"] = "(GMT+0700) Mongolia (Hovd) Time";
		$list["Asia/Omsk"] = "(GMT+0700) Russia (Omsk) Time";
		$list["Asia/Bangkok"] = "(GMT+0700) Thailand Time";
		$list["Asia/Saigon"] = "(GMT+0700) Vietnam Time";
		$list["Antarctica/Casey"] = "(GMT+0800) Antarctica (Casey) Time";
		$list["Australia/Perth"] = "(GMT+0800) Australia (Perth) Time";
		$list["Asia/Brunei"] = "(GMT+0800) Brunei Time";
		$list["Asia/Shanghai"] = "(GMT+0800) China (Shanghai) Time";
		$list["Asia/Hong_Kong"] = "(GMT+0800) Hong Kong SAR China Time";
		$list["Asia/Makassar"] = "(GMT+0800) Indonesia (Makassar) Time";
		$list["Asia/Macau"] = "(GMT+0800) Macau SAR China Time";
		$list["Asia/Kuala_Lumpur"] = "(GMT+0800) Malaysia (Kuala Lumpur) Time";
		$list["Asia/Choibalsan"] = "(GMT+0800) Mongolia (Choibalsan) Time";
		$list["Asia/Ulaanbaatar"] = "(GMT+0800) Mongolia (Ulaanbaatar) Time";
		$list["Asia/Manila"] = "(GMT+0800) Philippines Time";
		$list["Asia/Krasnoyarsk"] = "(GMT+0800) Russia (Krasnoyarsk) Time";
		$list["Asia/Singapore"] = "(GMT+0800) Singapore Time";
		$list["Asia/Taipei"] = "(GMT+0800) Taiwan Time";
		$list["Asia/Dili"] = "(GMT+0900) East Timor Time";
		$list["Asia/Jayapura"] = "(GMT+0900) Indonesia (Jayapura) Time";
		$list["Asia/Tokyo"] = "(GMT+0900) Japan Time";
		$list["Asia/Pyongyang"] = "(GMT+0900) North Korea Time";
		$list["Pacific/Palau"] = "(GMT+0900) Palau Time";
		$list["Asia/Irkutsk"] = "(GMT+0900) Russia (Irkutsk) Time";
		$list["Asia/Seoul"] = "(GMT+0900) South Korea Time";
		$list["Australia/Darwin"] = "(GMT+0930) Australia (Darwin) Time";
		$list["Antarctica/DumontDUrville"] = "(GMT+1000) Antarctica (Dumont d�Urville) Time";
		$list["Australia/Brisbane"] = "(GMT+1000) Australia (Brisbane) Time";
		$list["Pacific/Guam"] = "(GMT+1000) Guam Time";
		$list["Pacific/Truk"] = "(GMT+1000) Micronesia (Truk) Time";
		$list["Pacific/Saipan"] = "(GMT+1000) Northern Mariana Islands Time";
		$list["Pacific/Port_Moresby"] = "(GMT+1000) Papua New Guinea Time";
		$list["Asia/Yakutsk"] = "(GMT+1000) Russia (Yakutsk) Time";
		$list["Australia/Adelaide"] = "(GMT+1030) Australia (Adelaide) Time";
		$list["Australia/Hobart"] = "(GMT+1100) Australia (Hobart) Time";
		$list["Australia/Sydney"] = "(GMT+1100) Australia (Sydney) Time";
		$list["Pacific/Kosrae"] = "(GMT+1100) Micronesia (Kosrae) Time";
		$list["Pacific/Ponape"] = "(GMT+1100) Micronesia (Ponape) Time";
		$list["Pacific/Noumea"] = "(GMT+1100) New Caledonia Time";
		$list["Asia/Vladivostok"] = "(GMT+1100) Russia (Vladivostok) Time";
		$list["Pacific/Guadalcanal"] = "(GMT+1100) Solomon Islands Time";
		$list["Pacific/Efate"] = "(GMT+1100) Vanuatu Time";
		$list["Pacific/Norfolk"] = "(GMT+1130) Norfolk Island Time";
		$list["Pacific/Fiji"] = "(GMT+1200) Fiji Time";
		$list["Pacific/Tarawa"] = "(GMT+1200) Kiribati (Tarawa) Time";
		$list["Pacific/Kwajalein"] = "(GMT+1200) Marshall Islands (Kwajalein) Time";
		$list["Pacific/Majuro"] = "(GMT+1200) Marshall Islands (Majuro) Time";
		$list["Pacific/Nauru"] = "(GMT+1200) Nauru Time";
		$list["Asia/Kamchatka"] = "(GMT+1200) Russia (Kamchatka) Time";
		$list["Asia/Magadan"] = "(GMT+1200) Russia (Magadan) Time";
		$list["Pacific/Funafuti"] = "(GMT+1200) Tuvalu Time";
		$list["Pacific/Wake"] = "(GMT+1200) United States Minor Outlying Islands (Wake) Time";
		$list["Pacific/Wallis"] = "(GMT+1200) Wallis and Futuna Time";
		$list["Pacific/Enderbury"] = "(GMT+1300) Kiribati (Enderbury) Time";
		$list["Pacific/Auckland"] = "(GMT+1300) New Zealand (Auckland) Time";
		$list["Pacific/Apia"] = "(GMT+1300) Samoa Time";
		$list["Pacific/Tongatapu"] = "(GMT+1300) Tonga Time";
		$list["Pacific/Kiritimati"] = "(GMT+1400) Kiribati (Kiritimati) Time";
		$list["Pacific/Fakaofo"] = "(GMT+1400) Tokelau Time";	
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		$input = $this->_input($this->form->dropDownList($this->model,$name,$list,$option));
		$error = $this->_error($name);
		return $this->_field($label.$display.$input.$error);
	}
	/*
	*  Editor Fields
	*/
	public function editor($name,$option = array()){
		$cs=Jii::app()->clientScript;
		$cs->registerCssFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/_samples/sample.css');
		$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/ckeditor.js');
		$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/editor/ckeditor/_samples/sample.js');
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		//$id = 'editor'.$this->getId();
		$id = get_class($this->model).'_'.$name;
		$option['id'] = (isset($option['id']))?$option['id']:$id;
		$input = $this->_input($this->form->textArea($this->model,$name,$option));
		$error = $this->_error($name);
		$res = self::_field($label.$display.$input.$error);
		$res.= '
			<script type="text/javascript">
				$(document).ready(function(){
					var $editor_'.$option['id'].' = $("textarea#'.$option['id'].'");
					if ($editor_'.$option['id'].'.length) {
						var instance = CKEDITOR.instances["'.$option['id'].'"];
						if (instance) { CKEDITOR.remove(instance); e.destroy(); e=null; }
						var editor = CKEDITOR.replace("'.$option['id'].'",
						{
							fullPage : false,
							filebrowserBrowseUrl : "'.Yii::app()->baseUrl.'/assets/editor/ckfinder/ckfinder.html",
							filebrowserUploadUrl : "'.Yii::app()->baseUrl.'/assets/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
							uiColor:"#ccc",
							width:"100%",
							height:400,
							toolbar : "codendot"
						});
						CKEDITOR.instances.'.$option['id'].'.on("blur", function(e) {
							$("textarea#'.$option['id'].'").val(CKEDITOR.instances.'.$option['id'].'.getData());
							$("textarea#'.$option['id'].'").trigger("blur");								
						});
					}
				});
			</script> 
		';
		return $res;
	}
	/*
	*  Html Code Editor Fields
	*/
	public function htmlEditor($name,$option = array()){
		$cs=Jii::app()->clientScript;
		$cs->registerCssFile(Jii::app()->baseUrl .'/assets/code_editor/skins/markitup/style.css');
		$cs->registerCssFile(Jii::app()->baseUrl .'/assets/code_editor/sets/default/style.css');
		$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/code_editor/jquery.markitup.js');
		$cs->registerScriptFile(Jii::app()->baseUrl .'/assets/code_editor/sets/default/set.js');
		$label = $this->_label($name,$option);
		$display = $this->_display($option);
		//$id = 'editor'.$this->getId();
		$id = get_class($this->model).'_'.$name;
		$option['id'] = (isset($option['id']))?$option['id']:$id;
		$input = $this->_input($this->form->textArea($this->model,$name,$option));
		$error = $this->_error($name);
		$res = self::_field($label.$display.$input.$error);
		$res.= '
			<script type="text/javascript">
				$(document).ready(function(){
					$("#'.$option['id'].'").markItUp(mySettings);
				});
			</script> 
		';
		return $res;
	}
	/*
	*  Display Images Fields
	*/
	public function displayImage($name,$path,$notfound = 'notfound.jpg',$option = array()){
		if(is_array($name)){
			$id   = $name['id'];
			$name = $name['name'];	
		}else{
			$id   = 0;
		}
		$res = '';
		if( !( $name != '' && is_file(Jii::app()->params['rootPath'].'/'.$path.$name) ) ){
			$name = $notfound;	
		}
		if($name != ''){
			$res.= '<div class="outer-images">';
				$res.= '<div class="inner-images">';
					$res.= '<div class="image">';
						$res.= $this->image(Yii::app()->baseUrl.'/'.$path.$name,$name,$option);
						if($id > 0 && isset($option['urlink'])){
							$res.= CHtml::link('',$option['urlink'],array('class'=>'delete','confirm'=>Jii::t('Are You Sure?')));		
						}
					$res.= '</div>';
					$res.= '<div class="clear"></div>';
				$res.= '</div>';
			$res.= '</div>';
		}
		return $res;
	}
	public function displayImages($images,$path,$notfound = 'notfound.jpg',$option = array()){
		$res = '';
		if(isset($images) && is_array($images) && !empty($images)){
			$res.= '<div class="outer-images">';
				$res.= '<div class="inner-images">';
					foreach($images AS $name){
						if(is_array($name)){
							$id   = $name['id'];
							$name = $name['name'];	
						}else{
							$id   = 0;
						}
						$can_delete = true;
						if( !( $name != '' && is_file(Jii::app()->params['rootPath'].'/'.$path.$name) ) ){
							$name = $notfound;
							$can_delete = false;
						}
						if($name != ''){
							$res.= '<div class="image">';
								$res.= $this->image(Yii::app()->baseUrl.'/'.$path.$name,$name,$option);
								if($id != '' && isset($option['urlink']) && $can_delete){
									$url = str_replace('%2AID%2A',$id,$option['urlink']);
									$res.= CHtml::link('',$url,array('class'=>'delete','confirm'=>Jii::t('Are You Sure?')));		
								}
							$res.= '</div>';
						}
					}
					$res.= '<div class="clear"></div>';
				$res.= '</div>';
			$res.= '</div>';
		}
		return $res;
	}
	public function image($url,$name,$option = array()){
		$o = '';
		if(isset($option) && is_array($option) && !empty($option)){
			foreach($option AS $k=>$v){
				$o .= $k.'="'.$v.'" ';
			}	
		}
		return '<img src="'.$url.'" '.$o.' title="'.$name.'" alt="'.$name.'">';		
	}
	/*
	*  Display Field
	*/
	public function displayField($name,$hint = ''){
		$res = '';
		$res.= '<div class="field">';
			$res.= '<div class="label">';
				$res.= $this->form->labelEx($this->model,$name);
			$res.= '</div>';
			$res .= '<div class="input">';
				$res.= $this->model[$name].'&nbsp;'.$hint;
			$res.= '</div>';
			if($this->model->hasErrors($name)){
				$res.= $this->_error($name);		
			}
			$res.= '<div class="clear"></div>';
		$res.= '</div>';
		return $res;
	}
	/*
	* Section Form
	*/
	public function section($title,$fields,$float = true){
		$flotting = ($float)?'floatting':'';
		$res = '';
		if(empty($flotting)){
			$res .= '<div class="clr"></div>';
		}
		$res .= '<div class="outer-section '.$flotting.'">';
			$res .= '<fieldset class="inner-section">';
				$res .= '<legend class="title"><div class="l"></div>'.$title.'<div class="r"></div></legend>';
				$res .= '<div class="fields">';
					if(isset($fields) && is_array($fields) && !empty($fields)){
						foreach($fields AS $f){
							$res .= $f;	
						}	
					}
				$res .= '</div>';
			$res .= '</fieldset>';
		$res .= '</div>
		';
		return $res;
	}
	
	public static function displayHtml($html){
		$res = 	'<div class="outer-html">';
			$res .= 	'<div class="inner-html">';
				$res .= $html;
			$res .= '</div>';
		$res .= '</div>';
		return $res;
	}
	/*
	* Image finder field
	*/
	public function finder($name,$option = array()){
		$label = $this->_label($name,$option);
		$option['model'] = $this->model;
		$option['name'] = $name;
		$option['data'] = $this->model[$name];
		$input = $this->_input($this->controller->widget('ext.finder.EImageFinder',$option,true));
		$error = $this->_error($name);
		return $this->_field($label.$input.$error);	
	}
	
}
?>