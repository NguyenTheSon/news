<?php
    class Permission extends AppModel {

        var $belongsTo = array(
            'User' => array(
                'className'     => 'User',
                'foreignKey'    => 'user_id'
            ),
            'UserGroup' => array(
                'className'     => 'UserGroup',
                'foreignKey'    => 'group_id'
            ),
            'Action' => array(
                'className'     => 'Action',
                'foreignKey'    => 'action_id'
            )
        );
    }
?>