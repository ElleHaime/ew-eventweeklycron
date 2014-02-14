<?php
class Crud_Grid_ExtJs_Cron_Jobs extends ArOn_Crud_Grid_ExtJs 
{
	protected $_idProperty = 'id';
	public $sort = 'id';
	public $direction = "ASC";

	public function init() 
    {
		$this->trash = false;
		$this->gridTitle = 'Jobs';
		$this->_window_width = 900;
		$this->formClass = 'Crud_Form_ExtJs_Cron_Jobs';
		
		$this->gridActionName = 'cron-jobs';
		$this->table = "Db_Cron_Job";
		$this->fields = array(
			'id' => new ArOn_Crud_Grid_Column_Numeric('Id',null,true,false,'50'),
			'name' => new ArOn_Crud_Grid_Column_Default('Name', null, true, false, '100'),
			'command' => new ArOn_Crud_Grid_Column_Default('Command', null, true, false, '160'),
			'processes' => new ArOn_Crud_Grid_Column_JoinMany('Processes', 'Db_Cron_Process', null, null, ', ', 9, '150'),
			'second' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Second'),
			'minute' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Minute'),
			'hour' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Hour'),
			'day' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Day'),
			'month' => new ArOn_Crud_Grid_Column_FormColumnExtJs('month'),
			'week_day' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Week day'),
			'status' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Status'),
			'ttl' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Ttl'),
			'max_attempts' => new ArOn_Crud_Grid_Column_FormColumnExtJs('Max attempts'),
			'desc' => new ArOn_Crud_Grid_Column_Default('Description', null, true, false, '100')
		);
		
		$this->fields['processes']->setAction ('cron-processes','job');
		//$this->fields['status']->options = array('1' => "Active", '0' => "Not active");
		//$this->fields['status']->setEmptyValue('Not active');
		
		$this->renderFilterForm = true;
		$this->filters->setPrefix(false);
		$this->filters->fields = array(
			'search' => new ArOn_Crud_Grid_Filter_Field_Search('search','Search:', 
				array(
					ArOn_Db_Filter_Search::ID => ArOn_Db_Filter_Search::EQ,
					ArOn_Db_Filter_Search::NAME => ArOn_Db_Filter_Search::BEGINS,
					'command' => ArOn_Db_Filter_Search::LIKE
				)
			),
			'id' => new ArOn_Crud_Grid_Filter_Field_Value('id', 'Id', ArOn_Db_Filter_Field::EQ),
			'name' => new ArOn_Crud_Grid_Filter_Field_Text('name', 'Name', ArOn_Db_Filter_Search::BEGINS),
			'status' => new ArOn_Crud_Grid_Filter_Field_Array2Select('status', 'Status', array('1' => "Active", '0' => "Not active"))
		);

		parent::init();
	}
}
