<?php
class Product extends AppModel
{
	###################################
		var $belongsTo = array(
		'ProdCategory' => array(
			'className'		=> 'ProdCategory',
			'foreignKey'	=> 'cat_id',
			),
		);
	

}
?>