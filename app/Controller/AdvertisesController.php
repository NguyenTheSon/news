<?php
class AdvertisesController extends AppController {
	public $components = array('RequestHandler','ImageUploader', 'Ctrl', 'Paginator');
	public function admin_index() {
		$this->loadModel('Advertise');
		$this->loadModel('Location');
		$list_advert = $this->Advertise->find('all', array('contain' => 'Location'));
		$this->set("Advertise" , $list_advert);

		$locations = $this->Location->find('all',array(
			'order' => array('Location.id ASC'),
			));
		$this->set("Locations" , $locations);		
	}

	public function admin_add(){
		if ($this->request->is('post')) {
			$Advertise = $this->request->data;
			if($Advertise['name'] == ""){
				$this->Session->setFlash('Tên quảng cáo không được để trống!','flash_error');
				return $this->redirect(array(
					'controller' => 'Advertises',
					'action' => 'admin_index',
					));
			}
			if($Advertise['height'] == ""){
				$this->Session->setFlash('Chiều cao không được để trống!','flash_error');
				return $this->redirect(array(
					'controller' => 'Advertises',
					'action' => 'admin_index',
					));
			}
			if($Advertise['order'] == ""){
				$this->Session->setFlash('Thứ tự không được để trống!','flash_error');
				return $this->redirect(array(
					'controller' => 'Advertises',
					'action' => 'admin_index',
					));
			}
			$this->Advertise->create();
			if($this->Advertise->save($Advertise,false)){
				$this->Session->setFlash('Đã lưu thành công','flash_success');
				return $this->redirect(array(
					'controller' => 'Advertises',
					'action' => 'admin_index',
					));
			}
			$this->Session->setFlash('Lỗi rồi. Vui lòng thử lại sau.','flash_error');
		}
	}
	public function admin_edit($id = null){
		$this->loadModel('Advertise');
		$this->loadModel('Location');
		$locations = $this->Location->find('all',array(
			'order' => array('Location.id ASC'),
			));
		$this->set("Locations" , $locations);
		if (!$id) {
			throw new NotFoundException(__('Quảng cáo không tồn tại!'));
		}
		$editAdvertise = $this->Advertise->findById($id);
		$editAdvertise['Advertise']['image'] = json_decode($editAdvertise['Advertise']['image'], true);
		$editAdvertise['Advertise']['url'] = json_decode($editAdvertise['Advertise']['url'], true);
		$this->set("Advertise", $editAdvertise);
		if (!$editAdvertise) {
			throw new NotFoundException(__('Quảng cáo không tồn tại!'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->Advertise->id = $id;
			foreach ($this->request->data['image'] as $key => $img) {
				if($img == ""){
					unset($this->request->data['image'][$key]);
					unset($this->request->data['url'][$key]);
				}
			}
			$this->request->data['image'] = json_encode($this->request->data['image']);
			$this->request->data['url'] = json_encode($this->request->data['url']);
			if ($this->Advertise->save($this->request->data)) {
				$this->Session->setFlash('Sửa quảng cáo thành công.', 'flash_success');
				return $this->redirect(array('controller' => 'Advertises','action' => 'admin_index'));
			}
			$this->Session->setFlash('Lỗi rồi. Vui lòng thử lại sau.','flash_error');
		}
	}

	public function admin_delete($id = null){
		if (!$id) {
			throw new NotFoundException(__('Quảng cáo không tồn tại!'));
		}
		if ($this->Advertise->delete($id)) {
			$this->Session->setFlash('Xóa quảng cáo thành công!', 'flash_success');
		} else {
			$this->Session->setFlash('Xóa quảng cáo không thành công!', 'flash_error');
		}
		return $this->redirect(array('action' => 'admin_index'));
	}

	public function admin_approved()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{

			$Advertise = $this->Advertise->read(null,$id);
			$app_val = $Advertise['Advertise']['approved'];
			$new_val = 0;
			if($app_val == 0)
				$new_val = 1;
			$this->Advertise->create();
			$this->Advertise->id = $id;
			$this->Advertise->save(array("approved"=> $new_val));
			$this->Session->setFlash(($new_val==0?"Đã ẩn quảng cáo":"Đã hiện quảng cáo").' thành công','flash_success');
			return $this->redirect(array(
				'controller' => 'Advertises',
				'action' => 'admin_index',
				));
		}
	}
}
