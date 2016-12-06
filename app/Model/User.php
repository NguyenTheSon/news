<?php
class User extends AppModel
{
	var $useTable = "users";
	##################################
	public $validate = array(
		'phonenumber' => array(
			'rule2' => array(
				'rule' => array('isUnique'),
				'message' => 'phonenumber is not uniqie',
				),	
		),
		'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ));
	public function beforeSave($options = array()) {
		if(isset($this->data[$this->name]['password'])) {
			$this->data[$this->name]['password'] = AuthComponent::password($this->data[$this->name]['password']);
		}
		return true;
	}
	###################################
	var $hasMany = array(
		'Bill' => array(
			'className'		=> 'Bill',
			'foreignKey'	=> 'user_id',
			'dependent'		=> true
		),
		'Question' => array(
			'className'		=> 'Question',
			'foreignKey'	=> 'user_id',
			'dependent'		=> true
		),
		'Feedback' => array(
			'className'		=> 'Feedback',
			'foreignKey'	=> 'user_id',
			'dependent'		=> true
		),
		'News' => array(
			'className'		=> 'News',
			'foreignKey'	=> 'user_id',
			'dependent'		=> true
		),
		
		);
	

}
?>