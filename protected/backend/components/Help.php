<?php
class Help{
	private $controller;
	private $action;
	private $tabs;
	private $path;
	private $file;
	public function __construct($controller,$action){
		$this->controller = $controller;
		$this->action = $action;
		$this->tabs = array();
		$this->path = Jii::app()->basePath.'\helps\/';
		$this->file = $this->path.$controller.'_'.$action.'.help';
		$this->processFile();
	}
	private function processFile(){
		if(!is_dir($this->path)){
			mkdir($this->path,0777);
		}
		if(!is_file($this->file)){
			$handle = fopen($this->file, 'w') or die('Cannot open file:  '.$this->file);
			$data = '
<?php
/* -- Help file for the action : '.$this->action.' inside the controller : '.$this->controller.' -- */
/* -- Powered by Jawdat Sobh @Code&Dot 2013 -- */


// TO DO ...
	
		
?>
			';
			fwrite($handle, $data);
			fclose($handle);
		}
	}
	public function read(){
		$handle = fopen($this->file, 'r');
		$data = fread($handle,filesize($this->file));
		fclose($handle);
		return $data;
	}
	public function write($data){
		$handle = fopen($this->file, 'w');
		fwrite($handle,$data,strlen($data));
		fclose($handle);
		return true;
	}
	public function content(){
		ob_start();
		error_reporting(E_ERROR);
		include($this->file);
		$data = ob_get_clean();
		if(!trim($data)){
			$data = '<div class="error">'.Jii::t('Php error or empty file').'</div>';
		}
		return $data;
	}	
}
?>