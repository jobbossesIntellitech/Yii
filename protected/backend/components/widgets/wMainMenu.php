<?php
class wMainMenu extends CWidget{
	private $menu = array();
	public function init(){	
		parent::init();	
	}
	public function run(){	
		$this->render('vMainMenu');	
	}
	public function mainMenu($title,$image,$list = array()){
		$i = count($this->menu);
		$this->menu[$i] = array();
		$this->menu[$i]['title'] = $title;
		$this->menu[$i]['image'] = $image;
		$this->menu[$i]['list'] = $list;
						
	}
	
	public function create(){
		$l1 = '';
		$l2 = '';
		$c = Jii::app()->controller->getId();
		$a = Jii::app()->controller->action->getId();
		if(!empty($this->menu) && is_array($this->menu)){
			$l1 .= '<ul>';
			$is_selected = false;
			foreach($this->menu AS $i => $menu){
				$is_selected = false;
				$l2 .= '<ul id="m_'.$i.'" style="display:none;">';
				if(!empty($menu['list']) && is_array($menu['list'])){
					foreach($menu['list'] AS $item){
						$url = explode('/',$item['url']);
						$selected = ($url[0] == $c)?'selected':'';
						if($selected == 'selected'){ $is_selected  = true; }
						$param = isset($item['params'])?$item['params']:array();
						if(Jii::hasPermission($url[0],$url[1])){
							$l2 .= '<li class="'.$selected.'">';
								$l2 .= '<a href="'.Jii::app()->createUrl($item['url'],$param).'">';
									$l2 .= $item['title'];
								$l2 .= '</a>';
							$l2 .= '</li>';
						}
					}	
				}	
				$l2 .= '</ul>';
				$selected = ($is_selected)?'selected':'';
				$l1 .= '<li class="'.$selected.'">';
					$l1 .= '<a href="javascript://" rel="m_'.$i.'" style="background:url('.$menu['image'].') no-repeat center 5px;">';
						$l1 .= $menu['title'];
					$l1 .= '</a>';
				$l1 .= '</li>';			
			}
			$l1 .= '</ul>';	
		}
		$l1 = '<div id="sidebar1">'.$l1.'</div>';
		$l2 = '<div id="sidebar2">'.$l2.'</div>';
		$script = $this->script();
		echo $l1.$l2.$script;		
	}
	
	public function image($name){
		return Jii::app()->baseUrl.'/assets/images/b/mainmenu/'.$name.'.png';	
	}
	
	private function script(){
		ob_start();
		?>
        <script type="text/javascript">
		$(document).ready(function() {
			mainMenu();		
		});
		function mainMenu(){
			var id = '';
			$('#sidebar1 ul li').each(function(i, e) {
                id = $(e).find('a').attr('rel');
				if($('#sidebar2 ul#'+id+' li').length == 0){
					$(e).remove();
					$('#sidebar2 ul#'+id).remove();		
				} 
				  				
				// on click event
				$(e).find('a').click(function() {
                	if(!$(e).hasClass('selected')){
						id = $('#sidebar1 ul li.selected a').attr('rel');
						$('#sidebar1 ul li.selected').removeClass('selected');
						$('#sidebar2 ul#'+id).hide();
						
						$(e).addClass('selected');
						id = $('#sidebar1 ul li.selected a').attr('rel');
						$('#sidebar2 ul#'+id).show();	
					}  
                });
            });
			id = $('#sidebar1 ul li.selected a').attr('rel');
			$('#sidebar2 ul#'+id).show();			
		}
		</script>
        <?php
		$s = ob_get_contents();
		return $s;		
	}
}
?>