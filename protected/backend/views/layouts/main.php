<?php
$l = Language::model()->findByPk(Jii::app()->language);
$c = Jii::app()->controller->getId();
$a = Jii::app()->controller->action->getId();
if(isset($l->lng_id)){
?>
<!DOCTYPE html>
<html dir="<?php echo $l->lng_direction; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link 
    	rel="stylesheet" 
    	type="text/css" 
        href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/b/main.css.php?dir=<?php echo Jii::app()->user->direction.'&color='.Jii::app()->user->color; ?>"
    />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/default-css.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/b/print.css.php" media="print" />
    <script type="text/javascript" src="<?php echo Jii::app()->request->baseUrl; ?>/assets/scripts/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Jii::app()->request->baseUrl; ?>/assets/scripts/nicescroll.js"></script>
    <script type="text/javascript" src="<?php echo Jii::app()->request->baseUrl; ?>/assets/js/b/jtools.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <script type="text/javascript">
	$(document).ready(
	  function() {
		$("#sidebar1").niceScroll();
		$("#sidebar2").niceScroll();
	});
	function printPage(){
		var title = $('title').text();
		var currentTime = new Date();
		var month = currentTime.getMonth() + 1;
		var day = currentTime.getDate();
		var year = currentTime.getFullYear();
		var hour = currentTime.getHours();
		var minute = currentTime.getMinutes();
		$('title').text(title+'_'+day+'_'+month+'_'+year+'_'+hour+'_'+minute+'_'+(Math.ceil(Math.random()*1000)));
		var height = $('#outerContent').height();
		$('#innerContent').css('overflow','visible');
		$('#outerContent').height( parseInt($('#innerContent').prop("scrollHeight"))+100 );
		print();
		$('title').text(title);
		$('#outerContent').height( height );
		$('#innerContent').css('overflow','auto');
	}
	</script>
</head>

<body>
	<?php Log::messageView(); ?>
	<?php $this->widget('wHelp',array('c'=>$c,'a'=>$a,'title'=>$this->pageTitle)); ?>
	<?php $this->widget('wShortcodeHelper'); ?>
	<div id="headerWrapper">
    	<?php $this->widget('wHeader',array('language'=>$l)); ?>
    </div>
    <div id="bodyWrapper">
    	<?php $this->widget('wMainMenu'); ?>
        <div id="contentArea">
        	<div id="outerPageTitle">
            	<div id="innerPageTitle">
                	<h1><?php echo $this->pageTitle; ?></h1>
                    <ul>
                    	<li id="home">
                        	<a href="<?php echo Jii::app()->createUrl($c.'/index'); ?>"><?php echo Jii::t('Home'); ?></a>
                        </li>
                        <li id="back">
                        	<a href="<?php echo Jii::app()->request->urlReferrer; ?>"><?php echo Jii::t('Back'); ?></a>
                        </li>
                        <li id="print">
                        	<a href="javascript://" onClick="printPage(); return false;"><?php echo Jii::t('Print'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="outerContent">
            	<div id="innerContent">
                	<?php
					echo $content;
					?>
                </div>
            </div>
        </div>
    </div>
    <div id="footerWrapper">
    	<?php $this->widget('wFooter'); ?>
    </div>
</body>
</html>
<?php
}else{
	$this->redirect(array('authentication/logout'));	
}
?>