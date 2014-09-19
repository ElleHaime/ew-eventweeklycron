<?php
/**
 * @namespace
 */
namespace Search\Index;

use CronManager\Traits\DIaware,
    CronManager\Traits\Observable,
    CronManager\Traits\Message;

/**
 * Class Grid
 * @package Cron\Model\Search
 */
class Grid
{
    use DIaware,Observable,Message;

    /**
     * Dependency injection environment type name
     * @var string
     */
    protected $_env;

    /**
     * Elasticsearch index type name
     * @var string
     */
    protected $_type;

    /**
     * Search grid class name
     * @var string
     */
    protected $_grid;

    /**
     * Construct
     *
     * @param \stdClass $options
     */
    public function __construct(\stdClass $options)
    {
        $this->_env = $options->env;
        $this->_type = $options->type;
        $this->_grid = $options->grid;
    }

    /**
     * Reindex
     */
    public function reindex()
    {
        $environment = $this->getDi()->get($this->_env);
        $adapter = $environment('elastic');
        $modelAdapter = $environment('database');
        $grid = new $this->_grid([], $this->getDi(), null, ['adapter' => $modelAdapter]);
        $indexer = new \Engine\Search\Elasticsearch\Indexer($this->_type, $grid, $adapter);
        $indexer->setDi($this->getDi());
        $indexer->deleteIndex();
        $indexer->createIndex();
        $indexer->setData();
    }
}

