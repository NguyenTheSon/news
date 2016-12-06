<?php
    class PermissionsController extends AppController {

        public $components = array('RequestHandler','ImageUploader','Ctrl', 'Paginator');
        public $helpers = array('Permission');
        public $paginate = array(
            'limit' => 10,
            'order' => array(
                'Permission.id' => 'ASC'
            )
        );

        public function admin_index() {
            $this->loadModel('UserGroup');
            $this->Paginator->settings = array(
                'limit' => 15,
                'order' => 'UserGroup.name ASC'
            );
            $groups = $this->Paginator->paginate('UserGroup');
            $this->set(compact('groups'));
        }

        public function admin_group($id) {
            $controllers = $this->Ctrl->get();

            $this->loadModel('UserGroup');
            $group = $this->UserGroup->find('first',
                array(
                    'conditions' => array(
                        'UserGroup.id' => $id
                    )
                )
            );
            $this->set(compact('group'));

            $this->loadModel('Action');
            $permissions = $this->Permission->find('all',
                array(
                    'conditions' => array(
                        'Permission.group_id' => $id
                    )
                )
            );
            $this->set(compact('permissions'));

            foreach($controllers as $controller => $acttions) {
                foreach($acttions as $key => $action) {
                    $tmp = $this->Action->find('all',
                        array(
                            'conditions' => array(
                                'Action.controller' => $controller,
                                'Action.action' => $action
                            )
                        )
                    );
                    if($tmp != null) {
                        $controllers[$controller][$key] = $tmp[0]['Action'];
                    }
                }
            }
            $this->set('gid', $id);
            $this->set(compact('controllers'));
        }

        public function admin_deny() {
            if($this->request->is('POST')) {
                if(isset($this->request->data['gid']) && isset($this->request->data['aid'])) {
                    $check = $this->Permission->find('first',
                        array(
                            'conditions' => array(
                                'Permission.group_id' => $this->request->data['gid'],
                                'Permission.action_id' => $this->request->data['aid']
                            )
                        )
                    );
                    if($check) {
                        $this->Permission->save(
                            array(
                                'id' => $check['Permission']['id'],
                                'group_id' => $this->request->data['gid'],
                                'action_id' => $this->request->data['aid'],
                                'state' => -1
                            )
                        );
                    } else {
                        $this->Permission->Create();
                        $this->Permission->save(
                            array(
                                'group_id' => $this->request->data['gid'],
                                'action_id' => $this->request->data['aid'],
                                'state' => -1
                            )
                        );
                    }
                } elseif(isset($this->request->data['uid']) && isset($this->request->data['aid'])) {
                    $this->loadModel('Action');
                    $actions = $this->Action->find('all',
                        array(
                            'recursive' => -1
                        )
                    );
                    foreach($actions as $action) {
                        $check = $this->Permission->find('first',
                            array(
                                'conditions' => array(
                                    'Permission.user_id' => $this->request->data['uid'],
                                    'Permission.action_id' => $this->request->data['aid']
                                )
                            )
                        );
                        if($check) {
                            $this->Permission->save(
                                array(
                                    'id' => $check['Permission']['id'],
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $this->request->data['aid'],
                                    'state' => -1
                                )
                            );
                        } else {
                            $this->Permission->Create();
                            $this->Permission->save(
                                array(
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $this->request->data['aid'],
                                    'state' => -1
                                )
                            );
                        }
                    }
                } else {
                    $this->Session->setFlash('Parameter value is invalid !!!', 'flash_error');
                    $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                    return;
                }
            } else {
                $this->Session->setFlash('Wrong Method !!!', 'flash_error');
                $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                return;
            }
            $this->autoRender = false;
            return;
        }

        public function admin_allow() {
            if($this->request->is('POST')) {
                if(isset($this->request->data['gid']) && isset($this->request->data['aid'])) {
                    $check = $this->Permission->find('first',
                        array(
                            'conditions' => array(
                                'Permission.group_id' => $this->request->data['gid'],
                                'Permission.action_id' => $this->request->data['aid']
                            )
                        )
                    );
                    if($check) {
                        $this->Permission->save(
                            array(
                                'id' => $check['Permission']['id'],
                                'group_id' => $this->request->data['gid'],
                                'action_id' => $this->request->data['aid'],
                                'state' => 1
                            )
                        );
                    } else {
                        $this->Permission->Create();
                        $this->Permission->save(
                            array(
                                'group_id' => $this->request->data['gid'],
                                'action_id' => $this->request->data['aid'],
                                'state' => 1
                            )
                        );
                    }
                } elseif(isset($this->request->data['uid']) && isset($this->request->data['aid'])) {
                    $this->loadModel('Action');
                    $actions = $this->Action->find('all',
                        array(
                            'recursive' => -1
                        )
                    );
                    foreach($actions as $action) {
                        $check = $this->Permission->find('first',
                            array(
                                'conditions' => array(
                                    'Permission.user_id' => $this->request->data['uid'],
                                    'Permission.action_id' => $this->request->data['aid']
                                )
                            )
                        );
                        if($check) {
                            $this->Permission->save(
                                array(
                                    'id' => $check['Permission']['id'],
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $this->request->data['aid'],
                                    'state' => 1
                                )
                            );
                        } else {
                            $this->Permission->Create();
                            $this->Permission->save(
                                array(
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $this->request->data['aid'],
                                    'state' => 1
                                )
                            );
                        }
                    }
                } else {
                    $this->Session->setFlash('Parameter value is invalid !!!', 'flash_error');
                    $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                    return;
                }
            } else {
                $this->Session->setFlash('Wrong Method !!!', 'flash_error');
                $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                return;
            }
            $this->autoRender = false;
            return;
        }

        public function admin_user_lists() {
            $this->loadModel('UserGroup');
            $groups = $this->UserGroup->find('list',
                array(
                    'recursive'     => -1,
                    'conditions'    => array(

                    ),
                    'fields'        => array('UserGroup.id', 'UserGroup.name')
                )
            );
            $this->set(compact('groups'));

            if($this->request->is('POST')) {
                if(isset($this->request->data['Permission']['filter_by_group'])) {
                    $this->Session->write('Permission.FilterByGroup', $this->request->data['Permission']['filter_by_group']);
                } else {

                }

                if(isset($this->request->data['Permission']['keyword'])) {
                    $this->Session->write('Permission.keyword', $this->request->data['Permission']['keyword']);
                } else {

                }
            }

            $conditions = array();
            if($this->Session->read('Permission.keyword')){
                $conditions['OR'] = array(
                    'User.email LIKE' => '%'. $this->Session->read('Permission.keyword') .'%',
                    'User.name LIKE' => '%'. $this->Session->read('Permission.keyword') .'%',
                    'User.address LIKE' => '%'. $this->Session->read('Permission.keyword') .'%',
                    'User.phonenumber LIKE' => '%'. $this->Session->read('Permission.keyword') .'%'
                );
            }

            if($this->Session->read('Permission.FilterByGroup')){
                $conditions['User.role = '] = $this->Session->read('Permission.FilterByGroup');
            }

            $this->loadModel('User');
            $this->Paginator->settings = array(
                'limit' => 15,
                'conditions' => $conditions,
                'order' => 'User.name ASC'
            );
            $users = $this->Paginator->paginate('User');
            $this->set(compact('users'));
        }

        public function admin_user_details($id) {
            $this->loadModel('User');
            $user = $this->User->find('first',
                array(
                    'conditions' => array(
                        'User.id' => $id
                    )
                )
            );
            if(!$user) {
                $this->Session->setFlash('Parameter value is invalid !!!', 'flash_error');
                $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                return;
            }
            $permissions = $this->Permission->find('all',
                array(
                    'conditions' => array(
                        'OR' => array(
                            'Permission.group_id' => $user['User']['role'],
                            'Permission.user_id' => $user['User']['id'],
                        )
                    )
                )
            );
            $this->set(compact('permissions'));

            $controllers = $this->Ctrl->get();
            $this->loadModel('Action');
            foreach($controllers as $controller => $acttions) {
                foreach($acttions as $key => $action) {
                    $tmp = $this->Action->find('all',
                        array(
                            'conditions' => array(
                                'Action.controller' => $controller,
                                'Action.action' => $action
                            )
                        )
                    );
                    if($tmp != null) {
                        $controllers[$controller][$key] = $tmp[0]['Action'];
                    }
                }
            }
            $this->set('uid', $id);
            $this->set(compact('controllers'));
        }

        public function admin_allow_all() {
            if($this->request->is('POST')) {
                if(isset($this->request->data['gid'])) {
                    $this->loadModel('Action');
                    $actions = $this->Action->find('all',
                        array(
                            'recursive' => -1
                        )
                    );
                    foreach($actions as $action) {
                        $check = $this->Permission->find('first',
                            array(
                                'conditions' => array(
                                    'Permission.group_id' => $this->request->data['gid'],
                                    'Permission.action_id' => $action['Action']['id']
                                )
                            )
                        );
                        if($check) {
                            $this->Permission->save(
                                array(
                                    'id' => $check['Permission']['id'],
                                    'group_id' => $this->request->data['gid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => 1
                                )
                            );
                        } else {
                            $this->Permission->Create();
                            $this->Permission->save(
                                array(
                                    'group_id' => $this->request->data['gid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => 1
                                )
                            );
                        }
                    }
                } elseif(isset($this->request->data['uid'])) {
                    $this->loadModel('Action');
                    $actions = $this->Action->find('all',
                        array(
                            'recursive' => -1
                        )
                    );
                    foreach($actions as $action) {
                        $check = $this->Permission->find('first',
                            array(
                                'conditions' => array(
                                    'Permission.user_id' => $this->request->data['uid'],
                                    'Permission.action_id' => $action['Action']['id']
                                )
                            )
                        );
                        if($check) {
                            $this->Permission->save(
                                array(
                                    'id' => $check['Permission']['id'],
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => 1
                                )
                            );
                        } else {
                            $this->Permission->Create();
                            $this->Permission->save(
                                array(
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => 1
                                )
                            );
                        }
                    }
                } else {
                    $this->Session->setFlash('Parameter value is invalid !!!', 'flash_error');
                    $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                    return;
                }
            } else {
                $this->Session->setFlash('Wrong Method !!!', 'flash_error');
                $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                return;
            }
            $this->autoRender = false;
            return;
        }

        public function admin_deny_all() {
            $this->autoRender = false;
            if($this->request->is('POST')) {
                if(isset($this->request->data['gid'])) {
                    $this->loadModel('Action');
                    $actions = $this->Action->find('all',
                        array(
                            'recursive' => -1
                        )
                    );
                    foreach($actions as $action) {
                        $check = $this->Permission->find('first',
                            array(
                                'conditions' => array(
                                    'Permission.group_id' => $this->request->data['gid'],
                                    'Permission.action_id' => $action['Action']['id']
                                )
                            )
                        );
                        if($check) {
                            $this->Permission->save(
                                array(
                                    'id' => $check['Permission']['id'],
                                    'group_id' => $this->request->data['gid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => -1
                                )
                            );
                        } else {
                            $this->Permission->Create();
                            $this->Permission->save(
                                array(
                                    'group_id' => $this->request->data['gid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => -1
                                )
                            );
                        }
                    }
                } elseif(isset($this->request->data['uid'])) {
                    $this->loadModel('Action');
                    $actions = $this->Action->find('all',
                        array(
                            'recursive' => -1
                        )
                    );
                    foreach($actions as $action) {
                        $check = $this->Permission->find('first',
                            array(
                                'conditions' => array(
                                    'Permission.user_id' => $this->request->data['uid'],
                                    'Permission.action_id' => $action['Action']['id']
                                )
                            )
                        );
                        if($check) {
                            $this->Permission->save(
                                array(
                                    'id' => $check['Permission']['id'],
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => -1
                                )
                            );
                        } else {
                            $this->Permission->Create();
                            $this->Permission->save(
                                array(
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => -1
                                )
                            );
                        }
                    }
                } else {
                    $this->Session->setFlash('Parameter value is invalid !!!', 'flash_error');
                    $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                    return;
                }
            } else {
                $this->Session->setFlash('Wrong Method !!!', 'flash_error');
                $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                return;
            }
            $this->autoRender = false;
            return;
        }

        public function admin_user_refresh() {
            if($this->request->is('POST')) {
                if(isset($this->request->data['uid'])) {
                    $this->loadModel('Action');
                    $actions = $this->Action->find('all',
                        array(
                            'recursive' => -1
                        )
                    );
                    foreach($actions as $action) {
                        $check = $this->Permission->find('first',
                            array(
                                'conditions' => array(
                                    'Permission.user_id' => $this->request->data['uid'],
                                    'Permission.action_id' => $action['Action']['id']
                                )
                            )
                        );
                        if($check) {
                            $this->Permission->save(
                                array(
                                    'id' => $check['Permission']['id'],
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => 0
                                )
                            );
                        } else {
                            $this->Permission->Create();
                            $this->Permission->save(
                                array(
                                    'user_id' => $this->request->data['uid'],
                                    'action_id' => $action['Action']['id'],
                                    'state' => 0
                                )
                            );
                        }
                    }
                    $this->admin_user_details($this->request->data['uid']);
                } else {
                    $this->Session->setFlash('Parameter value is invalid !!!', 'flash_error');
                    $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                    return;
                }
            } else {
                $this->Session->setFlash('Wrong Method !!!', 'flash_error');
                $this->redirect(array('controller' => 'permissions', 'action' => 'user_lists'));
                return;
            }
            //$this->autoRender = false;
            $this->render('/Elements/permission_user_details');
        }
    }
?>