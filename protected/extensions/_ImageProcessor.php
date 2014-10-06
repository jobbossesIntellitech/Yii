<?php
class ImageProcessor{

    private $image;
    private $image_type;
    private $filename;
    private $f;
    private $identity;

    public function __construct($filename) {
		if(!is_file($filename)) $filename = Jii::app()->params['rootPath'].Jii::notfound();
        $this->filename = $filename;
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) {
            $this->image = imagecreatefromjpeg($filename);
        }elseif( $this->image_type == IMAGETYPE_GIF ) {
            $this->image = imagecreatefromgif($filename);
        }elseif( $this->image_type == IMAGETYPE_PNG ) {
            $this->image = imagecreatefrompng($filename);
        }
        $this->identity = 'default';
    }

    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression=100, $permissions=null) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename,$compression);
        }elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image,$filename);
        }elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image,$filename);
        }
        if( $permissions != null) {
            chmod($filename,$permissions);
        }
    }

    public function output($image_type = IMAGETYPE_JPEG) {
        $info = pathinfo($this->filename);
        if($this->existCash($this->f,$info['basename'])){
            return $this->getCashUrl($this->f,$info['basename']);
        }else{
            if( $image_type == IMAGETYPE_JPEG ) {
                $type = 'jpeg';
            }elseif( $image_type == IMAGETYPE_GIF ) {
                $type = 'gif';
            }elseif( $image_type == IMAGETYPE_PNG ) {
                $type = 'png';
            }
            $file = tempnam(sys_get_temp_dir(), 'JS'.ip2long($_SERVER['REMOTE_ADDR']));
            $this->save($file,$image_type);
            $img = file_get_contents($file);
            unlink($file);
            return 'data:image/' . $type . ';base64,' . base64_encode($img);
        }
    }

    public function getWidth() {
        return imagesx($this->image);
    }

    public function getHeight() {
        return imagesy($this->image);
    }

    public function resizeToHeight($height) {
        $this->f = 'resizeToHeight';
        $info = pathinfo($this->filename);
        if(!$this->existCash($this->f,$info['basename'])){
            $ratio = $height / $this->getHeight();
            $width = $this->getWidth() * $ratio;
            $this->resize($width,$height,true);
            $this->saveCash($this->f,$info['basename']);
        }
    }

    public function resizeToWidth($width) {
        $this->f = 'resizeToWidth';
        $info = pathinfo($this->filename);
        if(!$this->existCash($this->f,$info['basename'])){
            $ratio = $width / $this->getWidth();
            $height = $this->getheight() * $ratio;
            $this->resize($width,$height,true);
            $this->saveCash($this->f,$info['basename']);
        }
    }

    public function scale($scale) {
        $this->f = 'scale';
        $info = pathinfo($this->filename);
        if(!$this->existCash($this->f,$info['basename'])){
            $width = $this->getWidth() * $scale/100;
            $height = $this->getheight() * $scale/100;
            $this->resize($width,$height,true);
            $this->saveCash($this->f,$info['basename']);
        }
    }

    public function resize($width,$height,$internalCall = false) {
        if($internalCall){
            $new_image = imagecreatetruecolor($width, $height);
            imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
            $this->image = $new_image;
        }else{
            $this->f = 'resize';
            $info = pathinfo($this->filename);
            if(!$this->existCash($this->f,$info['basename'])){
                $new_image = imagecreatetruecolor($width, $height);
                imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
                $this->image = $new_image;
                $this->saveCash($this->f,$info['basename']);
            }
        }
    }

    public function resizeInto($width,$height,$r = 255,$g = 255,$b = 255){
        $this->f = 'resizeInto';
        $info = pathinfo($this->filename);
        if(!$this->existCash($this->f,$info['basename'])){
            $w = $this->getWidth();
            $h = $this->getHeight();
            $new_w = $width;
            $new_h = $height;
            $new_x = 0;
            $new_y = 0;
            if($w < $width && $h < $height){
                $new_w = $w;
                $new_h = $h;
                $new_x = round(($width - $new_w) / 2);
                $new_y = round(($height - $new_h) / 2);
            }else{
                if($w >= $h){
                    if($w >= $width){
                        $a = $w/$width;
                        $new_h = round($h / $a);
                        $new_y = round(($height - $new_h) / 2);
                    }
                }else{
                    if($h >= $height){
                        $a = $h/$height;
                        $new_w = round($w / $a);
                        $new_x = round(($width - $new_w) / 2);
                    }
                }
            }

            $background = imagecreatetruecolor($width,$height);
            $overflow_color = imagecolorallocate($background,$r,$g,$b);
            imagefill($background,0,0,$overflow_color);

            $new_image = imagecreatetruecolor($new_w, $new_h);
            imagecolortransparent($new_image,imagecolorat($new_image,0,0));
            imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $new_w, $new_h, $this->getWidth(), $this->getHeight());

            $new_image_x = imagesx($new_image);
            $new_image_y = imagesy($new_image);

            // correction empty area in image
            $background2 = imagecreatetruecolor($new_w,$new_h);
            $overflow_color2 = imagecolorallocate($background2,0,0,0);
            imagefill($background2,0,0,$overflow_color2);
            imagecopymerge($background2,$new_image,0,0,0,0,$new_w,$new_h,100);
            $new_image = $background2;

            imagecopymerge($background,$new_image,$new_x,$new_y,0,0,$new_image_x,$new_image_y,100);
            $this->image = $background;
            $this->saveCash($this->f,$info['basename']);
        }
    }

    public function saveCash($f,$savename){
        $path = $this->getCashPath($f,$savename);
        if(!is_file($path)){
            $this->save($path);
            return true;
        }
        return false;

    }

    public function existCash($f,$savename){
        $path = $this->getCashPath($f,$savename);
        if(is_file($path)){
            return true;
        }
        return false;
    }

    public function getCashPath($f,$savename){
        $path = Jii::app()->params['rootPath'].'/assets/cache/';
        if(!is_dir($path)){
            mkdir($path,0777);
        }
        $path .= $f.'/';
        if(!is_dir($path)){
            mkdir($path,0777);
        }

        $path .= md5($this->filename).'/';
        if(!is_dir($path)){
            mkdir($path,0777);
        }

        $path .= $this->identity.'/';
        if(!is_dir($path)){
            mkdir($path,0777);
        }
        return $path.$savename;
    }

    public function getCashUrl($f,$savename){
        $path = Jii::app()->baseUrl.'/assets/cache/';
        $path .= $f.'/';
        $path .= md5($this->filename).'/';
        $path .= $this->identity.'/';
        return $path.$savename;
    }

    public function setIdentity($identity){
        $this->identity = $identity;
    }
}
?>