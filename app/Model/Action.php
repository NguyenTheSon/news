<?php
	class Action extends AppModel {
		var $hasMany = array(
			'Permission' => array(
				'className'     => 'Permission',
				'foreignKey'    => 'action_id'
			)
		);
	}
?>