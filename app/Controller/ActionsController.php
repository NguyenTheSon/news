<?php
    class ActionsController extends AppController {

        public $components = array('RequestHandler','ImageUploader', 'Ctrl', 'Paginator');
        public $paginate = array(
            'limit' => 10,
            'order' => array(
                'Action.controller' => 'ASC'
            )
        );

        public function admin_index() {
            $this->Paginator->settings = array(
                'limit' => 15,
                'order' => 'Action.controller ASC'
            );
            $actions = $this->Paginator->paginate('Action');
            $this->set(compact('actions'));
        }
        public function admin_update() {
            $this->autoRender = false;
            $Controllers = $this->Ctrl->get();
            foreach($Controllers as $Controller => $Actions) {
                //echo $Controller . '<br>';
                foreach($Actions as $action) {
                    $search = $this->Action->find('first',
                        array(
                            'conditions' => array(
                                'Action.controller' => $Controller,
                                'Action.action' => $action
                            )
                        )
                    );
                    if(!$search) {
                        $this->Action->Create();
                        $this->Action->save(
                            array(
                                'controller' => $Controller,
                                'action'     => $action
                            )
                        );
                    } else {
                        echo $Controller . '.' . $action . ' Da ton tai <br>';
                    }
                }
            }
            $this->Session->setFlash('Updated Successfully !!!', 'flash_success');
            $this->redirect(array('controller' => 'actions', 'action' => 'index'));
        }
    }
?>