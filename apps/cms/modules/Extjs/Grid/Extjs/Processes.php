<?php
class Crud_Grid_ExtJs_Cron_Processes extends ArOn_Crud_Grid_ExtJs 
{
	protected $_idProperty = 'id';
	public $sort = "job_id";
	public $direction = "ASC";

	public function init() 
    {
		$this->trash = false;
		$this->gridTitle = 'Processes';
		$this->_window_width = 100;
		$this->_renderFilters = true;
		$this->formClass = 'Crud_Form_ExtJs_Cron_Processes';
		$this->gridActionName = 'cron-processes';
		$this->table = "Db_Cron_Process";
		$this->fields = array(
			'id' => new ArOn_Crud_Grid_Column_Numeric('Id', null, true, false, '50'),
        	'job' => new ArOn_Crud_Grid_Column_JoinOne('Job', 'Db_Cron_Job', null, null, false, '100'),
			'logs' => new ArOn_Crud_Grid_Column_JoinMany('Logs', 'Db_Cron_Log', null, null, ', ', 9, '150'),
			'command' => new ArOn_Crud_Grid_Column_Default('Command', null, true, false, '100'),
        	'hash' => new ArOn_Crud_Grid_Column_Default('Hash', null, true, false, '100'),
        	'action' => new ArOn_Crud_Grid_Column_Default('Action', null, true, false, '150'),
        	'pid' => new ArOn_Crud_Grid_Column_Default('Pid', null, true, false, '60'),        	
			'status' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Status'),
			'stime' => new ArOn_Crud_Grid_Column_Default('Start Time', null, true, false, '150'),
			'time' => new ArOn_Crud_Grid_Column_Default('Time', null, true, false, '60'),
			'phash' => new ArOn_Crud_Grid_Column_Default('Parent Hash', null, true, false, '100'),
			'attempt' => new ArOn_Crud_Grid_Column_Default('Attempt', null, true, false, '60')
		);	
	
		//$this->fields['status']->setOptions(array('run' => 'Run','running' => 'Running','completed' => 'Completed','error' => 'Error','stopped' => 'Stopped','stop' => 'Stop','waiting' => 'Waiting','finished' => 'Finished'));
		$this->fields['logs']->setAction ('cron-logs','process');

		$this->renderFilterForm = true;
		$this->filters->setPrefix(false);		
		$this->filters->fields = array(
			'search' => new ArOn_Crud_Grid_Filter_Field_Search('search','Search:', 
				array(
					array(
						'path' => null,
						'filters' => array(
							ArOn_Db_Filter_Search::ID => ArOn_Db_Filter_Search::EQ,
							ArOn_Db_Filter_Search::NAME => ArOn_Db_Filter_Search::LIKE,
							'pid' => ArOn_Db_Filter_Search::EQ,
						),
					),
					array(
						'path' => array('Db_Site_SeoModule'),
						'filters' => array(
							ArOn_Db_Filter_Search::NAME => ArOn_Db_Filter_Search::LIKE
						)
					)
				)
			),
			'pid' => new ArOn_Crud_Grid_Filter_Field_Value('pid', 'Pid',ArOn_Db_Filter_Field::EQ),
            'job' => new ArOn_Crud_Grid_Filter_Field_Select2('job_id', 'Job', 'Db_Cron_Job'),
			'status' => new ArOn_Crud_Grid_Filter_Field_Array2Select('status', 'Status', array('run' => 'Run','running' => 'Running','completed' => 'Completed','error' => 'Error','stopped' => 'Stopped','stop' => 'Stop','waiting' => 'Waiting','finished' => 'Finished'))
		);

		parent::init();
	}
}
