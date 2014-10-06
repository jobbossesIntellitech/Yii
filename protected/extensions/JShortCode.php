<?php
class JShortCode{
	private $name;
	private $attributes;
	private $content;
	private $path;
	private $file;
	private $code;
	
	protected static $shortcode = NULL;
	protected static $documentation = NULL;

	public function __construct(){
		$this->name = '';
		$this->attributes = array();
		$this->content = '';
		$this->code = '';
		$this->path = Jii::app()->params['frontendPath'].'/shortcodes/';
		$this->file = '';
		if(!is_dir($this->path)){
			mkdir($this->path,0777);
		}
		$this->load();
	}
	
	private function load(){
		if(self::$shortcode == NULL && self::$documentation == NULL){
			self::$shortcode = array();
			self::$documentation = array();
			if ($handle = opendir($this->path)) {
				while (false !== ($file = readdir($handle))) {
					if(!in_array($file,array('.','..'))){
						$file = explode('ShortCode.php',$file);
						if(isset($file[0])){
							$file = strtolower($file[0]);
							self::$shortcode[$file] = $file;
							$classname = ucfirst(strtolower($file)).'ShortCode';
							$ins = new $classname;
							$ins->setName($file);
							$ins->documentation();
						}
					}
				}
				closedir($handle);
			}
		}	
	}
	
	public function setName($name){
		$this->name = $name;
		$this->file = $this->path.ucfirst(strtolower($this->name)).'ShortCode';
	}
	public function getName(){
		return $this->name;
	}
	
	public function setAttributes($attributes){
		$this->attributes = $attributes;
	}
	public function getAttributes(){
		return $this->attributes;
	}
	
	public function setContent($content){
		$this->content = $content;
	}
	public function getContent(){
		return $this->content;
	}
	
	public function setCode($code){
		$this->code = $code;
	}
	public function getCode(){
		return $this->code;
	}
	
	public function getPath(){
		return $this->path;
	}
	
	public function getFile(){
		return $this->file;
	}

	protected function getRegex(){
		$tagnames = array_keys(self::$shortcode);
		$tagregexp = join( '|', array_map('preg_quote', $tagnames) );
		return
		  '\\['                              // Opening bracket
		. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
		. "($tagregexp)"                     // 2: Shortcode name
		. '(?![\\w-])'                       // Not followed by word character or hyphen
		. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
		.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
		.     '(?:'
		.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
		.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
		.     ')*?'
		. ')'
		. '(?:'
		.     '(\\/)'                        // 4: Self closing tag ...
		.     '\\]'                          // ... and closing bracket
		. '|'
		.     '\\]'                          // Closing bracket
		.     '(?:'
		.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
		.             '[^\\[]*+'             // Not an opening bracket
		.             '(?:'
		.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
		.                 '[^\\[]*+'         // Not an opening bracket
		.             ')*+'
		.         ')'
		.         '\\[\\/\\2\\]'             // Closing shortcode tag
		.     ')?'
		. ')'
		. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
	}

	protected function parseAttributes($text){
		$atts = array();
		$pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
		$text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
		if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
			foreach ($match as $m) {
				if (!empty($m[1]))
					$atts[strtolower($m[1])] = stripcslashes($m[2]);
				elseif (!empty($m[3]))
					$atts[strtolower($m[3])] = stripcslashes($m[4]);
				elseif (!empty($m[5]))
					$atts[strtolower($m[5])] = stripcslashes($m[6]);
				elseif (isset($m[7]) and strlen($m[7]))
					$atts[] = stripcslashes($m[7]);
				elseif (isset($m[8]))
					$atts[] = stripcslashes($m[8]);
			}
		} else {
			$atts = ltrim($text);
		}
		$this->attributes = $atts;
		return $this->attributes;
	}
	
	protected function execute($content){
		$pattern = $this->getRegex();
		return preg_replace_callback( "/$pattern/s", array($this,'doTag'), html_entity_decode($content) );
	}
	
	protected function doTag($m){
		/*
			m[index]
			0 : short code expression
			1 : Optional second opening bracket for escaping shortcodes: [[tag]]
			2 : Shortcode name
			3 : Unroll the loop: Inside the opening shortcode tag
			4 : Self closing tag ...
			5 : Unroll the loop: Optionally, anything between the opening and closing
			6 : Optional second closing brocket for escaping shortcodes: [[tag]]
		*/
		// allow [[foo]] syntax for escaping a tag
		if ( $m[1] == '[' && $m[6] == ']' ) {
			return substr($m[0], 1, -1);
		}

		$tag = $m[2];
		$classname = ucfirst(strtolower($tag)).'ShortCode';
		try{
			$attr = $this->parseAttributes( $m[3] );
			$ins = new $classname();
			$ins->setName($tag);
			$ins->setAttributes($attr);
			$ins->setCode($m[0]);
			if ( isset( $m[5] ) ) {
				$ins->setcontent($this->execute($m[5]));
				return $ins->process();
			} else {
				$ins->setcontent('');
				return $ins->process();
			}
		}catch(Exception $e){
			return '';
		}
	}
	
	public static function encodeToHtml($text){
		$list = array(
			'&egrave;' => 'è',
			'&eacute;' => 'é',
			'&nbsp;' => ' ',
			'&agrave;' => 'à',
			'&aacute;' => 'á',
			'&acirc;' => 'â',
			'&ocirc;' => 'ô',
			'&ecirc;' => 'ê',
			'&icirc;' => 'î',
			'&iuml;' => 'ï',
			'&ccedil;' => 'ç',
			'&lt;' => '<',
			'&gt;' => '>',
			'&quot;' => '"',
			'&amp;' => '&',
			'&reg;' => '®',
			'&copy;' => '©',
			'&laquo;' => '«',
			'&raquo;' => '»',
			'&plusmn;' => '±',
			'&ugrave;' => 'ù',
			'&uacute;' => 'ú',
			'&ucirc;' => 'û',
			'&Eacute;' => 'É',
			'&Egrave;' => 'È',
			'&uuml;' => 'ü',
			'&euml;' => 'ë',
			'&Acirc;' => 'Â',
			'&deg;' => '°',
			'&Agrave;' => 'À',
			'&Aacute;' => 'Á',
			'&Ocirc;' => 'Ô',
			'&micro;' => 'µ',
			'&aring;' => 'å',
			'&ouml;' => 'ö',
			'&oacute;' => 'ó',
			'&ograve;' => 'ò',
			'&ntilde;' => 'ñ',
			'&Iuml;' => 'Ï',
			'&iuml;' => 'ï',
			'&auml;' => 'ä',
			'&Auml;' => 'Ä',
			'&middot;' => '·',
			'' => '',
		);
		
		foreach($list as $k=>$v){
			$text = str_replace($k,$v,$text);	
		}
		
		return $text;
	}
	
	public static function filter($text){
		$shortcode = new self();
		//$text = htmlentities($text,ENT_COMPAT,'ISO-8859-1');
		//$text = htmlentities($text,ENT_COMPAT,'ISO-8859-5');
		//$text = htmlentities($text, ENT_COMPAT,'ISO-8859-15');
		
		$text = self::encodeToHtml($text);
		$pattern = "#<[^\/>]*>(\s|&nbsp;|</?\s?br\s?/?>)*<\/[^>]*>#";	
		$text = preg_replace($pattern, '<br>', $text);
		return $shortcode->execute($text);
	}
	
	public function process(){
		return '';	
	}

	public function fillDefault($default = array()){
		if(!empty($default) && is_array($default)){
			foreach($default AS $k=>$v){
				if(!isset($this->attributes[$k])){
					$this->attributes[$k] = $v;
				}
			}	
		}
		return $this->attributes;
	}

	protected function documentation(){
		self::$documentation[$this->getName()] = array();
		self::$documentation[$this->getName()]['format'] = '['.$this->getName().' attributes(name="value" ...)][/'.$this->getName().']';
	}

	public static function helper(){
		$sc = new self;
		$documentation = self::$documentation;
		$html = '';
		if(!empty($documentation) && is_array($documentation)){
			$i = 0;
			$column = array(0=>'',1=>'');
			foreach($documentation AS $name => $help){
				ob_start();
				?>
				<li class="box">
					<div class="title"><?php echo $name; ?></div>
					<table border="0" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th colspan="2"><?php echo $name; ?></th>	
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?php echo Jii::t('Format'); ?></th>
								<td><?php echo $help['format']; ?></td>
							</tr>
							<?php if(!empty($help['description'])){ ?>
							<tr>
								<th><?php echo Jii::t('Description'); ?></th>
								<td><?php echo $help['description']; ?></td>
							</tr>
							<?php } ?>
							<?php if(!empty($help['remark'])){ ?>
							<tr>
								<th><?php echo Jii::t('Remark'); ?></th>
								<td><?php echo $help['remark']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<?php
							if(isset($help['attr']) && is_array($help['attr']) && !empty($help['attr'])){
								?>
								<tr>
									<th colspan="2"><?php echo Jii::t('Attributes'); ?></th>
								</tr>
								<?php
								foreach($help['attr'] AS $k=>$v){
								?>
								<tr>
									<th><?php echo $k; ?></th>
									<td><?php echo $v; ?></td>
								</tr>
								<?php
								}
							}
							?>
						</tfoot>	
					</table>
				</li>
				<?php
				$column[($i%2)].= ob_get_clean();
				$i++;	
			}
			$html .= '<div class="col left"><ul>'.$column[0].'</ul></div><div class="col left"><ul>'.$column[1].'</ul></div><div class="clear"></div>';	
		}
		return $html;	
	}	
}
?>