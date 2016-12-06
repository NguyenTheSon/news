<?php
App::uses('AppController', 'Controller');
class ProductsController   extends AppController {
	public $components = array('RequestHandler',);
	public function beforeFilter()
	{
		parent::beforeFilter();
	}
	
	public function index()
	{
		if($this->RequestHandler->isAjax()){
			$catid = $this->request->data['catid'];
			$conditions = array();
			if($catid != 0){
				$conditions = array("cat_id" => $catid);
			}
			$Products = $this->Product->find("all", array(
				"order" => array("created desc"),
				"conditions" => $conditions,
			));
			$this->set(compact('Products'));
			$this->render("/Elements/Products/index");
			return;
		}
		$this->layout = "products";
			$this->loadModel('ProdCategory');
			
			$ProdCategories = $this->ProdCategory->find("all",		
			array(
				'order' => 'order DESC',
				)
			);
			$this->set(compact('ProdCategories'));

			$Products = $this->Product->find("all", array(
				"order" => array("created desc"),
			));
			$this->set(compact('Products'));
	}
	
	public function detail()
	{
		$this->layout = "news";
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$detail = $this->Product->read(null,$id);
			$this->set(compact('detail'));
		}
	}

	public function admin_group_index()
	{
		$this->loadModel("ProdCategory");
		$ProdCategories = $this->ProdCategory->find("all", 
			array
			(
				'order' => "order ASC", 
			)
		);
		$this->set(compact("ProdCategories"));
	}
	public function admin_group_del()
	{
		$this->loadModel("ProdCategory");
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->ProdCategory->create();
			$this->ProdCategory->id = $id;
			if ($this->ProdCategory->exists()) 
			{
				$this->ProdCategory->delete();
				$this->Session->setFlash('Đã xoá thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Products',
							'action' => 'admin_group_index',
				));
			}
			else
			{
				$this->Session->setFlash('Sản phẩm không tồn tại','flash_error');
						return $this->redirect(array(
							'controller' => 'Products',
							'action' => 'admin_group_index',
				));
			}
		}
	}
	public function admin_group_edit()
	{

		$this->loadModel('ProdCategory');
		if(isset($this->params->pass[0]))
		{
			$id = intval($this->params->pass[0]);
			if($id>0)
			{
				if($this->RequestHandler->isPost())
				{
					if($this->request->data['ProdCategory']['code']=="")
					{
						$this->Session->setFlash('Mã nhóm không được để trống!','flash_error');
					}
					else
					{
						$this->ProdCategory->create();
						$this->ProdCategory->id = $id;
						if ($this->ProdCategory->exists()) 
						{
							$checkcode = $this->ProdCategory->find("first",
								array(
									'conditions' => array(
										'id !=' => $id, 
										'code' => $this->request->data['ProdCategory']['code'],
									)
								)
							);
							if(count($checkcode)>0)
							{
								$this->Session->setFlash('Mã nhóm đã tồn tại!','flash_error');
							}
							else
							{
								$this->ProdCategory->save($this->request->data['ProdCategory'],false);
								$this->Session->setFlash('Đã lưu thành công','flash_success');
										return $this->redirect(array(
											'controller' => 'Products',
											'action' => 'admin_group_index',
								));	
								exit;
							}
						}
					}
				}
				$this->ProdCategory->create();
				$this->ProdCategory->id = $id;
				if ($this->ProdCategory->exists()) 
				{
					$ProdCategory = $this->ProdCategory->find("first",
						array(
							"conditions" => array("ProdCategory.id" => $id),
						)
					);
					$this->set(compact("ProdCategory"));
				}
			}
		}
		else
		{
			$ProdCategory = array
			(
			    "ProdCategory" => Array
		        (
		        	"id" =>"",
		            "code" => "",
		            "name" => "",
		            "order" => 1
		        )

			);
			if($this->RequestHandler->isPost())
			{
				$ProdCategory = $this->request->data;
				if($this->request->data['ProdCategory']['code']=="")
				{
					$ProdCategory = $this->request->data;
					$ProdCategory['ProdCategory']['id'] = "";
					$this->Session->setFlash('Mã nhóm không được để trống!','flash_error');
				}
				else
				{
					$checkcode = $this->ProdCategory->find("first",
						array
						(
							'conditions' => array(
								'code' => $this->request->data['ProdCategory']['code'],
							)
						)
					);
					if(count($checkcode)>0)
					{
						$ProdCategory = $this->request->data;
						$ProdCategory['ProdCategory']['id'] = "";
						$this->Session->setFlash('Mã nhóm đã tồn tại!','flash_error');
					}
					else
					{
						$this->ProdCategory->create();
						$this->ProdCategory->save($this->request->data['ProdCategory'],false);
						$this->Session->setFlash('Đã lưu thành công','flash_success');
								return $this->redirect(array(
									'controller' => 'Products',
									'action' => 'admin_group_index',
						));
					}
				}
			}
			$this->set(compact("ProdCategory"));
		}
	}
	public function admin_index()
	{
		if($this->RequestHandler->isAjax()){

			$cat_id = intval($this->request->data['filter']);
			if($cat_id>0)
			{
				$this->Paginator = $this->Components->load('Paginator');
				$this->Paginator->settings = array(
					'Product' => array(
						'contain' => array('ProdCategory'),
						'recursive' => -1,
						'order' => array(
							'id' => 'DESC'
						),
						'conditions' => array('cat_id' => $cat_id),
						'limit' => 20,
						'paramType' => 'querystring',
					)
				);
					$Products = $this->Paginator->paginate();
		$this->set(compact('Products'));
				$this->render('/Elements/Products/admin_index');
				return;
			}
		}
		$this->loadModel('ProdCategory');
		$ProdCategories = $this->ProdCategory->find("all",		
		array(
			'order' => 'order DESC',
			)
		);
		$this->set(compact('ProdCategories'));
		$this->Paginator = $this->Components->load('Paginator');

		$this->Paginator->settings = array(
			'Product' => array(
				'contain' => array('ProdCategory'),
				'recursive' => -1,
				'order' => array(
					'id' => 'DESC'
				),
				'limit' => 20,
				'paramType' => 'querystring',
			)
		);
		$Products = $this->Paginator->paginate();

		$this->set(compact('Products'));
	}	

	public function admin_del()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->Product->create();
			$this->Product->id = $id;
			if ($this->Product->exists()) 
			{
				$this->Product->delete();
				$this->Session->setFlash('Đã xoá thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Products',
							'action' => 'admin_index',
				));
			}
			else
			{
				$this->Session->setFlash('Sản phẩm không tồn tại','flash_error');
						return $this->redirect(array(
							'controller' => 'Products',
							'action' => 'admin_index',
				));
			}
		}
	}
	public function admin_edit()
	{
		$this->loadModel('ProdCategory');
		$ProdCategories = $this->ProdCategory->find("all",array());
		$ListGroup = array();
		foreach($ProdCategories as $ProdCategory)
		{
			$ListGroup[$ProdCategory['ProdCategory']['id']] = $ProdCategory['ProdCategory']['name'];
		}
		$this->set(compact("ListGroup"));
		if(isset($this->params->pass[0]))
		{
			$id = intval($this->params->pass[0]);
			if($id>0)
			{
				if($this->RequestHandler->isPost())
				{
					$this->Product->create();
					$this->Product->id = $id;
					if ($this->Product->exists()) 
					{
						$this->Product->save($this->request->data['Product'],false);
						$this->Session->setFlash('Đã lưu thành công','flash_success');
								return $this->redirect(array(
									'controller' => 'Products',
									'action' => 'admin_index',
						));
					}
					exit;
				}
				$this->Product->create();
				$this->Product->id = $id;
				if ($this->Product->exists()) 
				{
					$Product = $this->Product->find("first",
						array(
							"contain" => array("ProdCategory"),
							"conditions" => array("Product.id" => $id),
						)
					);
					$this->set(compact("Product"));
				}
			}
		}
		else
		{
			$Product = array
			(
			    "Product" => Array
			    (
			    	"id" => "",
		            "cat_id" => 1,
		            "name" => "",
		            "image" => "",
		            "described" => "",
		            "detail" => ""
		        ),
			    "ProdCategory" => Array
		        (
		            "id" => 1,
		            "code" => "",
		            "name" => "",
		            "order" => 1
		        )

			);
			if($this->RequestHandler->isPost())
			{
				$this->Product->create();
				$this->Product->save($this->request->data['Product'],false);
					$this->Session->setFlash('Đã lưu thành công','flash_success');
							return $this->redirect(array(
								'controller' => 'Products',
								'action' => 'admin_index',
					));
			}
			$this->set(compact("Product"));
		}
	}
}
?>