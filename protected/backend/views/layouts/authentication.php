<?php
$this->pageTitle = $this->pageTitle.' :: '.Yii::app()->name;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo Jii::app()->request->baseUrl; ?>/assets/css/b/authentication.css" />
<script type="text/javascript" src="<?php echo Jii::app()->request->baseUrl; ?>/assets/scripts/jquery.js"></script>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<script type="text/javascript">
$(document).ready(function(){
	repositionMarginPanel();	
});
function repositionMarginPanel(){
	var panel = $('.panel');
	var width = panel.outerWidth();
	var height = panel.outerHeight();
	panel.css({marginLeft: -(Math.ceil(width/2))+'px',marginTop:-(Math.ceil(height/2))+'px'});
}
</script>
</head>
<body>
	<div class="wrapper">
		<?php
			echo $content;
		?>
	</div>
</body>
</html>