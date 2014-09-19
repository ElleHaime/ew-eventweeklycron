<?php
/**
 * @namespace
 */
namespace MessageCenter;

use MessageCenter\Model\Exchange,
    MessageCenter\Model\Queue,
    MessageCenter\Model\QueueToExchange;

/**
 * Class Adapter
 * @package MessageCenter
 */
class Adapter
{
	/**
	 * Queue adapter
	 * @var string
	 */
	private $_adapter;
	
	/**
	 * Host adress
	 * @var string
	 */
	private $_host;
	
	/**
	 * Port
	 * @var string
	 */
	private $_port;
	
	/**
	 * User name for auth
	 * @var string
	 */
	private $_username;
	
	/**
	 * Password
	 * @var string
	 */
	private $_password;
	
	/**
	 * Virtual host
	 * @var string
	 */
	private $_vhost;
	
	/**
	 * Connection type
	 * @var string
	 */
	private $_type;

    /**
     * Config object
     * @var array
     */
    private $_config;

    /**
     * Construct
     *
     * @param \stdClass $options
     */
    public function __construct(\stdClass $options)
    {
        $this->_config = array();
        $this->_config['adapter'] = $options->adapter;
        $this->_config['host'] = $options->host;
        $this->_config['port'] = $options->port;
        $this->_config['username'] = $options->username;
        $this->_config['password'] = $options->password;
        $this->_config['vhost'] = $options->vhost;
        $this->_config['type'] = $options->type;
        $this->_config['exchangeType'] = $options->exchangeType;
        $this->_config['storageQueue'] = new Queue();
        $this->_config['storageQueueRouters'] = new QueueToExchange();
        $this->_config['storageExchange'] = new Exchange();
    }
	
	/**
	 * Return exchange adapter
     *
	 * @param string $name
	 * @return \QueueCenter\Exchange
	 */
	public function getExchange($name)
	{
		return new \QueueCenter\Exchange($name, $this->_config);
	}
	
	/**
     * Return storage exchange adapter
	 * 
	 * @return \QueueCenter\Storage\Exchange
	 */
	public function getStorageExchange()
	{
		return new \QueueCenter\Storage\Exchange($this->_config);
	}
	
	/**
     * Add new user uxchange to queue
	 * 
	 * @param integer $userId
	 * @param string $name
	 * @return boolean
	 */
	public function addUserExchange($userId, $name)
	{
		return \QueueCenter\Exchange::addUserExchange($this->_config, $userId, $name);
	}
	
	/**
     * Publish new user message to exchange
	 * 
	 * @param integer $userId
	 * @param string $name
	 * @param array|string $message
	 * @param string $handler
	 * @return boolean
	 */
	public function publishUserMeassage($userId, $name, $message, $handler, $routingKey = "*")
	{
		return \QueueCenter\Exchange::publishToUserExchange($this->_config, $userId, $name, $message, $handler, $routingKey);
	}
	
	/**
	 * Return user exchange name by id and name
     *
	 * @param integer $userId
	 * @param string $name
	 * @return string
	 */
	public function generateUserExchangeName($userId, $name)
	{
		return \QueueCenter\Exchange::generateUserExchangeName($userId, $name);
	}
	
	/**
	 * Return queue adapter
     *
	 * @param string $name
	 * @return \QueueCenter\Queue
	 */
	public function getQueue($name)
	{
		return new \QueueCenter\Queue($name, $this->_config);
	}
	
	/**
     * Return queue storage
	 * 
	 * @return \QueueCenter\Storage\Queue
	 */
	public function getStorageQueue()
	{
		return new \QueueCenter\Storage\Queue($this->_config);
	}
	
	/**
	 * Add user quque
     *
	 * @param integer $userId
	 * @param string $name
	 * @return boolean
	 */
	public function addUserQueue($userId, $name)
	{
		return \QueueCenter\Queue::addUserQueue($this->_config, $userId, $name);
	}
	
	/**
	 * Return user queue name by id and name
     *
	 * @param integer $userId
	 * @param string $name
	 * @return string
	 */
	public function generateUserQueueName($userId, $name)
	{
		return \QueueCenter\Queue::generateUserQueueName($userId, $name);
	}
	
	/**
	 * Bind user queue to exchange
     *
	 * @param integer $userId
	 * @param string $name
	 * @param integer $exchangeId
	 * @return boolean
	 */
	public function bindUserQueue($userId, $name, $exchangeId, $routingKey = "*")
	{
		return \QueueCenter\Queue::bindUserQueue($this->_config, $userId, $name, $exchangeId, $routingKey);
	}
	
	/**
     * Unbind user queue from exchange
	 * 
	 * @param integer $userId
	 * @param string $name
	 * @param integer $exchangeId
	 * @return boolean
	 */
	public function unbindUserQueue($userId, $name, $exchangeId, $routingKey = "*")
	{
		return \QueueCenter\Queue::unbindUserQueue($this->_config, $userId, $name, $exchangeId, $routingKey);
	}
	
	/**
	 * Return queue handler adapter
     *
	 * @return \QueueCenter\Queue\Handler
	 */
	public function getHandler()
	{
		return new \QueueCenter\Queue\Handler($this->_config);	
	}
}