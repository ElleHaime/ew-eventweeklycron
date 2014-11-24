<?php

return new \Phalcon\Config([

    'messageCenter'=> [
        'local' => [
            'adapter' => 'rabbit',
            'host' => 'localhost',
            'port' => 5672,
            'username' => 'guest',
            'password' => 'guest',
            'vhost' => '/',
            'type' => 'lazy',
            'class' => 'MessageCenter',
            'exchangeType' => 'topic',
            'exchangePrefix' => 'event',
            'queuePrefix' => 'event',
        ]
    ],

    'mailCenter' => [
        'local' => [
            'host' => 'localhost',
            'port' => '3306',
            'dbname' => 'eventweekly_dev',
            'username' => 'root',
            'password' => 'root',
            'path' => realpath(__DIR__.'/../../cron/models/MailCenter')
        ]
    ],

    'elastic' => [
        'local' => [
            'index' => 'eventweekly',
            'connections' => [
                [
                    'host' => 'localhost',
                    'port' => 9200
                ]
            ]
        ]
    ],


]);