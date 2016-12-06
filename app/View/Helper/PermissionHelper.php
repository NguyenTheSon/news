<?php
App::import("Model", "User");
App::import("Model", "Permission");
App::import("Model", "Action");
class PermissionHelper extends AppHelper {

        public function checkGroupPermission($group_id, $action_id) {
            $this->Permission = new Permission();
            $GroupPermissions = $this->Permission->find('first',
                array(
                    'conditions' => array(
                        'Permission.group_id' => $group_id,
                        'Permission.action_id' => $action_id
                    )
                )
            );
            if($GroupPermissions) {
                if($GroupPermissions['Permission']['state'] == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function checkUserPermission($user_id, $action_id) {
            $this->Permission = new Permission();
            $this->User = new User();
            $user = $this->User->find('first',
                array(
                    'conditions' => array(
                        'User.id' => $user_id
                    ),
                    'recursive' => -1
                )
            );
            $GroupPermissions = $this->Permission->find('first',
                array(
                    'conditions' => array(
                        'Permission.group_id' => $user['User']['role'],
                        'Permission.action_id' => $action_id
                    )
                )
            );
            $UserPermissions = $this->Permission->find('first',
                array(
                    'conditions' => array(
                        'Permission.user_id' => $user_id,
                        'Permission.action_id' => $action_id
                    )
                )
            );
            if($UserPermissions) {
                if($UserPermissions['Permission']['state'] == 1) {
                    return true;
                } elseif($UserPermissions['Permission']['state'] == -1) {
                    return false;
                } else {
                    if($GroupPermissions) {
                        if($GroupPermissions['Permission']['state'] == 1) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                if($GroupPermissions) {
                    if($GroupPermissions['Permission']['state'] == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        public function checkView($user_id, $controller, $action) {
            $this->Action = new Action();
            $actions = $this->Action->find('first',
                array(
                    'conditions' => array(
                        'Action.controller' => $controller,
                        'Action.action' => $action
                    )
                )
            ); 
            if($actions) {
                return $this->checkUserPermission($user_id, $actions['Action']['id']);
            } else {
                return false;
            }
        }
    }
?>