<?php
class ProdCategory extends AppModel
{
	###################################
	var $hasMany = array(
		'Product' => array(
			'className'		=> 'Product',
			'foreignKey'	=> 'cat_id',
			'dependent'		=> true
		),
		
	);
}
?>