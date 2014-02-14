<?php
class Crud_Grid_ExtJs_Cron_Logs extends ArOn_Crud_Grid_ExtJs 
{
	protected $_idProperty = 'id';
	public $sort = "process_id";
	public $direction = "ASC";

	public function init() 
    {
		$this->trash = false;
		$this->gridTitle = 'Logs';

		$this->gridActionName = 'cron-logs';
		$this->table = "Db_Cron_Log";
		
		$this->fields = array(
			'id' => new ArOn_Crud_Grid_Column_Numeric('Id', null, true, false, '50'),
			'job' => new ArOn_Crud_Grid_Column_JoinOne('Job', array('Db_Cron_Process','Db_Cron_Job'), null, null, false, '100'),
			'process' => new ArOn_Crud_Grid_Column_JoinOne('Process','Db_Cron_Process', null, null, false, '100'),
			'type' => new ArOn_Crud_Grid_Column_Array('Type', null, true, false, '100'),
			'time' => new ArOn_Crud_Grid_Column_Default('Date', null, true, false, '100'),
			'message' => new ArOn_Crud_Grid_Column_Default('Message', null, true, false, '200')
		);

		$this->fields['type']->options = array('error' => "Error", 'message' => "Message");

		//$this->renderFilterForm = true;
		$this->filters->setPrefix(false);		
		$this->filters->fields = array(
			'search' => new ArOn_Crud_Grid_Filter_Field_Search('search','Search', 
				array(
					array(
						'path' => null,
						'filters' => array(
							ArOn_Db_Filter_Search::ID => ArOn_Db_Filter_Search::EQ
						),
					),
					array(
						'path' => array('Db_Cron_Process'),
						'filters' => array(
							ArOn_Db_Filter_Search::NAME => ArOn_Db_Filter_Search::BEGINS
						)
					),
					array(
						'path' => array('Db_Cron_Process','Db_Cron_Job'),
						'filters' => array(
							ArOn_Db_Filter_Search::NAME => ArOn_Db_Filter_Search::BEGINS,
							'pid' => ArOn_Db_Filter_Search::BEGINS
						)
					)
				)
			),
			//'job' => new ArOn_Crud_Grid_Filter_Field_Select2('id', 'Jobs', 'Db_Cron_Job', array('Db_Cron_Process','Db_Cron_Job')),
            'process' => new ArOn_Crud_Grid_Filter_Field_Select2('process_id','Processes', 'Db_Cron_Process')
		);

		parent::init();
	}
}
