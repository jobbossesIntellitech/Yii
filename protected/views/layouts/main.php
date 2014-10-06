<?php
$this->pageTitle = $this->pageTitle.' :: '.Yii::app()->name;
$c = Jii::app()->getController()->id;
$a = Jii::app()->getController()->action->id;
$l = Jii::app()->getLanguage();
$id = isset($_GET['id'])?$_GET['id']:'0';
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
	<head>
		<!-- This Website Powered by Code&Dot -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
		
		<meta name="description" content="<?php echo JMeta::description();?>" />
		<meta name="keywords" content="<?php echo JMeta::keywords();?>" />
        
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/f/main.css.php?lang=<?php echo $l; ?>" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/filecache.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/default-css.css" />
        <!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/assets/css/f/ui.css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/fancybox/source/fancybox.css" />
		<link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/f/fg.menu.css" media="screen" rel="stylesheet" />
		<link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/f/theme/ui.all.css" media="screen" rel="stylesheet" />
        
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/scripts/min.jquery.js"></script><!-- This js is minified -->
        <!--<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/scripts/ui.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/nicescroll/jquery.nicescroll.min.js"></script>-->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/f/carousel.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/fancybox/min.fancybox.js"></script><!-- This js is minified -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/f/min.fg.menu.js"></script><!-- This js is minified -->
    
    
    
        <title><?php echo CHtml::encode(JMeta::title()); ?></title>
        <script type="text/javascript">
		window.sochivi = {};
		window.sochivi.location= {};
		window.sochivi.location.redirect = false;
		$(document).ready(function() {
			//$('body').niceScroll({cursorcolor:"#203b67"});	
			
			$('#hierarchybreadcrumb_1').menu({
				content: $('#hierarchybreadcrumb_1').next().next().next().html(),
				backLink: false
			});	
			$('#hierarchybreadcrumb_2').menu({
				content: $('#hierarchybreadcrumb_2').next().next().next().html(),
				backLink: false
			});
			$('#hierarchybreadcrumb_3').menu({
				content: $('#hierarchybreadcrumb_3').next().next().next().html(),
				backLink: false
			});
			$('#hierarchybreadcrumb_4').menu({
				content: $('#hierarchybreadcrumb_4').next().next().next().html(),
				backLink: false
			});
			$('#hierarchybreadcrumb_5').menu({
				content: $('#hierarchybreadcrumb_5').next().next().next().html(),
				backLink: false
			});
			/*$('#hierarchybreadcrumb_6').menu({
				content: $('#hierarchybreadcrumb_6').next().next().next().html(),
				backLink: false
			});*/
			delete_powered_rating();
        });
		function delete_powered_rating(){
			$('.rw-ui-report .rw-ui-poweredby').html('');
			//alert();
			//window.setTimeout('delete_powered_rating()',1000);
		}
		</script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-31622545-2', 'sochivi.com');
		  ga('send', 'pageview');

		</script>
	</head>
	
	<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=536789549688195";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div class="clear"></div>
		<?php
		/*$facebook = new FacebookLogin('324865007656035', '329533a5085ac2cf6dae3e59877beff3');
		$user = $facebook->doLogin();
		echo 'User\'s URL: ', $user->link, '<br />';
		echo 'User\'s name: ', $user->name, '<br />';
		echo 'Full details:<br /><pre>', print_r($user, true), '</ pre>';*/
		?>
		<div id="bodyWrapper">
			<div id="pageWrapper">	
				<div id="sidebar">
					<?php $this->widget('wSidebar'); ?>
				</div>
				
				<div id="page">
					<div id="header">
						<?php $this->widget('wHeader'); ?>
					</div>
					<div id="menu">
						<?php $this->widget('wNavMenu'); ?>
						<div class="clear"></div>
					</div>
					<div id="body">
						<?php Log::messageView();?>
						<?php echo $content; ?>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="clear"></div>
		<div id="treeWrapper">
			<div id="tree-container">
				<div id="left-tree"></div>
				<div id="right-tree" style="display:none;"></div>
			</div>
		</div>
		
		<div class="clear"></div>		
		<div id="footerWrapper">
			<div id="news-room-container">
				<?php $this->widget('wNews'); ?>
			</div>
			<div class="clear"></div>
			<div id ="footer-container">
				<?php $this->widget('wFooter'); ?>
			</div>
		</div>
		
		<script type="text/javascript">(function(d, t, e, m){
		// Async Rating-Widget initialization.
		window.RW_Async_Init = function(){
			RW.init({
				huid: "153615",
				uid: "9b8d92fa632a24d1b886c64c2ad4eb82",
				source: "website",
				options: {
					"size": "small",
					"style": "crystal"
				} 
			});
			RW.render();
		};

		// Append Rating-Widget JavaScript library.
		var rw, s = d.getElementsByTagName(e)[0], id = "rw-js",
			p = d.location.protocol, a = ("https:" == p ? "secure." + 
			m + "js/" : "js." + m), ck = "Y" + t.getFullYear() + "M" + 
			t.getMonth() + "D" + t.getDate();
		if (d.getElementById(id)) return;              
		rw = d.createElement(e);
		rw.id = id; rw.async = true; rw.type = "text/javascript";
		rw.src = p + "//" + a + "external.min.js?ck=" + ck;
		s.parentNode.insertBefore(rw, s);
	}(document, new Date(), "script", "rating-widget.com/"));</script>
	<script type="text/javascript">
		$(document).ready(function () {
			window.scrollTo(0,0);
		});
	</script>
	</body>
</html>
