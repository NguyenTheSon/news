<?php
class BillService extends AppModel
{
	###################################
		var $belongsTo = array(
		'Bill' => array(
			'className'		=> 'Bill',
			'foreignKey'	=> 'bill_id',
			),
		'StaffGroupService' => array(
			'className'		=> 'StaffGroupService',
			'foreignKey'	=> 'service_id',
			),
		);
	

}
?>