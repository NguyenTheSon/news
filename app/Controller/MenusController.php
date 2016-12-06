<?php
class MenusController extends AppController {
	public $components = array('RequestHandler');
	public function admin_index() {
			$menus = $this->Menu->find('all',array(
				'recursive' => -1,
				'order' => 'sort ASC'));
			$this->set(compact('menus'));
	}
	public function admin_add() {
		if ($this->request->is('post')) {
			print_r($this->request->data);
			if($this->Category->save($this->request->data)){
				
				$catid = $this->Category->id;
				$this->loadModel('ProductSizeCategory');
				if(isset($this->request->data['ProductSizeCategory']))
				foreach ($this->request->data['ProductSizeCategory']['product_size_id'] as $key => $value) {
					$data['ProductSizeCategory']= array("product_size_id" => $value,
								"category_id" => $catid,
								"sort" => $key);
					$this->ProductSizeCategory->Create();
					$this->ProductSizeCategory->save($data);
				}
				$this->loadModel('BrandCategory');
				if(isset($this->request->data['BrandCategory']))
				foreach ($this->request->data['BrandCategory']['id'] as $key => $value) {
					$data['BrandCategory']= array("brand_id" => $value,
								"category_id" => $catid,
								);
					$this->BrandCategory->Create();
					$this->BrandCategory->save($data);
				}
				$this->Session->setFlash('Thêm chuyên mục thành công!', 'flash_success');
				$this->redirect(array('action' => 'index'));
			}
			else{
				$this->Session->setFlash('Có lỗi, hãy thử lại!', 'flash_error');
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	public function admin_edit($id=null) {
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException('Chuyên mục không tồn tại');
		}
		if ($this->request->is(array('post','put'))) {
			$save = $this->request->data;
			if($this->Menu->save($save)){
				$this->Session->setFlash('Cập nhật thành công', 'flash_success');
				return $this->redirect(array('action' => 'index'));			
			}
			else{
				
				$this->Session->setFlash('Có lỗi, hãy thử lại!', 'flash_error');
			}
		}
		#########################################
			$Menu = $this->Menu->read(null, $id);
			$this->request->data = $Menu;
	}
	public function admin_delete($id=null){
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException('Chuyên mục không tồn tại');
		}
		if ($this->Category->delete()) {
			$this->Session->setFlash('Xóa chuyên mục thành công', 'flash_success');
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Có lỗi, hãy thử lại', 'flash_');
		return $this->redirect(array('action' => 'index'));
	}
	
	
}
?>