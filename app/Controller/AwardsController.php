<?php
class AwardsController extends AppController {
	public $components = array('RequestHandler','ImageUploader', 'Ctrl', 'Paginator');
	public function admin_index() {
		$this->loadModel('Award');
		$listaward = $this->Award->find('all');
		$this->set(compact('listaward'));
	}

	public function admin_add(){
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$datas['Award']['name'] = $data['name'];
			$datas['Award']['ide_number'] = $data['ide_number'];
			$datas['Award']['address'] = $data['address'];
			$datas['Award']['phonenumber'] = $data['phonenumber'];
			$datas['Award']['note'] = $data['note'];
			$datas['Award']['imgavatar'] = $data['Award']['ImgAvatar'];
			$datas['Award']['images'] = json_encode($data['images'], true);
			$datas['Award']['vote'] = 0;
			$this->Award->create();
			if ($this->Award->save($datas['Award'],false)) {
				$this->Session->setFlash('Đã lưu thành công','flash_success');
				return $this->redirect(array(
					'controller' => 'Awards',
					'action' => 'admin_index',
					));
			}
			$this->Session->setFlash('Lỗi rồi. Vui lòng thử lại sau.','flash_error');
		}
	}

	public function admin_edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Quảng cáo không tồn tại!'));
		}
		$editAward = $this->Award->findById($id);
		$editAward['Award']['images'] = json_decode($editAward['Award']['images'], true);
		// pr($editAward);
		// die;
		$this->set("Award", $editAward);
		if (!$editAward) {
			throw new NotFoundException(__('Bài thi không tồn tại!'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->Award->id = $id;
			$data = $this->request->data;
			$datas['Award']['name'] = $data['name'];
			$datas['Award']['ide_number'] = $data['ide_number'];
			$datas['Award']['address'] = $data['address'];
			$datas['Award']['phonenumber'] = $data['phonenumber'];
			$datas['Award']['note'] = $data['note'];
			$datas['Award']['imgavatar'] = $data['Award']['ImgAvatar'];
			$datas['Award']['images'] = json_encode($data['images'], true);
			$datas['Award']['vote'] = 0;

			if ($this->Award->save($datas['Award'])) {
				$this->Session->setFlash('Sửa bài thi thành công.', 'flash_success');
				return $this->redirect(array('controller' => 'Awards','action' => 'admin_index'));
			}
			$this->Session->setFlash('Lỗi rồi. Vui lòng thử lại sau.','flash_error');
		}
	}

	public function admin_delete($id = null){
		if (!$id) {
			throw new NotFoundException(__('Bài thi không tồn tại!'));
		}
		if ($this->Award->delete($id)) {
			$this->Session->setFlash('Xóa Bài thi thành công!', 'flash_success');
		} else {
			$this->Session->setFlash('Xóa Bài thi không thành công!', 'flash_error');
		}
		return $this->redirect(array('action' => 'admin_index'));
	}

	public function detail($id = null){
		$this->layout = "home";
		$detail = $this->Award->find('first',array(
			'conditions' => array('id' => $id),
			));
		$detail['Award']['images'] = json_decode($detail['Award']['images']);
		$this->set(compact('detail'));
	}
}
?>
