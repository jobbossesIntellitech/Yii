<?php
class JGridList{
	
	private $list;
	private $rows;
	private $index;
	private $count;
	private $columns_size;
	
	public function __construct($list,$columns_size){
		$list = array_values($list);
		$this->list = $list;
		$this->rows = array();
		$this->index = -1;
		$this->count = count($this->list);
		$this->columns_size = $columns_size;
	}
	
	public function next(){
		$this->index++;
		return ($this->index < $this->count)?$this->list[$this->index]:false;
	}
	
	public function add($html,$wordwrap = true){
		if(!isset($this->rows[$this->index])){
			$this->rows[$this->index] = array();
		}
		$this->rows[$this->index][] = ($wordwrap)?'<div class="wordwrap">'.$html.'</div>':$html;	
	}
	
	public function display($return = false){
		$html = '';
		if(is_array($this->rows) && !empty($this->rows)){
			foreach($this->rows AS $i=>$row){
				$html .= '<tr>';
				foreach($row AS $j=>$cell){
					$html .= '<td>';
						$html .= $cell;
					$html .= '</td>';
				}
				$html .= '</tr>';
			}
		}else{
			$html .= '<tr>';
				$html .= '<td colspan="'.$this->columns_size.'" class="notfound">';
					$html .= Jii::t("Empty List");
				$html .= '</td>';
			$html .= '</tr>';
		}
		if($return){
			return $html;
		}
		echo $html;	
	}
	
}
?>