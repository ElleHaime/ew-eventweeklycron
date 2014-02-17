<?php

return new \Phalcon\Config([
	'database' => [
		'adapter'  => 'Mysql',
		'host'     => 'localhost',
		//'host'     => '127.0.0.1',
		//'port'     => '3306',
		'username' => 'root',
		'password' => 'root',
		'name'     => 'eventweekly_cron',
		'charset'  => 'utf8'
	],
	'dbEventweekly' => [
		'adapter'  => 'Mysql',
		'host'     => 'localhost',
		//'host'     => '127.0.0.1',
		//'port'     => '3306',
		'username' => 'root',
		'password' => 'root',
		'name'     => 'eventweekly_dev',
		'charset'  => 'utf8'
	],
	'application' => [
		'controllersDir' => realpath(__DIR__ . '/../../cron/controllers/'),
		'modelsDir'      => realpath(__DIR__ . '/../../cron/models/'),
		'libraryDir'     => realpath(__DIR__ . '/../../cron/library/'),
		'dataDir'		 => realpath(__DIR__ . '/../../cron/data/'),
		'appDir'		 => realpath(__DIR__ . '/../../cron/'),
		'rootDir'		 => realpath(__DIR__ . '/../../../'),
		'documentRoot'	 => realpath(__DIR__ . '/../../../cli/'),
		'baseUri'        => 'eventweekly-cron.loc',
	],
	'models' => [
		'metadata' => [
			'adapter' => 'Memory'
		]
	],
	'rabbitmq' => [
		'host' => 'localhost',
		'port' => 5672,
		'username' => 'guest',
		'password' => 'guest',
		'vhost' => '/',
		'jobExchangeName' => 'eventweekly-cron-cli-job-exchange',
		'managerExchangeName' => 'eventweekly-cron-cli-manager-exchange',
		'exchangeType' => 'topic',
		'queueName' => 'cron-cli-queue'
	],
	'daemon' => [
		'socket' => 'unix:///tmp/php.cron.manager.sock',
		'log' => '/tmp/php.cron.manager.log',
		'error' => '/tmp/php.cron.manager.error.log',
		'pid' => '/tmp/php.cron.manager.pid',
		'lock' => '/tmp/php.cron.manager.lock',
		'settings' => [
			'type' => 'model',
			'model' => '\CronManager\Queue\Model\Settings',
			'environment' => 'develop'
		]
	],
    'messageCenter'=> [
        'loc' => [
            'adapter' => 'rabbit',
            'host' => 'localhost',
            'port' => 5672,
            'username' => 'guest',
            'password' => 'guest',
            'vhost' => '/',
            'type' => 'lazy',
            'class' => 'MessageCenter',
            'exchangeType' => 'topic',
            'exchangePrefix' => 'loc',
            'queuePrefix' => 'loc',
            'connection' => 'dbEventweekly'
        ]
    ],
    'mailcenter' => [
        'host' => 'localhost',
        'port' => '3306',
        'dbname' => 'apppick_production',
        'username' => 'root',
        'password' => 'root',
        'path' => realpath(__DIR__ . '/../../cron/models/MailCenter')
    ]
]);