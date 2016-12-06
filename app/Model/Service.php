<?php
class Service extends AppModel
{
	###################################
	var $hasMany = array(
		'BillService' => array(
			'className'		=> 'BillService',
			'foreignKey'	=> 'service_id',
			'dependent'		=> true
		),
		'StaffGroupService' => array(
			'className'		=> 'StaffGroupService',
			'foreignKey'	=> 'service_id',
			'dependent'		=> true
			),
		
	);
	var $belongsTo = array(
		'ServiceGroup' => array(
			'className'		=> 'ServiceGroup',
			'foreignKey'	=> 'service_group_id',
			),
	);
	

}
?>