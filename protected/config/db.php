<?php
return array(
			'connectionString' => 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'],
			'emulatePrepare' => true,
			'username' => $config['db']['user'],
			'password' => $config['db']['password'],
			'charset' => 'utf8',
			//'tablePrefix' => $config['db']['prefix'].'_',
		);