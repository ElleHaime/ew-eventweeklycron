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
        $searchAdapter = $environment('elastic');
        $modelAdapter = $environment('database');

        $location = new \Event\Model\Location();
        $location->setReadConnectionService($modelAdapter);
        $locations = $location->find()->toArray();
        $first = true;
        foreach ($locations as $location) {
            $params = ['location' => $location['id']];
            $this->_index($params, $modelAdapter, $searchAdapter, $first);
            $first = false;
        }
    }

    /**
     * Indexing with params
     *
     * @param string $location
     * @param string $modelAdapter
     * @param string $searchAdapter
     */
    protected function _index($params, $modelAdapter, $searchAdapter, $removeIndex = false)
    {
        var_dump($params);
        $grid = new $this->_grid($params, $this->getDi(), null, ['adapter' => $modelAdapter]);
        $indexer = new \Event\Search\Elasticsearch\Indexer($this->_type, $grid, $searchAdapter);
        $indexer->setDi($this->getDi());
        if ($removeIndex) {
            $indexer->deleteIndex();
            $indexer->createIndex();
        }
        $indexer->setData();
    }
}