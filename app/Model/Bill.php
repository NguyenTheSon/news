<?php
class Bill extends AppModel
{
	###################################
	var $hasMany = array(
		'BillService' => array(
			'className'		=> 'BillService',
			'foreignKey'	=> 'bill_id',
			'dependent'		=> true
		),
		
	);
	var $belongsTo = array(
		'User' => array(
			'className'		=> 'User',
			'foreignKey'	=> 'user_id',
			),
		);
	

}
?>