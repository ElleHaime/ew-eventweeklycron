<?php
/**
 * @namespace
 */
namespace User\Form\Extjs;

use Engine\Crud\Form\Field;

/**
 * Class Users
 *
 * @category    Module
 * @package     User
 * @subpackage  Form
 */
class Users extends Base
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'users';

    /**
     * Form title
     * @var string
     */
    protected $_title = 'Users';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\User\Model\Users';

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
			'id'        => new Field\Primary('Id'),
            'name'      => new Field\Name('Name'),
            'password'  => new Field\Password('Password'),
            'password_confirm'  => new Field\PasswordConfirm('Password', 'password'),
			'role'      => new Field\ManyToOne('Role', '\ExtjsCms\Model\Acl\Role')
		];
    }
}
