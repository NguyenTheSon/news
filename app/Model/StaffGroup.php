<?php
class StaffGroup extends AppModel
{
	###################################
	var $hasMany = array(
		'Service' => array(
			'className'		=> 'StaffGroupService',
			'foreignKey'	=> 'staff_group_id',
			'dependent'		=> true
		),
		'Staff' => array(
			'className'		=> 'Staff',
			'foreignKey'	=> 'staff_group_id',
			'dependent'		=> true
		),
		
	);

}
?>