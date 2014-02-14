<?php
class Crud_Grid_ExtJs_Cron_Settings extends ArOn_Crud_Grid_ExtJs 
{
	protected $_idProperty = 'id';
	public $sort = 'id';
	public $direction = "ASC";

	public function init() 
    {
		$this->trash = false;
		$this->gridTitle = 'Settings';

		$this->gridActionName = 'cron-settings';
		$this->table = "Db_Cron_Settings";
		$this->formClass = 'Crud_Form_ExtJs_Cron_Settings';
		
		$this->fields = array(
			'id' => new ArOn_Crud_Grid_Column_Numeric('Id', null, true, false, '50'),
			'environment' => new ArOn_Crud_Grid_Column_Default('environment', null, true, false, '100'),
			'max_pool' => new ArOn_Crud_Grid_Column_Default('Max pools', null, true, false, '100'),
			'memory_mb' => new ArOn_Crud_Grid_Column_Default('Min free memory in mb', 'min_free_memory_mb', true, false, '100'),
			'memory_percentage' => new ArOn_Crud_Grid_Column_Default('Min free memeory in percentage', 'min_free_memory_percentage', true, false, '100'),
			'cpu' => new ArOn_Crud_Grid_Column_Default('Max cpu load', 'max_cpu_load', true, false, '100'),
			'action_status' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Action'),
			'status' => new ArOn_Crud_Grid_Column_Default('Status', null, true, false, '100')
		);
		
		$this->fields['status']->options = array('1' => "Active", '0' => "Not active");
		$this->filters->setPrefix(false);
		$this->filters->fields = array(
			'search' => new ArOn_Crud_Grid_Filter_Field_Search('search','Search:', 
				array(
					ArOn_Db_Filter_Search::ID => ArOn_Db_Filter_Search::EQ,
					ArOn_Db_Filter_Search::NAME => ArOn_Db_Filter_Search::BEGINS,
					'command' => ArOn_Db_Filter_Search::LIKE
				)
			),
			'id' => new ArOn_Crud_Grid_Filter_Field_Value('id', 'Id',ArOn_Db_Filter_Field::EQ)
		);

		parent::init();
	}
}
