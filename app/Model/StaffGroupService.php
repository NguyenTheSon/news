<?php
class StaffGroupService extends AppModel
{
	###################################
	var $belongsTo = array(
		'StaffGroup' => array(
			'className'		=> 'StaffGroup',
			'foreignKey'	=> 'staff_group_id',
			),
		'Service' => array(
			'className'		=> 'Service',
			'foreignKey'	=> 'service_id',
			),
	);
	

}
?>