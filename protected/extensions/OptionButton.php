<?php
class OptionButton
{
	private $list;
	private $specific_style_class;
	
	public function __construct($specific_style_class = '')
	{
		$this->list = array();	
		$this->specific_style_class = $specific_style_class;
	}
	
	public function put($name,$link,$option=array())
	{
		$item = '';
		$item .= '<li>';
			$item .= CHtml::link($name,$link,$option);
		$item .= '</li>';
		$this->list[] = $item;
	}
	
	public function procced($return = false)
	{
		$res = '';
		if(isset($this->list) && is_array($this->list) && !empty($this->list))
		{
			$res .= '<ul class="option-button '.$this->specific_style_class.'">';
			foreach($this->list AS $l)
			{
				$res .= $l;		
			}
			$res .= '<div class="clear"></div>';
			$res .= '</ul>';
		}
		if($return){
			return $res;	
		}else{
			echo $res;	
		}
			
	}
}
?>