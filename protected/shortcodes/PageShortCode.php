<?php
class PageShortCode extends JShortCode{
	public function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['attr'] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().']...[/'.$this->getName().']';
		self::$documentation[$this->getName()]['remark'] = 'writing after pages tag';	
	}

	public function process(){
		PagesShortCode::increment();
		$html = '';
			$html .= '<div class="sc-page">';
				$html .= $this->getContent();
			$html .= '</div>';
		return $html;
	}	
}
?>