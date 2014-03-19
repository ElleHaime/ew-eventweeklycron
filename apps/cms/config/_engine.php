<?php
return new \Phalcon\Config([
    'installed' => true,
    'installedVersion' => null,
    'database' => [
        'adapter' => 'pdo\Mysql',
        //'adapter' => 'cacheable\Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'eventweekly_cron',
        'useAnnotations' => false,
        'useCache' => false
    ],
    'application' => [
        'defaultModule' => 'extjs',
        'debug' => true,
        'profiler' => true,
        'baseUri' => '/',
        'engineDir' => ROOT_PATH . '/apps,cms/engine/',
        'modulesDir' => ROOT_PATH . '/apps/cms/modules/',
        'pluginsDir' => ROOT_PATH . '/apps/cms/plugins/',
        'widgetsDir' => ROOT_PATH . '/apps/cms/widgets/',
        'librariesDir' => ROOT_PATH . '/library/',
        'cache' => [
            'output' => [
                'adapter' => 'File',
                'lifetime' => '3600',
                'prefix' => 'event_',
                'cacheDir' => ROOT_PATH . '/apps/cms/var/cache/data/'
            ],
            'data' => [
                'adapter' => 'redis',
                'lifetime' => '60',
                'prefix' => 'event_',
                'redis' => [
                    'host' => '127.0.0.1',
                    'port' => 6379
                ]
            ]
        ],
        /*'session' => [
            'adapter' => 'redis',
            'name' => 'rdsession',
            'lifetime' => '3600',
            'cookie_liftime' => '1440',
            //tcp://host1:6379?weight=1, tcp://host2:6379?weight=2&timeout=2.5, tcp://host3:6379?weight=2"
            'path' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'weight' => 1,
                    'database' => 0,
                    'timeout' => 3,
                    'prefix' => 'session_'
                ]
            ]
        ]
        'session' => [
            'adapter' => 'memcache',
            'name' => 'mcsession',
            'lifetime' => '3600',
            'cookie_lifetime' => '1440',
            'host' => '127.0.0.1',
            'prefix' => 'session_'
        ]*/
        'session' => [
            'adapter' => 'files',
            'name' => 'fsession',
            'lifetime' => '3600',
            'cookie_lifetime' => '1440'
        ],
        'logger' => [
            'enabled' => true,
            'path' => ROOT_PATH . '/apps/cms/var/logs/',
            'format' => '[%date%][%type%] %message%',
            'project' => 'skeleton'
        ],
        'view' => [
            'compiledPath' => ROOT_PATH . '/apps/cms/var/cache/view/',
            'compiledExtension' => '.php',
            'compiledSeparator' => '_',
            'compileAlways' => true
        ],
        'assets' => [
            'local' => PUBLIC_PATH . '/assets/',
            'remote' => '/',
        ],
        'acl' => [
            'adapter' => 'database',
            'db' => 'db',
            'roles' => 'acl_roles',
            'resources' => 'acl_resources',
            'resourcesAccesses' => 'acl_resources_accesses',
            'accessList' => 'acl_access_list',
            'rolesInherits' => 'acl_roles_inherits',
            'authModel' => '\User\Model\Users',
            'authKey'   => 'rememberme'
        ],
        'crypt' => [
            'key' => 'ProjectCryptKey'
        ]
    ],
    'metadata' => [
        //'adapter' => 'Files',
        //'metaDataDir' => ROOT_PATH . '/apps/cms/var/cache/metadata/',
        'adapter' => 'redis',
        'lifetime' => '3600',
        'prefix' => 'event_cron_',
        'redis' => [
            'host' => '127.0.0.1',
            'port' => 6379
        ]
    ],
    'annotations' => [
        'adapter' => 'Files',
        'annotationsDir' => ROOT_PATH . '/apps/cms/var/cache/annotations/',
    ],
    'modules' => [
        'core' => 1,
        'extjs' => 1,
        'cron' => 1
    ],
    'events' => [
    ],
    'plugins' => [
    ]
]);