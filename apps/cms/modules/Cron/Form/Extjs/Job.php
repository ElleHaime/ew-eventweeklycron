<?php
/**
 * @namespace
 */
namespace Cron\Form\Extjs;

use Engine\Crud\Form\Field;

/**
 * Class Job
 *
 * @category    Module
 * @package     Cron
 * @subpackage  Form
 */
class Job extends Base
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'job';

    /**
     * Form title
     * @var string
     */
    protected $_title = 'Jobs';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Cron\Model\Job';

    /**
     * Container condition
     * @var array|string
     */
    protected $_containerConditions = null;

    /**
     * Initialize form fields
     *
     * @return void
     */
    protected function _initFields()
    {
        $this->_fields = [
			'id' => new Field\Primary('Id'),
			'name' => new Field\Name('Name'),
			'command' => new Field\Text('Command'),
			//'processes' => new Field\JoinMany('Processes', '\Cron\Model\Process', null, null, ', ', 9, '150'),
			'second' => new Field\Text('Second'),
			'minute' => new Field\Text('Minute'),
			'hour' => new Field\Text('Hour'),
			'day' => new Field\Text('Day'),
			'month' => new Field\Text('month'),
			'week_day' => new Field\Text('Week day'),
			'status' => new Field\ArrayToSelect('Status', null, ['1' => "Active", '0' => "Not active"]),
			'ttl' => new Field\Text('Ttl'),
			'max_attempts' => new Field\Text('Max attempts'),
			'description' => new Field\Text('Description')
		];
    }
}
