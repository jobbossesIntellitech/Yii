<?php
$backend = dirname(dirname(__FILE__));
$frontend = dirname($backend);
$root = dirname($frontend);

$config = include($root.'/config.inc.php');

Yii::setPathOfAlias('frontend',$frontend);
Yii::setPathOfAlias('backend',$backend);
Yii::setPathOfAlias('root',$root);

return array(
	'basePath'=>$backend,
	'name'=>$config['app']['name'].' Panel',
	'defaultController'=>'authentication',
	'preload'=>array('log'),
	'import'=>array(
		// backend
		'backend.models.*',
			'backend.models.admin.*',
				'backend.models.admin.forms.*',
				'backend.models.admin.records.*',
		'backend.components.*',
			'backend.components.widgets.*',
			'backend.components.dashboard.*',
		// forntend
		'frontend.extensions.*',
		'frontend.models.*',
			'frontend.models.system.*',
				'frontend.models.system.records.*',
				'frontend.models.system.models.*',
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
		'frontend.components.gridview.*',
		'frontend.shortcodes.*',
		'frontend.menus.*',	
	),
	'modules'=>array(),
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>include($frontend.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'db.php'),
		'errorHandler'=>array(
            'errorAction'=>'exception/error',
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
		'frondend'=>false,
		'sub'=>$config['install']['directory'],
		'frontendPath'=>$frontend,
		'backendPath'=>$backend,
		'copyright'=>$config['app']['copyright'],
		'developer_copyright'=>$config['app']['developer_copyright'],
		'tablePrefix' => $config['db']['prefix'].'_',
	),
);