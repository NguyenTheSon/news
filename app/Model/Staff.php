<?php
class Staff extends AppModel
{
	###################################
	var $hasMany = array(
		'Setup' => array(
			'className'		=> 'Setup',
			'foreignKey'	=> 'staff_id',
			'dependent'		=> true
			),
		);
	var $belongsTo = array(
		'StaffGroup' => array(
			'className'		=> 'StaffGroup',
			'foreignKey'	=> 'staff_group_id',
			'dependent'		=> true
			),
		);
}
?>