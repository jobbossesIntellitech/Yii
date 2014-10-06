<?php
class PagesShortCode extends JShortCode{
	
	private static $pages = 0;
	private static $firstTime = true;
	private static $id = 0;
	
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().']([page]...[/page][page]...[/page]...)[/'.$this->getName().']';
		self::$documentation[$this->getName()]['remark'] = 'writing before page tag';	
	}
	
	public function process(){
		$html = '';
		if(self::$pages > 0){
			self::$id++;
			$cs=Yii::app()->clientScript;
			$cs->registerScriptFile(Yii::app()->baseUrl .'/assets/scripts/behave.js');	
			$html .= '<div class="sc-pages" id="scPages'.self::$id.'">';
				$html .= '<ul class="nav">';
					for($i = 1; $i <= self::$pages; $i++){
						$html .= '<li>';
							$html .= '<a href="javascript://">'.$i.'</a>';
						$html .= '</li>';
					}		
				$html .= '</ul>';
				$html .= $this->getContent();
			$html .= '</div>';
			$html .= '
				<script type="text/javascript">
				$(document).ready(function(){
					$("#scPages'.self::$id.'").find("ul.nav li").each(function(i,li){
						$(li).find("a").click(function(){
							var index = $(this).parent().index();
							$("#scPages'.self::$id.'").find(".sc-page:visible").hide();
							$("#scPages'.self::$id.'").find(".sc-page").eq(index).show();
							$("#scPages'.self::$id.'").find("ul.nav li.selected").removeClass("selected");
							$(this).parent().addClass("selected");
						});
					});
					$("#scPages'.self::$id.'").find("ul.nav li").eq(0).find("a").trigger("click");
				});	
				</script>
			';
			if(self::$firstTime){
				self::$firstTime = false;
				$html .= $this->displayCss();
			}
		}
		self::$pages = 0;
		return $html;	
	}
	
	public static function increment(){
		self::$pages++;
	}
	
	public static function decrement(){
		self::$pages--;
	}
	
	private function displayCss(){
		ob_start();
		?>
		<style type="text/css">
			.sc-pages{position:relative; margin:0; display:block;}
			.sc-pages .sc-page{ position:relative; display:none;}
			.sc-pages ul.nav{ margin:0; padding:0; height:30px; display:block;}
			.sc-pages ul.nav li{ float:left; list-style:none; height:30px;padding:0px 1px;}
			.sc-pages ul.nav li a{ display:block;height:30px;line-height:30px; padding:0 8px; text-align:center; color:#000; background:#e5e5e5;}
			.sc-pages ul.nav li a:hover{ color:#fabc00; background:#ddd;}
			.sc-pages ul.nav li.selected a{ background:#fabc00; color:#000;}
		</style>
		<?php
		$css = ob_get_clean();
		return $css;
	}
	
}
?>