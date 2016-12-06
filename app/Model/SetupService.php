<?php
class SetupService extends AppModel
{
	###################################
	var $belongsTo = array(
		'Setup' => array(
			'className'		=> 'Setup',
			'foreignKey'	=> 'setup_id',
			),
		'StaffGroupService' => array(
			'className'		=> 'StaffGroupService',
			'foreignKey'	=> 'service_id',
			),
		);
	
}
?>