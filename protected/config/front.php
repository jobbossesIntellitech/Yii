<?php
$frontend = dirname(dirname(__FILE__));
$backend = $frontend.DIRECTORY_SEPARATOR.'backend';
$root = dirname($frontend);

$config = include($root.'/config.inc.php');

Yii::setPathOfAlias('frontend',$frontend);
Yii::setPathOfAlias('backend',$backend);
Yii::setPathOfAlias('root',$root);

return array(
	'basePath'=>$frontend,
	'name'=>$config['app']['name'],
	'language'=>'1',
	'defaultController'=>'web',
	'preload'=>array('log'),
	'import'=>array(
		'frontend.components.*',
			'frontend.components.portlet.*',
			'frontend.components.formgenerator.*',
			'frontend.components.gridview.*',
		'frontend.extensions.*',
		'frontend.extensions.phpmailer.*',
		'frontend.models.*',
			'frontend.models.system.*',
				'frontend.models.system.records.*',
				'frontend.models.system.forms.*',
			'frontend.models.cms.*',
				'frontend.models.cms.records.*',
				'frontend.models.cms.models.*',
			'frontend.models.form.*',
				'frontend.models.form.records.*',
				'frontend.models.form.models.*',
			'frontend.models.menu.*',
				'frontend.models.menu.records.*',
				'frontend.models.menu.models.*',
			'frontend.models.sochivi.*',
				'frontend.models.sochivi.records.*',
				'frontend.models.sochivi.models.*',
		'frontend.shortcodes.*',		
	),
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		
		/*'cache'=>array(
			'class'=>'CApcCache',
		),*/
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'urlSuffix'=>'',
			'rules'=>array(
				
				// cms
				'post/<id:\d+>/<_t>'=>'cms/view',
				
				// Search 
				'search/getSubCategories'=>'search/getSubCategories',
				'search/getSearchFields'=>'search/getSearchFields',
				'search/getCities'=>'search/getCities',
				'search/index'=>'search/index',
				
				//ads
				'ad-<itemid>-<adsid>/<_l1>/<_l2>/<_l3>/<_l4>/<_a>'=>'item/preview',
				'ad-<itemid>-<adsid>/<_l1>/<_l2>/<_l3>/<_a>'=>'item/preview',
				'ad-<itemid>-<adsid>/<_l1>/<_l2>/<_a>'=>'item/preview',
				'ad-<itemid>-<adsid>/<_l1>/<_a>'=>'item/preview',
				'ad-<itemid>-<adsid>/<_a>'=>'item/preview',
				
				// item
				'item-<itemid>/<_l1>/<_l2>/<_l3>/<_l4>'=>'item/list',
				'item-<itemid>/<_l1>/<_l2>/<_l3>'=>'item/list',
				'item-<itemid>/<_l1>/<_l2>'=>'item/list',
				'item-<itemid>/<_l1>'=>'item/list',
				
			
				'<controller:\w+>/<action:\w+>/<id:\d+>/index.html'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>include($frontend.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'db.php'),
		
		'errorHandler'=>array(
			'errorAction'=>'web/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	'params'=>array(
		'rootPath'=>$root,
		'email'=>$config['app']['email'],
		'frondend'=>true,
		'sub'=>$config['install']['directory'],
		'frontendPath'=>$frontend,
		'backendPath'=>$backend,
		'copyright'=>$config['app']['copyright'],
		'developer_copyright'=>$config['app']['developer_copyright'],
		'tablePrefix' => $config['db']['prefix'].'_',
	),
	'modules' => array(
		'apcinfo',
	),
);