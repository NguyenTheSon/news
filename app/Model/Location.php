<?php
class Location extends AppModel
{
	public $hasMany = array(
		'Advertise' => array(
			'className'		=> 'Advertise',
			'foreignKey'	=> 'location_id',
			'dependent'		=> true
		),
		
	);
}
?>