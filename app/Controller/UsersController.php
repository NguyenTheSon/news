<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $components = array('RequestHandler','ImageUploader', 'Paginator');
////////////////////////////////////////////////////////////
	private function get_file_ext($name)
	{
        // Get file extension
		$path_part = explode(".", $name);
		$file_ext = count($path_part) > 1 ? ('.' . end($path_part)) : '';
		return $file_ext;
	}
	public function admin_beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login', 'admin_error');
	}

////////////////////////////////////////////////////////////
	public function admin_error(){

	}

	public function login() {
		if ($this->request->is('post')) {
			if($this->Auth->login()) {
				$logged = $this->Session->read('Auth.User');
				$this->User->id = $this->Auth->user('id');
				if ($this->Auth->user('role') == '3') {
					$this->Session->setFlash('Chào '.$logged['name'].'. Bạn đã đăng nhập thành công','flash_success');
					return $this->redirect(array(
						'controller' => 'homes',
						'action' => 'index',
						));
				} elseif ($this->Auth->user('role') == '2' || ($this->Auth->user('role') == '1')) {
					return $this->redirect(array(
						'controller' => 'Homes',
						'action' => 'dashboard',
						'admin' => true
						));
				}
			} else {
				$this->Session->setFlash('Đăng nhập không thành công! Vui lòng thử lại', 'flash_error');
			}
		}
	}

////////////////////////////////////////////////////////////

	public function logout() {
		$_SESSION['KCEDITOR']['disabled'] = true;
		unset($_SESSION['KCEDITOR']);
		return $this->redirect($this->Auth->logout());
	}

////////////////////////////////////////////////////////////

	public function dashboard() {
		$this->layout = "userinfo";

		if ($this->request->is('post') || $this->request->is('put')) {

			$logged = $this->Auth->user();
			$this->User->Create();
			$this->User->id = $logged['id'];

			$data = $this->request->data;
			$save = array(
				"name" => $data['User']['name'],
				"birthday" => $data['User']['birthday'],
				);
			
			if($data['User']['password'] != $data['User']['repassword']){
				$this->Session->setFlash('Password bạn nhập 2 lần không giống nhau.','flash_error');
				$this->redirect(array('action' => 'dashboard'));
			}
			elseif($data['User']['password'] !=""){
				$save['password'] = $data['User']['password'];
			}
			if ($this->User->save($save)) {
				$this->Session->setFlash('Thay đổi thông tin cá nhân thành công','flash_success');
				$this->redirect(array('action' => 'dashboard'));
			} else {
				$this->Session->setFlash('Có lỗi, hãy thử lại','flash_error');
			}
		}
		$logged = $this->Auth->user();
		$this->request->data = $this->User->read(null,$logged['id']);

	}

////////////////////////////////////////////////////////////

	public function admin_changepassword() {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('Đổi mật khẩu thành công', 'flash_success');
				$this->redirect(array('controller' => 'Homes', 'action' => 'home', 'admin' => true));
			} else {
				$this->Session->setFlash('Đổi mật khẩu không thành công!','flash_error');
			}
		} else {
			$this->request->data = array('User' => $this->Auth->user());
		}
	}

////////////////////////////////////////////////////////////

	public function admin_dashboard() {
	}

////////////////////////////////////////////////////////////

	public function admin_index() {
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
			if(isset($this->request->data['User']['filter_by_group'])) {
				$this->Session->write('User.FilterByGroup', $this->request->data['User']['filter_by_group']);
			} else {

			}
			if(isset($this->request->data['User']['keyword'])) {
				$this->Session->write('User.FilterByKeyword', $this->request->data['User']['keyword']);
			} else {

			}
		}

		if(($this->Session->read('User.FilterByGroup'))) {
			$group_id = $this->Session->read('User.FilterByGroup');
			$conditions['User.role'] = $group_id;
		} else {
			$conditions['User.role >='] =  '0';
		}

		if($this->Session->read('User.FilterByKeyword')){
			$conditions['OR'] = array(
				'User.email LIKE' => '%'. $this->Session->read('User.FilterByKeyword') .'%',
				'User.name LIKE' => '%'. $this->Session->read('User.FilterByKeyword') .'%',
				'User.address LIKE' => '%'. $this->Session->read('User.FilterByKeyword') .'%',
				'User.phonenumber LIKE' => '%'. $this->Session->read('User.FilterByKeyword') .'%',
				);
		}

		$this->Paginator->settings = array(
			'recurvive'	=> -1,
			'conditions' => $conditions,
			'limit' => 20,
			'order' => 'User.name DESC'
			);
		$users = $this->Paginator->paginate('User');
		$this->set(compact('users'));
	}

////////////////////////////////////////////////////////////

	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('Người dùng không tồn tại!');
		}
		$user = $this->User->read(null, $id);
		$this->set(compact('user'));

	}

////////////////////////////////////////////////////////////

	public function admin_add() {
		
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				if($this->request->data['User']['balance'] != 0){
					$text="So du tai khoan: %s. Nap tien tai ThanhHuyen ngay".date("d/m/Y");
					$text = sprintf($text,number_format($this->request->data['User']['balance']));
					$this->send_sms($this->request->data['User']['phonenumber'],$text);
				}

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
		if ($this->request->is('post') || $this->request->is('put')) {
				if($this->request->data['User']['password']==''){
					unset($this->request->data['User']['password']);
				}
				$User = $this->User->read(null,$id);

				if ($this->User->save($this->request->data,false)) {
					if(isset($this->request->data['User']['balance'])){
						if($this->request->data['User']['balance'] != $User['User']['balance']){
							$text="So tien GD: %s. So du: %s. %s";
							$needBalance = $this->request->data['User']['balance'] - $User['User']['balance'];
							if($needBalance > 0){
								$reason = "Nap tien tai he thong ThanhHuyen Salon ngay ".date("d/m/Y");
							}
							else{
								$reason = "Chinh sua thong tin ngay ".date("d/m/Y");
							}
							$text = sprintf($text,number_format($needBalance),number_format($this->request->data['User']['balance']),$reason);
							$this->send_sms($User['User']['phonenumber'],$text);
						}
					}
					$this->Session->setFlash('Cập nhật thành công', 'flash_success');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Có lỗi, Xin hãy thử lại', 'flash_error');
				}
			} else {
				$this->request->data = $this->User->find("first", array(
					"conditions" => array("User.id" => $id),
					));
			}
		}

////////////////////////////////////////////////////////////

		public function admin_password($id = null) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException('パスワードの保存に失敗しました。');
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash('パスワードは保存されました。');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('パスワードの保存に失敗しました。');
				}
			} else {
				$this->request->data = $this->User->read(null, $id);
			}
		}

		public function admin_sms($id){
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException('User id không tồn tại');
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				$data = $this->request->data;
				$this->send_sms($data['User']['phonenumber'],$data['User']['content']);
				$this->Session->setFlash('Đã gửi tin nhắn thành công', 'flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->request->data = $this->User->read(null, $id);
			}
		}
////////////////////////////////////////////////////////////

		public function admin_delete($id = null) {

			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException('Người dùng không tồn tại');
			}
			if ($this->User->delete()) {
				$this->Session->setFlash('Xóa người dùng thành công', 'flash_success');
				return $this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash('Có lỗi, hãy thử lại', 'flash_error');
			return $this->redirect(array('action' => 'index'));
		}

////////////////////////////////////////////////////////////

		public function home($user_url){
			$this->layout = "products";
			$User = $this->User->find("first", array(
				"conditions" => array(
					"url" => $user_url)));
			if($this->request->is('ajax')){
				
				$page = $this->request->data['page'];
				$index = ($page - 1) * 10;
				$this->loadModel("Product");
				$products = $this->Product->find('all', array(
					'conditions' => array(
						'Product.seller_id' => $User['User']['id'],
						'is_deleted' => 0
						),
					'recursive' => 1,
					'order' => "Product.created DESC",
					'limit' => 10,
					'offset' => $index,
					));
				$this->set('products', $products);
				$this->layout = false;
				$this->render('/Elements/Categories/list-products-index');
				return;
			}
		###########################################

			if(!$User){
				$this->Session->setFlash('Trang không tồn tại','flash_error');
				$this->redirect(array("controller" => "homes", "action" => "index"));
			}
			$this->loadModel("Product");
			$products = $this->Product->find('all', array(
				'conditions' => array(
					'Product.seller_id' => $User['User']['id'],
					'is_deleted' => 0
					),
				'recursive' => 1,
				'order' => "Product.created DESC",
				'limit' => 10,
				'offset' => 0,
				));
			$this->set(compact("User"));
			$this->set(compact("products"));
		}

////////////////////////////////////////////////////////////

		function opauth_complete()
		{
			pr($this->request->data);
			$this->autoRender = false;
		}
	}
