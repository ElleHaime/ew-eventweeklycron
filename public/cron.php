#!/usr/local/bin/php
<?php
chdir(__DIR__);
require_once '../vendor/autoload.php';

$di = new Phalcon\DI\FactoryDefault\CLI();

$app = new Phalcon\CLI\Console();
$app->setDI($di);
$app->registerModules([
    'cron' => [
        'className' => 'Cron\Module',
        'path'      => '../apps/cron/Module.php',
    ]
]);

array_shift($argv);
$count = count($argv);
if ($count < 2) {
	if ($count == 0) {
		throw new \Exception('CLI router arguments not have task and action');
	} 
	if ($count == 1) {
		throw new \Exception('CLI router arguments not have action');
	}
}
$params = ['module' => 'cron'];
$params['task'] = array_shift($argv);
$params['action'] = array_shift($argv);
if ($argv) {
	$params = array_merge($params, $argv);
}
$app->handle($params);
