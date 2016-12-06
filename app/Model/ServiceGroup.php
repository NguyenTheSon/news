<?php
class ServiceGroup extends AppModel
{
	###################################
	var $hasMany = array(
		'Service' => array(
			'className'		=> 'Service',
			'foreignKey'	=> 'service_group_id',
			'dependent'		=> true
		),
		
	);
}
?>