<?php
class Dashboard{
	
	private $portlet;
	private $index;
	private $visible;
	
	const COLUMN_1 = 1;
	const COLUMN_2 = 2;
	
	private static $id = 0;
	
	public function __construct(){
		$this->portlet = array();
		$this->visible = array();
		$this->index = 0;
		$this->portlet['column_'.self::COLUMN_1] = array();
		$this->portlet['column_'.self::COLUMN_2] = array();
		self::$id++;
	}
	
	public function add($c,$id, $title, $content, $header = NULL){
		$c = 'column_'.$c;
		$c = UserCookie::get('portlet_'.$id,$c);
		$this->visible['portlet_'.$id] = array('title'=>$title,'display'=>false);
		$display = UserCookie::get('visible_portlet_'.$id,"off");
		$this->visible['portlet_'.$id]['display'] = ($display == 'on')?true:false;
		$display = ($this->visible['portlet_'.$id]['display'])?'display:block;':'display:none;';
		$position = UserCookie::get('position_portlet_'.$id,$this->index);
		$this->portlet[$c][$this->index] = '
			<div class="portlet" id="portlet_'.$id.'" style="'.$display.'" data-position="'.$position.'">
				<div class="portlet-content">
					<div class="j-form">
						<div class="outer-section">
							<fieldset class="inner-section">
								<legend class="title">
									<div class="l"></div>'.$title.'<div class="r"></div>
								</legend>
								<div class="fields">
		';
		if(!empty($header) && is_array($header)){
				$this->portlet[$c][$this->index] .= '
					<div class="grid-view">
						<table border="0" cellpadding="0" cellspacing="0" id="gv">
							<thead>
								<tr class="tab_header">
								';
								foreach($header AS $h){
									$this->portlet[$c][$this->index] .= '<th>'.$h.'</th>';	
								}
				$this->portlet[$c][$this->index] .= '					
								</tr>
							</thead>
							<tbody>
				';
		}
		$this->portlet[$c][$this->index] .= $content;
		if(!empty($header) && is_array($header)){
				$this->portlet[$c][$this->index] .= '
							</tbody>
						</table>
					</div>	
				';
		}
		$this->portlet[$c][$this->index] .= '
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		';

		$this->index++;	
	}
	
	public function display(){
		$html = '<div class="dashboard" id="dashboard_'.self::$id.'">';
		$html .= $this->options();
		if(!empty($this->portlet) && is_array($this->portlet)){
			foreach($this->portlet AS $column=>$portlets){
				$html .= '<div class="column" id="'.$column.'">';
				if(!empty($portlets) && is_array($portlets)){
					foreach($portlets AS $portlet){
						$html .= $portlet;
					}
				}
				$html .= '</div>';
			}
		}
		$sortable = UserCookie::get('widgets_sortable','off');
		$html .= '</div>';
		$html .= '
			<script type="text/javascript">
			$(function() {
				if($("#dashboard_'.self::$id.'").height() < $("#dashboard_'.self::$id.'").parent().height()){
					$("#dashboard_'.self::$id.'").height($("#dashboard_'.self::$id.'").parent().height()-20);	
				}
				$( "#dashboard_'.self::$id.' .column" ).each(function(i,e){
					var ul = $(e);
					var li = ul.children(".portlet");
					li.detach().sort();
					li.detach().sort(function(a, b) {
						var pos1 = parseInt($(a).attr("data-position"));
						var pos2 = parseInt($(b).attr("data-position"));
						if(pos1 > pos2){
							return true;
						}
						return false;
					});
					ul.append(li);
				});
				$("#dashboard_'.self::$id.' .column").bind("click mousedown", function(){
					  $("#dashboard_'.self::$id.' .column").each(function (c) {
							if ($(this).find(".portlet:visible").size() == 0) {
								$(this).addClass("colZoneEmpty")
							}
						})
				 });
     
				$( "#dashboard_'.self::$id.' .column" ).sortable({
					connectWith: ".column",
					containment: ".dashboard",
					stop: function(event, ui) {
						ui.item.parent().removeClass("colZoneEmpty");
						var id = ui.item.parent().attr("id");
						dashboard_save_'.self::$id.'(ui.item.attr("id"),id);
						var ul = ui.item.parent().children(".portlet");
						var o = {};
						ul.each(function(i,e){
							$(e).attr("data-position",i+1);
							o["position_"+$(e).attr("id")] = (i+1);
						});
						dashboard_save_list_'.self::$id.'(o);
					},
				});
		';
		if($sortable == "off"){
			$html .= '$( "#dashboard_'.self::$id.' .column" ).sortable( "disable" );';	
		}
		$html .= '		
				$( "#dashboard_'.self::$id.' .portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" ).find( ".portlet-content" );
				$( "#dashboard_'.self::$id.' .column" ).disableSelection();
			});
			function dashboard_save_'.self::$id.'(k,v){
				var preloader = genPreLoader_'.self::$id.'();
				$.ajax({
					type : "post",
					url : "'.Jii::app()->createUrl("dashboard/saveusercookie").'",
					data : {k:k,v:v},
					beforeSend : function(){
						preloader.slideDown("500");	
					},
					success : function(msg){
						preloader.slideUp("500");
					},
					error : function(){
						preloader.slideUp("500");
					}
				});	
			}
			function dashboard_save_list_'.self::$id.'(o){
				var preloader = genPreLoader_'.self::$id.'();
				$.ajax({
					type : "post",
					url : "'.Jii::app()->createUrl("dashboard/saveusercookies").'",
					data : {data:o},
					beforeSend : function(){
						preloader.slideDown("500");	
					},
					success : function(msg){
						preloader.slideUp("500");
					},
					error : function(){
						preloader.slideUp("500");
					}
				});	
			}
			function genPreLoader_'.self::$id.'(){
				var preloader = null;
				if($(".preloader").length == 0){
					preloader = $("<div/>");
					preloader.addClass("preloader");
					preloader.addClass("outer-loader");
					preloader.append("<div class=\"inner-loader\">Loading...</div>");
					$("body").append(preloader);
					$(".inner-loader").html("<div id=\"facebookG\">"+
					"<div id=\"blockG_1\" class=\"facebook_blockG\">"+
					"</div>"+
					"<div id=\"blockG_2\" class=\"facebook_blockG\">"+
					"</div>"+
					"<div id=\"blockG_3\" class=\"facebook_blockG\">"+
					"</div>"+
					"</div>");
				}else{
					preloader = $(".preloader");	
				}
				return preloader;	
			}
			</script>
		';
		return $html;
	}
	
	public function options(){
		$html = '<div class="dashboard-option"><a class="collapse" href="javascript://"></a><ul>';
			if(!empty($this->visible) && is_array($this->visible)){
				$checked = '';
				$sortable = UserCookie::get('widgets_sortable','off');
				if($sortable == 'on'){ $checked = 'checked="checked"'; }
				$html .= '<li><label><input type="checkbox" value="1" class="dashboard-widget-sortable" '.$checked.'/>';
				$html .= '&nbsp;&nbsp;'.Jii::t('Enable Drag&Drop').'</label></li>';
				foreach($this->visible AS $k=>$v){
					$checked = ($v['display'])?'checked="checked"':'';
					$html .= '<li><label><input type="checkbox" value="'.$k.'" class="dashboard-widget-option" '.$checked.'/>';
					$html .= '&nbsp;&nbsp;'.$v['title'].'</label></li>';	
				}
			}
		$html .= '<div class="clr"></div></ul></div>';
		$html .= '
		<script type="text/javascript">
		$(document).ready(function(){
			$("#dashboard_'.self::$id.' .dashboard-option .collapse").click(function(){
				$("#dashboard_'.self::$id.' .dashboard-option ul").slideToggle(500);	
			});
			$("#dashboard_'.self::$id.' .dashboard-option .dashboard-widget-sortable").click(function(){
				if($(this).is(":checked")){
					dashboard_save_'.self::$id.'("widgets_sortable","on");
					$( "#dashboard_'.self::$id.' .column" ).sortable( "enable" );	
				}else{
					dashboard_save_'.self::$id.'("widgets_sortable","off");
					$( "#dashboard_'.self::$id.' .column" ).sortable( "disable" );
				}
			});
			$("#dashboard_'.self::$id.' .dashboard-option .dashboard-widget-option").click(function(){
				if($(this).is(":checked")){
					$("#"+$(this).val()).show();
					dashboard_save_'.self::$id.'("visible_"+$(this).val(),"on");	
				}else{
					$("#"+$(this).val()).hide();
					dashboard_save_'.self::$id.'("visible_"+$(this).val(),"off");
				}
			});
		});
		</script>
		';
		return $html;
	}
}
?>