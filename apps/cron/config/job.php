<?php

return new \Phalcon\Config([
    'backup' => [
        'database' => [
            'db' => [
                'adapter' => 'db',
                'path' => realpath(__DIR__.'/../../cron/data/').'/backup/database',
                'databases' => [
                    'apppicker_production' => [
                        'database' => 'apppick_production',
                    ]
                ]
            ]
        ],
    ],

    'search' => [
        'local' => [
            'env' => 'local',
            'grids' => [
                [
                    'grid' => '\Event\Grid\Search\Event',
                    'type' => 'event'
                ]
            ]
        ]
    ],

    'defaultQueue' => [
        'local' => []
    ]
]);