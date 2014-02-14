<?php
/**
 * @namespace
 */
namespace Cron\Job\MessageCenter;

use Cron\Job\Base;

/**
 * Class Init
 * @package Cron\Job\MessageCenter
 */
abstract class Init extends Base
{
    /**
     * Options
     *
     * @var \stdClass
     */
    protected $_options;

    /**
     * Init function
     *
     * @return void
     */
    protected function _init()
    {
        $config = $this->getDi()->get('config');
        $this->_options = new \stdClass();
        $this->_options->adapter = $config->messageCenter->adapter;
        $this->_options->host = $config->messageCenter->host;
        $this->_options->port = $config->messageCenter->port;
        $this->_options->username = $config->messageCenter->username;
        $this->_options->password = $config->messageCenter->password;
        $this->_options->vhost = $config->messageCenter->vhost;
        $this->_options->type = $config->messageCenter->type;
        $this->_options->class = $config->messageCenter->class;
        $this->_options->exchangeType = $config->messageCenter->exchangeType;
	}
}