<?php
set_time_limit(0);
class ZipFolder {
    protected $zip;
    protected $root;
    protected $ignored_names;
    
    function __construct($file, $folder, $ignored=null) {
        $this->zip = new ZipArchive();
        $this->ignored_names = is_array($ignored) ? $ignored : $ignored ? array($ignored) : array();
        if ($this->zip->open($file, ZIPARCHIVE::CREATE)!==TRUE) {
            throw new Exception("cannot open <$file>\n");
        }
        $folder = substr($folder, -1) == '/' ? substr($folder, 0, strlen($folder)-1) : $folder;
        if(strstr($folder, '/')) {
            $this->root = substr($folder, 0, strrpos($folder, '/')+1);
            $folder = substr($folder, strrpos($folder, '/')+1);
        }
        $this->zip($folder);
        $this->zip->close();
    }
    
    function zip($folder, $parent=null) {
        $full_path = $this->root.$parent.$folder;
        $zip_path = $parent.$folder;
        $this->zip->addEmptyDir($zip_path);
        $dir = new DirectoryIterator($full_path);
        foreach($dir as $file) {
            if(!$file->isDot()) {
                $filename = $file->getFilename();
                if(!in_array($filename, $this->ignored_names)) {
                    if($file->isDir()) {
                        $this->zip($filename, $zip_path.'/');
                    }
                    else {
                        $this->zip->addFile($full_path.'/'.$filename, $zip_path.'/'.$filename);
                    }
                }
            }
        }
    }
}

function getUrl(){
	$abs = str_replace('\\', '/', dirname(__FILE__));
	$tempPath1 = explode('/', str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME'])));
	$tempPath2 = explode('/', substr($abs, 0, -1));
	$tempPath3 = explode('/', str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])));
	for ($i = count($tempPath2); $i < count($tempPath1); $i++)
		array_pop ($tempPath3);
	return implode('/', $tempPath3);
}
function getAbsUrl(){
	$urladdr = $_SERVER['HTTP_HOST'] . getUrl();
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	return $protocol.$urladdr;
}
$k = isset($_GET['k'])?$_GET['k']:'';
if($k == 'codendot'){
	// full path used to demonstrate it's root-path stripping ability
	$name = date('l_d_F_Y_H_i',time()).'.zip';
	$zip = new ZipFolder('./'.$name, './'/*dirname(__FILE__), '.svn'*/);

	?>
	<!doctype html>
	<html>
		<head>
			<meta charset="utf-8" />
			<style type="text/css">
			body{ margin:0; padding:0; background:#eee;}
			.link{ position:fixed; width:200px; height:100px; top:50%; left:50%; margin-top:-50px; margin-left:-100px; background:#fff; box-shadow:0 0 5px #000; border-radius:2px;}
			.link:hover{box-shadow:0 0 2px #000;}
			.link a{width:200px; height:100px; line-height:100px; display:block; text-align:center; font-size:24px; font-weight:bold; color:#3c7bc6; text-decoration:none;}
			.link a:hover{ color:#87c334;}
			</style>
			<title></title>
		</head>
		<body>
			<div class="link">
				<a href="<?php echo getAbsUrl().'/'.$name; ?>">Download</a>
			</div>
		</body>
	</html>
<?php
}else{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
							
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
							
	header("Location: ./");
	exit;
}
?>