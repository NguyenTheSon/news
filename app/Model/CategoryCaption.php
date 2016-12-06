<?php
class CategoryCaption extends AppModel
{
	###################################
		var $belongsTo = array(
		'Category' => array(
			'className'		=> 'Category',
			'foreignKey'	=> 'category_id',
			),
		);
	

}
?>