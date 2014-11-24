<?php

return new \Phalcon\Config([
    'environment' => [
        'local' => [
            'database' => 'dbMaster',
            'messageCenter' => 'local',
            'mailCenter' => 'local',
            'elastic'  => 'local'
        ]
    ]
]);