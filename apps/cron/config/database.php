<?php

return new \Phalcon\Config([
    'database' => [
        'db' => [
            'adapter'  => 'Mysql',
            'host'     => 'localhost',
            //'host'     => '127.0.0.1',
            //'port'     => '3306',
            'username' => 'root',
            'password' => 'root',
            'name'     => 'eventweekly_cron',
            'charset'  => 'utf8'
        ],
        'dbMaster' => [
            'adapter'  => 'Mysql',
            'host'     => 'localhost',
            //'host'     => '127.0.0.1',
            //'port'     => '3306',
            'username' => 'root',
            'password' => 'root',
            'name'     => 'eventweekly_dev',
            'charset'  => 'utf8'
        ]
    ]
]);