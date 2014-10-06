<?php 
ob_start();
	set_time_limit(0);
	date_default_timezone_set('Asia/Beirut');
	define("INDEX",'admin.php');
	// Create Yii Application
	$yii=dirname(__FILE__).'/yii/yii.php';
	$config=dirname(__FILE__).'/protected/backend/config/back.php';
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
	require_once($yii);
	Yii::createWebApplication($config)->run();
ob_flush();