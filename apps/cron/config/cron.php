<?php

return new \Phalcon\Config([
    'application' => [
        'controllersDir' => realpath(__DIR__ . '/../../cron/controllers/'),
        'modelsDir'      => realpath(__DIR__ . '/../../cron/models/'),
        'libraryDir'     => realpath(__DIR__ . '/../../cron/library/'),
        'dataDir'		 => realpath(__DIR__ . '/../../cron/data/'),
        'appDir'		 => realpath(__DIR__ . '/../../cron/'),
        'rootDir'		 => realpath(__DIR__ . '/../../../'),
        'documentRoot'	 => realpath(__DIR__ . '/../../../cli/'),
        'baseUri'        => 'eventweekly.loc',
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
        'socket' => 'unix:///tmp/php.event.cron.manager.sock',
        'log' => '/tmp/php.event.cron.manager.log',
        'error' => '/tmp/php.event.cron.manager.error.log',
        'pid' => '/tmp/php.event.cron.manager.pid',
        'lock' => '/tmp/php.event.cron.manager.lock',
        'settings' => [
            'type' => 'model',
            'model' => '\CronManager\Queue\Model\Settings',
            'environment' => 'develop'
        ]
    ]
]);