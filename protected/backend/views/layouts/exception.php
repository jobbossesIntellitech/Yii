<?php
$this->pageTitle = $this->pageTitle.' :: '.Yii::app()->name;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/b/exception.css" />
    
    

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<center>
	<div id="page">
    	
       <div class="error"><?php echo Yii::t("lng","Error"); ?> - <?php echo Yii::app()->errorHandler->error["code"];  ?></div>
       <div class="content"><?php echo $content; ?></div>
        
    </div>
</center>
</body>
</html>