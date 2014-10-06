<?php
$this->pageTitle = $this->pageTitle.' :: '.Yii::app()->name;
$c = Jii::app()->getController()->id;
$a = Jii::app()->getController()->action->id;
$l = Jii::app()->getLanguage();
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/f/main.css.php?lang=<?php echo $l; ?>" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/f/ui.css" />
        
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/scripts/jquery.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/scripts/ui.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/nicescroll/jquery.nicescroll.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/f/carousel.js"></script>
    
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script type="text/javascript">
		$(document).ready(function() {
			$('body').niceScroll({cursorcolor:"#203b67"});		
        });
		</script>
	</head>
	
	<body>
		<div id="pageWrapper">
			<div id="headerWrapper">
				<div id="logo" class="left">
					<a href="<?php echo Jii::app()->getHomeUrl(); ?>"></a>
				</div>
				<div class="clear"></div>
			</div>
			<div id="bodyWrapper">
				<?php echo $content; ?>
			</div>
		</div>
	</body>
</html>