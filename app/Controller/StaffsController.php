<?php
App::uses('AppController', 'Controller');
class StaffsController  extends AppController {
	public $components = array('RequestHandler','ImageUploader', 'Paginator');

////////////////////////////////////////////////////////////

	public function admin_index() {
		$this->loadModel('StaffGroup');
		$groups = $this->StaffGroup->find('list',
			array(
				'recursive'     => -1,
				'conditions'    => array(

					),
				'fields'        => array('StaffGroup.id', 'StaffGroup.name')
				)
			);
		$this->set(compact('groups'));

		if($this->request->is('POST')) {
			if(isset($this->request->data['Staff']['filter_by_group'])) {
				$this->Session->write('Staff.FilterByGroup', $this->request->data['Staff']['filter_by_group']);
			} else {

			}
			if(isset($this->request->data['Staff']['keyword'])) {
				$this->Session->write('Staff.FilterByKeyword', $this->request->data['Staff']['keyword']);
			} else {

			}
		}

		if(($this->Session->read('Staff.FilterByGroup'))) {
			$group_id = $this->Session->read('Staff.FilterByGroup');
			$conditions['Staff.staff_group_id'] = $group_id;
		} else {
			$conditions['Staff.staff_group_id >='] =  '0';
		}

		if($this->Session->read('Staff.FilterByKeyword')){
			$conditions['OR'] = array(
				'Staff.name LIKE' => '%'. $this->Session->read('Staff.FilterByKeyword') .'%',
				'Staff.content LIKE' => '%'. $this->Session->read('Staff.FilterByKeyword') .'%',
				);
		}

		$this->Paginator->settings = array(
			'recurvive'	=> -1,
			'conditions' => $conditions,
			'limit' => 20,
			'order' => 'Staff.name DESC'
			);
		$staffs = $this->Paginator->paginate('Staff');
		$this->set(compact('staffs'));
	}

////////////////////////////////////////////////////////////

	public function admin_view($id = null) {
		$this->Staff->id = $id;
		if (!$this->Staff->exists()) {
			throw new NotFoundException('Nhân viên không tồn tại!');
		}

		$staff = $this->Staff->read(null, $id);

		$this->loadModel('StaffGroup');
		$groups = $this->StaffGroup->find('first',
			array(
				'recursive'     => -1,
				'conditions'    => array(
					"StaffGroup.id" => $staff['Staff']['staff_group_id'],
					),
				'fields'        => array('StaffGroup.id', 'StaffGroup.name')
				)
			);
		$this->set(compact('groups'));
		$this->set(compact('staff'));

	}

////////////////////////////////////////////////////////////

	public function admin_add() {
		$this->loadModel('StaffGroup');
		$groups = $this->StaffGroup->find('list',
			array(
				'recursive'     => -1,
				'conditions'    => array(

					),
				'fields'        => array('StaffGroup.id', 'StaffGroup.name')
				)
			);
		$this->set(compact('groups'));
		if ($this->request->is('post')) {
			$this->Staff->create();
			$data = $this->request->data;
			$data['Staff']['staff_group_id'] = $data['Staff']['Group'];
			unset($data['Staff']['Group']);
			if ($this->Staff->save($data)) {
				$this->Session->setFlash('Thêm người dùng thành công');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Có lỗi, hãy thử lại');
			}
		}
	}

////////////////////////////////////////////////////////////

	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('Người dùng không tồn tại');
		}
		$this->loadModel('StaffGroup');
		$groups = $this->StaffGroup->find('list',
			array(
				'recursive'     => -1,
				'conditions'    => array(

					),
				'fields'        => array('StaffGroup.id', 'StaffGroup.name')
				)
			);
		$staff = $this->Staff->read(null, $id);
		$this->set(compact('staff'));
		$this->set(compact('groups'));
		if ($this->request->is('post') || $this->request->is('put')) {
			$Staff = $this->Staff->read(null,$id);
			$data = $this->request->data;
			$data['Staff']['staff_group_id'] = $data['Staff']['Group'];
			unset($data['Staff']['Group']);
			if ($this->Staff->save($data,false)) {
				$this->Session->setFlash('Cập nhật thành công', 'flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Có lỗi, Xin hãy thử lại', 'flash_error');
			}
		} else {
			$this->request->data = $this->Staff->find("first", array(
				"conditions" => array("Staff.id" => $id),
				));
		}
	}
////////////////////////////////////////////////////////////

	public function admin_delete($id = null) {
		$this->loadModel('Staff');
		$this->Staff->id = $id;
		if (!$this->Staff->exists()) {
			throw new NotFoundException('Nhân viên không tồn tại');
		}
		if ($this->Staff->delete($id)) {
			$this->Session->setFlash('Xóa nhân viên thành công', 'flash_success');
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Có lỗi, hãy thử lại', 'flash_error');
		return $this->redirect(array('action' => 'index'));
	}
}
