<?php
namespace Cron;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{

	/**
	 * Register a specific autoloader for the module
	 */
	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(
			[
				'Cron\Model'	=> '../apps/cron/model/',
				'Cron\Task'	    => '../apps/cron/task/',
                'Cron\Job'	    => '../apps/cron/job/',
				'Library'		=> '../library'
			]
		);

		$loader->register();
	}

	/**
	 * Register specific services for the module
	 */
	public function registerServices($di)
	{
		//Registering a dispatcher
		
		$di->setShared('dispatcher', function() {
			$dispatcher = new \Phalcon\CLI\Dispatcher();
			$dispatcher->setDefaultNamespace("Cron\Task\\");
			
			return $dispatcher;
		});
		
		$config = include("config/config.php");
		$di->set('config', $config);
		/*$di->set('profiler', function(){
			return new \Phalcon\Db\Profiler();
		}, true);
		
			$di->set('db', function() use ($di, $config) {
		
				$eventsManager = new \Phalcon\Events\Manager();
		
				//Get a shared instance of the DbProfiler
				$profiler = $di->getProfiler();
		
				//Listen all the database events
				$eventsManager->attach('db', function($event, $connection) use ($profiler) {
					if ($event->getType() == 'beforeQuery') {
						$profiler->startProfile($connection->getSQLStatement());
					}
					if ($event->getType() == 'afterQuery') {
						$profiler->stopProfile();
					}
				});
		
					$connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
							"host" => $config->database->host,
							"username" => $config->database->username,
							"password" => $config->database->password,
							"dbname" => $config->database->name
					));
		
					//Assign the eventsManager to the db adapter instance
					$connection->setEventsManager($eventsManager);
		
					return $connection;
			});*/
		
		/**
		 * Database connection is created based in the parameters defined in the configuration file
		 */
		$di->set('db', function() use ($config) {
			$db = new \Phalcon\Db\Adapter\Pdo\Mysql([
				"host" => $config->database->host,
				"username" => $config->database->username,
				"password" => $config->database->password,
				"dbname" => $config->database->name
			]);
			$db->query('SET QUERY_CACHE_TYPE = OFF;');
			$result = $db->query("SHOW VARIABLES LIKE 'wait_timeout'");
			$result = $result->fetchArray();
			$db->timeout = (int) $result['Value'];
			$db->start = time();
			$eventsManager = new \Phalcon\Events\Manager();
			//Listen all the database events
			$eventsManager->attach('db', function($event, $db) {
                $sql = $db->getSQLStatement();
				if ($event->getType() == 'beforeQuery' && $sql != 'SELECT 1+2+3') {
                    try {
                        $res = $db->query('SELECT 1+2+3');
                        $resArray = $res->fetch();
                        if ($resArray[0] != 6) {
                            $db->connect();
                        }
                    }  catch (PDOException $e) {
                        $db->connect();
                    }
					$activeTimeout = time() - $db->start;
					if ($activeTimeout > $db->timeout || ($db->timeout - $activeTimeout) < 2) {
						//$db->connect();
						$db->start = time();
					}
						
					return true;
				}
			});
					
			//Assign the eventsManager to the db adapter instance
			$db->setEventsManager($eventsManager);
			
			return $db;
		});
		
		$di->set('dbEventWeekly', function() use ($config) {
			$db = new \Phalcon\Db\Adapter\Pdo\Mysql([
				"host" => $config->dbEventWeekly->host,
				"username" => $config->dbEventWeekly->username,
				"password" => $config->dbEventWeekly->password,
				"dbname" => $config->dbEventWeekly->name
			]);
			
			$result = $db->query("SHOW VARIABLES LIKE 'wait_timeout'");
			$result = $result->fetchArray();
			$db->timeout = (int) $result['Value'];
			$db->start = time();
			$eventsManager = new \Phalcon\Events\Manager();
			//Listen all the database events
			$eventsManager->attach('dbEventWeekly', function($event, $db) {
                $sql = $db->getSQLStatement();
                if ($event->getType() == 'beforeQuery' && $sql != 'SELECT 1+2+3') {
                    try {
                        $res = $db->query('SELECT 1+2+3');
                        $resArray = $res->fetch();
                        if ($resArray[0] != 6) {
                            $db->connect();
                        }
                    }  catch (PDOException $e) {
                        $db->connect();
                    }
                    $activeTimeout = time() - $db->start;
                    if ($activeTimeout > $db->timeout || ($db->timeout - $activeTimeout) < 2) {
                        //$db->connect();
                        $db->start = time();
                    }

                    return true;
                }
			});
					
			//Assign the eventsManager to the db adapter instance
			$db->setEventsManager($eventsManager);
			
			return $db;
		});
		
		$di->set('modelsManager', function(){
			return new \Phalcon\Mvc\Model\Manager();
		});
		
		/**
		 * If the configuration specify the use of metadata adapter use it or use memory otherwise
		*/
		$di->set('modelsMetadata', function() use ($config) {
			if (isset($config->models->metadata)) {
				$metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\'.$config->models->metadata->adapter;
				return new $metadataAdapter();
			} else {
				return new \Phalcon\Mvc\Model\Metadata\Memory();
			}
		});
		
		$di->set('thumperConnection', function() use ($config) {
			$connections = [
				'default' => new \PhpAmqpLib\Connection\AMQPLazyConnection($config->rabbitmq->host, $config->rabbitmq->port, $config->rabbitmq->username, $config->rabbitmq->password, $config->rabbitmq->vhost)
			];			
			return new \Thumper\ConnectionRegistry($connections, 'default');
		});
	}

}