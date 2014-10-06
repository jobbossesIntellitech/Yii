<?php
$this->pageTitle = $this->pageTitle.' :: '.Yii::app()->name;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta charset="utf-8">
        
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/b/browser.css" />
        
        <!-- JS: LIBARIES AND PLUGINS -->
        <script type="text/javascript" src="<?php echo Jii::app()->request->baseUrl; ?>/assets/scripts/jquery.js"></script>
    
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="pagetitle">
            <?php echo $this->pageTitle; ?>
        </div>
        <?php 
        if (Jii::app()->user->hasFlash('success')){ 
            echo '<div class="message-box"><div class="success">'.Jii::app()->user->getFlash('success').'</div></div>';
            Jii::app()->clientScript->registerScript('myHideEffect','$(".message-box").animate({opacity: 1.0}, 10000).fadeOut("slow");',CClientScript::POS_READY);
        }elseif(Jii::app()->user->hasFlash('error')){
            echo '<div class="message-box"><div class="error">'.Jii::app()->user->getFlash('error').'</div></div>';
            Jii::app()->clientScript->registerScript('myHideEffect','$(".message-box").animate({opacity: 1.0}, 10000).fadeOut("slow");',CClientScript::POS_READY);
        }
        ?>
        <div class="content"><?php echo $content; ?></div>
    </body>
</html>