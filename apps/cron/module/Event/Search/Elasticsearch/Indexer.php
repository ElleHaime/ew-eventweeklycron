<?php
/**
 * @namespace
 */
namespace Event\Search\Elasticsearch;

use Engine\Search\Elasticsearch\Indexer as BaseIndexer,
    Engine\Exception,
    Engine\Search\Elasticsearch\Query\Builder,
    Engine\Search\Elasticsearch\Type,
    Engine\Search\Elasticsearch\Query,
    Engine\Crud\Grid,
    Engine\Crud\Grid\Filter,
    Engine\Crud\Grid\Filter\Field;

/**
 * Class Elasticsearch
 *
 * @package Search
 * @subpackage Elasticsearch
 */
class Indexer extends BaseIndexer
{
    /**
     * Delete index type flag
     * @var bool
     */
    protected $_deleteType = false;

    /**
     * Add data from grid to search index
     *
     * @return void
     */
    public function setData()
    {
        $type = $this->getType();
        if ($this->_deleteType && $type->exists()) {
            $type->delete();
        }
        $this->setMapping();
        $grid = ($this->_grid instanceof \Engine\Crud\Grid) ? $this->_grid : new $this->_grid([], $this->getDi());

        $config = [];
        $config['model'] = $grid->getModel();
        $config['conditions'] = $grid->getConditions();
        $config['joins'] = $grid->getJoins();
        $modelAdapter = $grid->getModelAdapter();
        if ($modelAdapter) {
            $config['modelAdapter'] = $modelAdapter;
        }
        $container = new \Engine\Crud\Container\Grid\Mysql($grid, $config);

        $columns = $grid->getColumns();
        foreach ($columns as $column) {
            $column->updateContainer($container);
        }

        $params = $grid->getFilterParams();
        $model = $container->getModel();
        $model->setShardByCriteria($params['location']);

        $dataSource = $container->getDataSource();

        foreach ($columns as $column) {
            $column->updateDataSource($dataSource);
        }

        $filter = $grid->getFilter();
        $filter->setParams($params);
        $filter->applyFilters($dataSource);

        $data = $container->getData($dataSource);
        $pages = $data['pages'];
        $i = 0;
        do {
            foreach ($data['data'] as $values) {
                $this->addItem($values->toArray(), $grid);
            }
            ++$i;
            $grid->clearData();
            $grid->setParams(['page' => $i + 1]);
            $data = $container->getData($dataSource);
        } while ($i < $pages);
    }
}