<?php
class Setup extends AppModel
{
	###################################
	var $hasMany = array(
		'SetupService' => array(
			'className'		=> 'SetupService',
			'foreignKey'	=> 'setup_id',
			'dependent'		=> true
		),
	);
	
}
?>