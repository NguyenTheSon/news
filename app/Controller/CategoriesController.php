<?php
class CategoriesController extends AppController {
	public $components = array('RequestHandler');
	public function admin_index() {
		$categories = $this->Category->find('all',array(
			'recursive' => -1,
			'order' => 'sort ASC'));
		$this->set(compact('categories'));
	}
	public function admin_add() {
		if ($this->request->is('post')) {
			$save = $this->request->data;
			$save['Category']['images'] = json_encode($save['Category']['images']);
			$save['Category']['images_mobile'] = json_encode($save['Category']['images_mobile']);
			if($this->Category->save($save)){
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
				$this->Category->id = $id;
				if (!$this->Category->exists()) {
					throw new NotFoundException('Chuyên mục không tồn tại');
				}

				if ($this->request->is(array('post','put'))) {
					$save = $this->request->data;
					$save['Category']['images'] = json_encode($save['Category']['images']);
					$save['Category']['images_mobile'] = json_encode($save['Category']['images_mobile']);
					if($this->Category->save($save)){
						$this->Session->setFlash('Cập nhật thành công', 'flash_success');
						return $this->redirect(array('action' => 'index'));			
					}
					else{

						$this->Session->setFlash('Có lỗi, hãy thử lại!', 'flash_error');
					}
				}
		#########################################
				$Category = $this->Category->read(null, $id);
				$image = json_decode($Category['Category']['images']);
				$Category['Category']['images'] = $image;
				$image = json_decode($Category['Category']['images_mobile']);
				$Category['Category']['images_mobile'] = $image;
				$this->request->data = $Category;
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
			public function index($category_id = 0) {
				$this->layout = "home";
				$this->loadModel("New");
				$this->loadModel("Category");
				if($category_id == 0)
					$conditions = array();
				else
					$conditions = array("category_id"=>$category_id);
				$this->paginate  = array(
					"conditions" => $conditions,
					"order" => array('id desc'),
					"limit" => "9" 
					);
				$News = $this->paginate('News');
				$this->set(compact("News"));

				$currentcate = $this->Category->find('first', array(
					'conditions' => array('Category.id' => $category_id),
					));
				$this->set(compact("currentcate"));
			}

			public function view($category_id = 0){
				$this->layout = "home";
				$this->loadModel("New");
				$this->loadModel("Category");
				$this->loadModel('Award');
				if($category_id == 0)
					$conditions = array();
				else
					$conditions = array("category_id"=>$category_id);
				if($category_id != 4){
					$this->paginate  = array(
						"conditions" => $conditions,
						"order" => array('id desc'),
						"limit" => "10" 
						);
					$News = $this->paginate('News');
					$this->set(compact("News"));
				}
				else{
					unset($conditions['category_id']);
					$this->paginate  = array(
						"conditions" => $conditions,
						"order" => array('id desc'),
						"limit" => "10" 
						);
					$Awards = $this->paginate('Award');
					$this->set(compact('Awards'));
				}

				$currentcate = $this->Category->find('first', array(
					'conditions' => array('Category.id' => $category_id),
					));
				$this->set(compact("currentcate"));
			}
		}
		?>