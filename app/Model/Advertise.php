<?php
class Advertise extends AppModel
{
	public $belongsTo = array(
		'Location' => array(
			'className'		=> 'Location',
			'foreignKey'	=> 'location_id',
			),
		);
}
?>