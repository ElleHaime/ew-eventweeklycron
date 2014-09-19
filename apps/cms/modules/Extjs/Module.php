<?php
/**
 * @namespace
 */
namespace Extjs;

use Engine\Mvc\Module as BaseModule;

/**
 * Class Event Module
 *
 * @category   Module
 * @package    Event
 */
class Module extends BaseModule
{
    /**
     * Module name
     * @var string
     */
    protected $_moduleName = 'extjs';

    /**
     * Autoload module prefixes
     * @var array
     */
    protected $_loaders = [
        'controller',
        'model',
        'grid'
    ];

    /**
     * Register module services
     * @var array
     */
    protected $_services = [
        'registry',
        'dispatcher',
        'view',
        'volt',
        'crypt',
        'acl',
        'viewer',
        'auth'
    ];

    /**
     * Registers an autoloader related to the module
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function registerAutoloaders($di)
    {
        parent::registerAutoloaders($di);
    }

    /**
     * Registers an autoloader related to the module
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function registerServices($di)
    {
        parent::registerServices($di);

        $adminModulePrefix = ($this->_config->application->adminModulePrefix) ? $this->_config->application->adminModulePrefix : 'admin';
        define('ADMIN_PREFIX', $adminModulePrefix);

        if ($this->_config->application->debug) {
            $this->_initExtjsApplications($di);
        }

        $this->_initConfiguration($di);
        $this->_initTags($di);
    }

    /**
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    private function _initExtjsApplications($di)
    {
        // load all controllers of all modules for routing system
        $modules = $this->_di->get('modules');

        //Use the annotations router
        $defaultModule = $this->_config->application->defaultModule;

        //Read the annotations from controllers
        foreach ($modules as $module => $enabled) {
            if (!$enabled || $module == $defaultModule || $module = $this->_moduleName) {
                continue;
            }
            $files = scandir($this->_config->application->modulesDir . ucfirst($module) . '/Controller'); // get all file names
            foreach ($files as $file) { // iterate files
                if ($file == "." || $file == "..") {
                    continue;
                }
                $key = strtolower(str_replace('Controller.php', '', $file));
                $controller = ucfirst($module).'\Controller\\'.ucfirst($key);
                if (strpos($file, 'Controller.php') !== false) {

                }
            }
        }
    }

    /**
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    private function _initConfiguration($di)
    {
        $options = $di->getDb()->fetchAll("SELECT * FROM `ap_configuration`");
        $params = [];
        foreach ($options as $option) {
            $params[$option['key']] = $option['value'];
        }
        $di->set('configuration', function($key) use ($params) {
            if (!isset($params[$key])) {
                return false;
            }
            return $params[$key];
        });
    }

    /**
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    private function _initTags($di)
    {
        \MegaTag\Core\Configure::set([
            'models' => [
                'tag' => 'Ap\Model\Tag',
                'tag_taxonomy' => 'Ap\Model\Tag\Taxonomy',
                'entity_tag_taxonomy' => 'Ap\Model\Tag\Entity'
            ],
            'entities' => [
                'app',
                'article',
                'app_list'
            ],
            'separator' => ','
        ]);

    }

} 