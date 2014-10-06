<?php
class UI{
	public static $id = 1;
	public static function getId($name = 'JLA'){
		UI::$id++;
		return $name.'_'.UI::$id;	
	}
	/*
	 * Range Slider One Handle
	*/
	public static function RangeSlider($name,$min,$max,$value,$range = 'min',$width='100%',$sign = ''){
		$id = UI::getId('range_slider');
		$html = '';
		$html .= '<div id="'.$id.'" class="ui-range-slider">';
			$html .= '<div class="numbers"><span class="n1">'.number_format($value,2,'.',',').$sign.'</span></div>';
			$html .= '<div class="ranger"></div>';
			$html .= '<input type="hidden" name="'.$name.'[value]" id="'.$name.'_0" value="'.$value.'" />';             
			$html .= '<input type="hidden" name="'.$name.'[sign]" id="'.$name.'_1" value="'.$sign.'" />';
		$html .= '</div>';	
		
		$html .= '
			<script>
			$(document).ready(function(){
				$( "#'.$id.' .ranger" ).slider({
					orientation : "horizontal",
					animate : true,
					range: "'.$range.'",
					min: '.$min.',
					max: '.$max.',
					value: '.$value.',
					create : function(event, ui){
						rangeSelectedNumberCss'.$id.'(event,ui);	
					},
					start : function(event, ui){
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);
					},
					slide: function( event, ui ) {
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);
					},
					change : function(event, ui){
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);
					},
					stop : function(event, ui){
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);	
					}
				});		
			});
			function rangeValues'.$id.'(event,ui){
				$("#'.$id.' .numbers .n1").html(ui.value.toFixed(2)+"'.$sign.'");
				$("#'.$id.' input[type=hidden]#'.$name.'_0").val(ui.value);                                                 	
			}
			function rangeSelectedNumberCss'.$id.'(event,ui){
				$("#'.$id.'").css("width","'.$width.'");
				var w = $("#'.$id.' .ranger").width();
				var wn1 = $("#'.$id.' .numbers .n1").width();
				var handle = $("#'.$id.' .ranger a:first").position().left;
				wn1 = Math.ceil(wn1/2);
				if(handle - wn1 < 0){
					left1 = 0;	
				}else
				if(handle + wn1 > w){
					left1 = w - wn1*2;	
				}else{
					left1 = handle - wn1;	
				}
				$("#'.$id.' .numbers .n1").css("left",Math.ceil(left1));		
			}
			function px2int'.$id.'(val){
				val = val.toString();
				return parseInt(val.replace("px",""));
			}
			</script>
		';
		return $html;
	}
	/*
	 * Range Slider Two Handles
	*/
	public static function RangeSlider2($name,$min,$max,$value_1,$value_2,$width='100%',$sign = ''){
		$id = UI::getId('range_slider2');
		$html = '';
		$html .= '<div id="'.$id.'" class="ui-range-slider">';
			$html .= '<div class="numbers"><span class="n1">'.number_format($value_1,2,'.',',').$sign.'</span><span class="n2">'.number_format($value_2,2,'.',',').$sign.'</span></div>';
			$html .= '<div class="ranger"></div>';
			$html .= '<input type="hidden" name="'.$name.'[min]" id="'.$name.'_0" value="'.$value_1.'" />';
			$html .= '<input type="hidden" name="'.$name.'[max]" id="'.$name.'_1" value="'.$value_2.'" />';
			$html .= '<input type="hidden" name="'.$name.'[sign]" id="'.$name.'_2" value="'.$sign.'" />';
		$html .= '</div>';	
		
		$html .= '
			<script>
			$(document).ready(function(){
				$( "#'.$id.' .ranger" ).slider({
					orientation : "horizontal",
					animate : true,
					range: true,
					min: '.$min.',
					max: '.$max.',
					values: [ '.$value_1.','.$value_2.' ],
					create : function(event, ui){
						rangeSelectedNumberCss'.$id.'(event,ui);	
					},
					start : function(event, ui){
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);	
					},
					slide: function( event, ui ) {
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);
					},
					change : function(event, ui){
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);	
					},
					stop : function(event, ui){
						rangeValues'.$id.'(event,ui);
						rangeSelectedNumberCss'.$id.'(event,ui);	
					}
				});		
			});
			function rangeValues'.$id.'(event,ui){
				$("#'.$id.' .numbers .n1").html(ui.values[0].toFixed(2)+"'.$sign.'");	
				$("#'.$id.' .numbers .n2").html(ui.values[1].toFixed(2)+"'.$sign.'");
				$("#'.$id.' input[type=hidden]#'.$name.'_0").val(ui.values[0]);	
				$("#'.$id.' input[type=hidden]#'.$name.'_1").val(ui.values[1]);		
			}
			function rangeSelectedNumberCss'.$id.'(event,ui){
				$("#'.$id.'").css("width","'.$width.'");
				var w = $("#'.$id.' .ranger").width();
				var wn1 = $("#'.$id.' .numbers .n1").width();
				var wn2 = $("#'.$id.' .numbers .n2").width();
				$("#'.$id.'").css("width","'.$width.'");
				var w = $("#'.$id.' .ranger").width();
				var wn1 = $("#'.$id.' .numbers .n1").width();
				var wn2 = $("#'.$id.' .numbers .n2").width();
				var handle1 = $("#'.$id.' .ranger a:first").position().left;
				var handle2 = $("#'.$id.' .ranger a:last").position().left;
				wn1 = Math.ceil(wn1/2);
				wn2 = Math.ceil(wn2/2);
				if(handle1 - wn1 < 0){
					left1 = 0;	
				}else
				if(handle1 + wn1 > w){
					left1 = w - wn1*2;	
				}else{
					left1 = handle1 - wn1;	
				}
				if(handle2 - wn2 < 0){
					left2 = 0;	
				}else
				if(handle2 + wn2 > w){
					left2 = w - wn2*2;	
				}else{
					left2 = handle2 - wn2;	
				}
				$("#'.$id.' .numbers .n1").css("left",Math.ceil(left1));
				$("#'.$id.' .numbers .n2").css("left",Math.ceil(left2));		
			}
			function px2int'.$id.'(val){
				val = val.toString();
				return parseInt(val.replace("px",""));
			}
			</script>
		';
		return $html;
	}
	public static function selectBox($name,$value,$data,$prompt = false,$width = '200px'){
		$id = UI::getId('selectbox');
		$item = '';
		if(isset($data) && is_array($data) && !empty($data)){
			$i = 0;
			if($prompt){
				$item .= '<li value="" class="first"><a href="javascript://" onclick="return false">'.$prompt.'</a></li>';
				$i++;
			}
			foreach($data AS $k=>$v){
				if($k == $value){ $selected = 'selected'; $prompt = $v; }else{ $selected = ''; }
				if($i == 0){ $first = 'first';}else{$first = '';}
				if($i == count($data)-1){ $last = 'last';}else{$last = '';}
				$item .= '<li value="'.$k.'" class="'.$first.' '.$last.' '.$selected.'"><a href="javascript://" onclick="return false">'.$v.'</a></li>';
				$i++;	
			}	
		}else{
			$item .= '<li value="" class="empty">empty list</li>';	
		}
		$html = '
			<div id="'.$id.'" class="ui-selectbox" style="width:'.$width.';">
				<div class="prompt">
					<div class="value">'.$prompt.'</div>
					<div class="arrow"></div>
				</div>
				<div class="list">
					<ul>
						'.$item.'		
					</ul>
				</div>
				<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$value.'" />	
			</div>
			<script>
			$(document).ready(function(){
				selectbox'.$id.'();		
			});
			function selectbox'.$id.'(){
				$("#'.$id.' .prompt").click(function(event){
					event.preventDefault();
					if($("#'.$id.' .list").is(":hidden")){
						$(".ui-selectbox .list").slideUp(200);
						$("#'.$id.' .list").slideDown(200);		
					}else{
						$("#'.$id.' .list").slideUp(200);		
					}
					return false;	
				});
				$("#'.$id.' .list ul li").each(function(i,e){
					$(e).click(function(event){
						event.preventDefault();
						$("#'.$id.' .list ul li.selected").removeClass("selected");	
						$(e).addClass("selected");
						$("#'.$id.' .prompt .value").html($(e).find("a").html());
						$("#'.$id.' input[type=hidden]#'.$name.'").val($(e).attr("value"));
						$("#'.$id.' .list").slideUp(200);
						return false;
					});	
				});
				$(document).click(function(event){
					$("#'.$id.' .list").slideUp(200);
				});
				$("#'.$id.' .list").click(function(event){
					 event.preventDefault();
					 event.stopPropagation();
					 return false;	
				});		
			}
			</script>	
		';
		return $html;			
	}
	
	public static function checkbox($name,$checked,$value){
		$id = UI::getId('checkbox');
		$html = '
			<div id="'.$id.'" class="ui-checkbox">
				<input type="hidden" id="'.$name.'" name="'.$name.'" value="" />	
			</div>
		
		<script>
		$(document).ready(function(){
			checkbox'.$id.'();
			';
			if($checked){
				$html .= '
					$("#'.$id.'").trigger("click");	
				';	
			}
		$html .='			
		});
		function checkbox'.$id.'(){
			$("#'.$id.'").click(function(){
				if($(this).hasClass("checked")){
					$(this).removeClass("checked");
					$(this).find("input[type=hidden]#'.$name.'").val("");
				}else{
					$(this).addClass("checked");
					$(this).find("input[type=hidden]#'.$name.'").val("'.$value.'");		
				}	
			});	
		}
		</script>	
		';
		return $html;		
	}
	
	public static function textField($name,$value,$width='200px'){
		$id = UI::getId('textfield');
		$html = '
			<div id="'.$id.'" class="ui-textfield" style="width:'.$width.';">
				<div class="inputdiv" style="width:'.$width.';" contenteditable="true">'.$value.'</div>
				<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$value.'"  style="width:'.$width.';" />	
			</div>
		<script>
		$(document).ready(function(){
			textfield'.$id.'();			
		});
		function textfield'.$id.'(){
			$("#'.$id.' .inputdiv").keyup(function(){
				$("#'.$id.' input[type=hidden]#'.$name.'").val( $("#'.$id.' .inputdiv").text() );			
			});	
		}
		</script>	
		';
		return $html;		
	}	
}
?>