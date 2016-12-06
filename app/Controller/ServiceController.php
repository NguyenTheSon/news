<?php
App::uses('AppController', 'Controller');
class ServiceController  extends AppController {
	public $components = array('RequestHandler',);
	public function beforeFilter()
	{
		parent::beforeFilter();
		
	}
	
	public function admin_index() {
		$this->Paginator = $this->Components->load('Paginator');

		$this->Paginator->settings = array(
			'Service' => array(
				'recursive' => -1,
				'conditions' =>array(
                               'OR'	=>array(
                               	     array('name Like' => '%'.$this->Session->read('Service.filter_keyword').'%'),
                                )),
				
				'limit' => 20,
				'paramType' => 'querystring',
			)
		);
		$Services = $this->Paginator->paginate();
		$this->loadModel('ServiceGroup');
		/*$Services = $this->Service->find("all",		
		array()
		);*/
		for($i = 0; $i<count($Services);$i++)
		{
			$Services[$i][] =  $this->ServiceGroup->read(null,$Services[$i]['Service']['service_group_id']);
		}
		// for($i=0; $i< count($Setups); $i++){
		// 	if($Setups[$i]['Setup']['user_id'] != -1){
		// 		$customer = $this->User->read(null,$Setups[$i]['Setup']['user_id']);
		// 		$Setups[$i]['User'] = $customer['User'];
		// 	}
		// 	$Setups[$i]['Service'] = array();
		// 	foreach ($Setups[$i]['SetupService'] as $key => $Service) {
		// 		$Sv = $this->StaffGroupService->find("first", array(
		// 			"conditions" => array(
		// 				"StaffGroupService.id" => $Service['service_id'], 
		// 			),
		// 			"contain" => array("Service", "StaffGroup"),
		// 		));
		// 		$Setups[$i]['Service'][] = $Sv;
		// 	}
		// }
		 $this->set(compact('Services'));
		 if($this->RequestHandler->isAjax()){
			$this->render('/Elements/Service/admin_index');
			return;
		}
	}
public function admin_group_service() {
		$this->loadModel('ServiceGroup');
		
		$this->Paginator = $this->Components->load('Paginator');

		$this->Paginator->settings = array(
			'ServiceGroup' => array(
				'recursive' => -1,
				'conditions' =>array(
                               'OR'	=>array(
                               	     array('group_name Like' => '%'.$this->Session->read('ServiceGroup.filter_keyword').'%'),
                                )),
				'order' => array(
					'id' => 'DESC'
				),
				'limit' => 20,
				'paramType' => 'querystring',
			)
		);
		$Services = $this->Paginator->paginate("ServiceGroup");
		$ServiceGroups = $this->ServiceGroup->find("all",		
		array()
		);
		// for($i=0; $i< count($Setups); $i++){
		// 	if($Setups[$i]['Setup']['user_id'] != -1){
		// 		$customer = $this->User->read(null,$Setups[$i]['Setup']['user_id']);
		// 		$Setups[$i]['User'] = $customer['User'];
		// 	}
		// 	$Setups[$i]['Service'] = array();
		// 	foreach ($Setups[$i]['SetupService'] as $key => $Service) {
		// 		$Sv = $this->StaffGroupService->find("first", array(
		// 			"conditions" => array(
		// 				"StaffGroupService.id" => $Service['service_id'], 
		// 			),
		// 			"contain" => array("Service", "StaffGroup"),
		// 		));
		// 		$Setups[$i]['Service'][] = $Sv;
		// 	}
		// }
		 $this->set(compact('ServiceGroups'));
		 if($this->RequestHandler->isAjax()){
			$this->render('/Elements/Service/admin_group_service');
			return;
		}
	}

	public function admin_del_group()
	{
		$this->loadModel('ServiceGroup');
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->ServiceGroup->create();
			$this->ServiceGroup->id = $id;
			if ($this->ServiceGroup->exists()) 
			{
				$this->ServiceGroup->delete();
				$this->Session->setFlash('Đã xoá thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Service',
							'action' => 'admin_group_service',
				));
			}
			else
			{
				$this->Session->setFlash('Nhóm dịch vụ không tồn tại','flash_error');
						return $this->redirect(array(
							'controller' => 'Service',
							'action' => 'admin_group_service',
				));
			}
		}
	}
	public function admin_del()
	{
		$id = intval($this->params->pass[0]);
		if($id>0)
		{
			$this->Service->create();
			$this->Service->id = $id;
			if ($this->Service->exists()) 
			{
				$this->Service->delete();
				$this->Session->setFlash('Đã xoá thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Service',
							'action' => 'admin_index',
				));
			}
			else
			{
				$this->Session->setFlash('Dịch vụ không tồn tại','flash_error');
						return $this->redirect(array(
							'controller' => 'Service',
							'action' => 'admin_index',
				));
			}
		}
	}
	
	public function admin_edit_group()
	{

		$this->loadModel('ServiceGroup');
		$ServiceGroup = array(
			"ServiceGroup" => array(
				"id" => "",
				"group_name" => "",
				"group_type" => "1"
			),
		);
		
		if(isset($this->params->pass[0]))
		{
			$id = intval($this->params->pass[0]);
			$this->ServiceGroup->create();
			$this->ServiceGroup->id = $id;
			if ($this->ServiceGroup->exists()) 
			{
				if($this->RequestHandler->isPost())
				{
					
					$this->ServiceGroup->save($this->RequestHandler->request['data'],false);
					$this->Session->setFlash('Đã sửa thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Service',
							'action' => 'admin_group_service',
					));
				}
				$ServiceGroup = $this->ServiceGroup->read(null,$id);
			}
		}
		else
		{
			if($this->RequestHandler->isPost())
			{
				$this->ServiceGroup->create();
				$this->ServiceGroup->save($this->RequestHandler->request['data'],false);
				$this->Session->setFlash('Đã thêm thành công','flash_success');
					return $this->redirect(array(
						'controller' => 'Service',
						'action' => 'admin_group_service',
				));
			}
		}

		 $this->set(compact('ServiceGroup'));


	}

	public function admin_edit()
	{

		$this->loadModel('ServiceGroup');
		$this->loadModel('StaffGroupService');
		$ServiceGroups = $this->ServiceGroup->find("all",array());
		$ListGroup = array();
		foreach($ServiceGroups as $ServiceGroup)
		{
			$ListGroup[$ServiceGroup['ServiceGroup']['id']] = $ServiceGroup['ServiceGroup']['group_name'];
		}
		$Service = array(
			"ServiceGroup" => array(
				"id" => "",
				"group_name" => "",
			),
			"Service" => array(
				"id" => "",
				"name" => "",
				"detail" => "",
				"service_group_id" => "",
				"duration" => "",
				"message" => "",
				"message" => "",
			),
			"StaffGroupService" => array(
				array(
				"id" => "",
				"service_id" => "",
				"staff_group_id" => "1",
				"time" => "",
				"price" => "",
				),
				array(
				"id" => "",
				"service_id" => "",
				"staff_group_id" => "2",
				"time" => "",
				"price" => "",
				)
			),
		);
		
		if(isset($this->params->pass[0]))
		{
			$id = intval($this->params->pass[0]);
			$this->Service->create();
			$this->Service->id = $id;
			if ($this->Service->exists()) 
			{
				if($this->RequestHandler->isPost())
				{
					//pr($this->RequestHandler->request['data']['Service']);
					//exit;
					$this->Service->save(
						array(
							"name" => $this->RequestHandler->request['data']['Service']['name'],
							"detail" => $this->RequestHandler->request['data']['Service']['detail'],
							"service_group_id" => $this->RequestHandler->request['data']['Service']['service_group_id'],
							"message" => $this->RequestHandler->request['data']['Service']['message'],
							"duration" => $this->RequestHandler->request['data']['Service']['duration'],
						)
					);
					$this->StaffGroupService->create();
					$this->StaffGroupService->id = $this->RequestHandler->request['data']['Service']['staff_group_service_id_0'];
					if ($this->StaffGroupService->exists()) 
					{
						$this->StaffGroupService->save
						(
							array
							(
								"service_id" => $id,
								"staff_group_id" => "1",
								"time" => $this->RequestHandler->request['data']['Service']['time_0'],
								"price" => $this->RequestHandler->request['data']['Service']['Price_0'],
							)
						);
					}
					$this->StaffGroupService->create();
					$this->StaffGroupService->id = $this->RequestHandler->request['data']['Service']['staff_group_service_id_1'];
					if ($this->StaffGroupService->exists()) 
					{
						$this->StaffGroupService->save
						(
							array
							(
								"service_id" => $id,
								"staff_group_id" => "2",
								"time" => $this->RequestHandler->request['data']['Service']['time_1'],
								"price" => $this->RequestHandler->request['data']['Service']['Price_1'],
							)
						);
					}
					$this->Session->setFlash('Đã sửa thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Service',
							'action' => 'admin_index',
					));
				}
				$Service = $this->Service->find("first",
					array
					(
						"contain" => array("ServiceGroup","StaffGroupService"),
						"conditions" => array("Service.id = " =>$id),

					)
				);
			}
		}
		else
		{
			if($this->RequestHandler->isPost())
			{
					$Service = $this->Service->save(
						array(
							"name" => $this->RequestHandler->request['data']['Service']['name'],
							"detail" => $this->RequestHandler->request['data']['Service']['detail'],
							"service_group_id" => $this->RequestHandler->request['data']['Service']['service_group_id'],
							"message" => $this->RequestHandler->request['data']['Service']['message'],
						)
					);
					$this->StaffGroupService->create();
					$this->StaffGroupService->save
					(
						array
						(
							"service_id" => $Service['Service']['id'],
							"staff_group_id" => "1",
							"time" => $this->RequestHandler->request['data']['Service']['time_0'],
							"price" => $this->RequestHandler->request['data']['Service']['Price_0'],
						)
					);
					$this->StaffGroupService->create();
					$this->StaffGroupService->id = $this->RequestHandler->request['data']['Service']['staff_group_service_id_1'];
					$this->StaffGroupService->save
					(
						array
						(
							"service_id" => $Service['Service']['id'],
							"staff_group_id" => "2",
							"time" => $this->RequestHandler->request['data']['Service']['time_1'],
							"price" => $this->RequestHandler->request['data']['Service']['Price_1'],
						)
					);
					$this->Session->setFlash('Đã thêm dịch vụ thành công','flash_success');
						return $this->redirect(array(
							'controller' => 'Service',
							'action' => 'admin_index',
					));
			}
		}
$this->set(compact('ListGroup'));
		 $this->set(compact('Service'));


	}
}
?>