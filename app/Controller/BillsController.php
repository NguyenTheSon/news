<?php
App::uses('AppController', 'Controller');
define("SMS_BALANCE","So tien GD: %s. So du: %s. %s. http://hairspa.vn");
class BillsController  extends AppController {
	public $components = array('RequestHandler',);
	public function beforeFilter()
	{
		parent::beforeFilter();
		
	}
	
	public function admin_add($id = null)
	{
		if($this->request->is('post')) {
			$data = $this->request->data;

			if($data['Bill']['user_id'] == 0){
				$this->Session->setFlash('Bạn chưa chọn khách hàng', 'flash_error');
				return $this->redirect(array('action'=>'add'));
			}

			$this->loadModel("StaffGroupService");
			$total = $this->StaffGroupService->find("all", array(
				"conditions" => array(
					"id" => $data['Service'],
				),
				"fields" => array("sum(price) as total")
			));
			$total = $total[0][0]['total'];
			$save = array(
				"total_money" => $total,
				"user_id" => $data['Bill']['user_id'],
				"discount" => $data['Bill']['discount'],
				"pay_type" => $data['Bill']['pay_type'],
			);
			$this->loadModel("BillService");
			if($data['Bill']['pay_type'] == 1){
				$this->loadModel("User");
				$User = $this->User->read(null,$data['Bill']['user_id']);
				$needBalance = $total - $data['Bill']['discount'];	
				if($needBalance > $User['User']['balance']){
					$this->Session->setFlash("Số dư tài khoản không đủ!","flash_error");
					return $this->redirect(array('action'=>'add'));
				}
			}
			if($this->Bill->save($save)){
				$Bill_id = $this->Bill->id;
				foreach ($data['Service'] as $key => $Service) {
					if($Service !=0){
						$this->BillService->Create();
						$this->BillService->save(array(
							"bill_id" => $Bill_id,
							"service_id" => $Service
						));
					}
				}
				if($data['Bill']['pay_type'] == 1){
					$this->User->UpdateAll(array("balance"=> "balance - $needBalance"),array("User.id" => $data['Bill']['user_id']));
					$newBalance = $User['User']['balance'] - $needBalance;
					$listService = $this->StaffGroupService->find("list", array(
						"conditions" => array(
							"StaffGroupService.id" => $data['Service'],
						),
						"fields" => array("Service.name"),
						"contain" => array("Service"),
					));
					$listService = implode($listService, ", ");
					$reason = "SD dich vu: ".$listService." . Ngay ".date("d/m/Y");
					$text = sprintf(SMS_BALANCE,number_format(-$needBalance),number_format($newBalance),$reason);
					$this->send_sms($User['User']['phonenumber'],$text);
				}

				$this->Session->setFlash('Tạo hóa đơn thành cộng', 'flash_success');
				return $this->redirect(array('action'=>'edit',$Bill_id));
			}
			$this->Session->setFlash('Có lỗi khi tạo hóa đơn', 'flash_error');
			return $this->redirect(array('action'=>'add'));
			
		}
		###########################
		$listService = array();
		if($id){
				$this->loadModel("Setup");
				$this->loadModel("SetupService");
				$Setup = $this->Setup->find("first", array(
					"conditions" => array("Setup.id" => $id),
					"contain" => array("SetupService"),
				));

				$listService = $this->SetupService->find("list", array(
					"conditions" => array(
						"setup_id" => $id,
					),
					"fields" => array("service_id"),
				));
				
				$this->loadModel("StaffGroupService");
				$total = $this->StaffGroupService->find("all", array(
					"conditions" => array(
						"id" => $listService,
					),
					"fields" => array("sum(price) as total")
				));
				$total = $total[0][0]['total'];
				$Setup['Setup']['total_money'] = $total;
				$Setup['Setup']['discount'] = 0;

				if($Setup['Setup']['user_id'] == -1){
					$Setup['User'] = array(
						"name" => $Setup['Setup']['fullname']." <i>(Khách)</i>",
						"phonenumber" => $Setup['Setup']['phone'],
						"address" => "<i>người dùng ở chế độ khách, có thể chọn lại người dùng là thành viên.</i>"
					);
				}
				else{
					$user = $this->User->read(null, $Setup['Setup']['user_id']);
					$Setup['User'] = $user['User'];
				}
				$Setup['Bill'] = $Setup['Setup'];
				$this->request->data = $Setup;
		}
		#############################################

		$ArrServices = array();


		$this->loadModel('ServiceGroup');
		$ServiceGroups = $this->ServiceGroup->find("all",		
		array()
		);
		$this->loadModel('Service');
		$this->loadModel('StaffGroupService');
		for($i = 0;$i<count($ServiceGroups); $i++)
		{
			$Service = $this->Service->find("all",		
				array
				(
					"conditions" => "service_group_id=".$ServiceGroups[$i]['ServiceGroup']['id'],
				)
			);
			$ServiceGroups[$i]['Service'] = $Service;
			for($j = 0; $j<count($Service);$j++)
			{
				$StaffGroupServices = $this->StaffGroupService->find("all",
					array
					(
						'contain' => array("StaffGroup"),
						'conditions' => "StaffGroupService.service_id = ".$Service[$j]['Service']['id'],
						'fields' => array("StaffGroup.*","StaffGroupService.*")
					)
				);
				foreach ($StaffGroupServices as $key => $StaffGroupService) {
					if(in_array($StaffGroupService['StaffGroupService']['id'],$listService)){
						$StaffGroupServices[$key]['StaffGroupService']['selected'] = true;
					}
					else{
						$StaffGroupServices[$key]['StaffGroupService']['selected'] = false;
					}
				}
				$ServiceGroups[$i]['Service'][$j]['StaffGroup'] = $StaffGroupServices;

			}
		}
		$this->set(compact('ServiceGroups'));
	}

	public function admin_index() {
		if($this->RequestHandler->isAjax())
		{ 
			if (isset($this->request->data['Bills']['keyword']))
			{
				$this->Session->write('Bills.filter_keyword',$this->request->data['Bills']['keyword']);
			}
			if(isset($this->request->data['Bills']['begin_date']) && isset($this->request->data['Bills']['end_date'])) {
				$this->Session->write('Bills.filter', $this->request->data['Bills']['filter']);
				$this->Session->write('Bills.begin_date', $this->request->data['Bills']['begin_date']);
				$this->Session->write('Bills.end_date', $this->request->data['Bills']['end_date']);
			} else {

			}
			$this->Paginator = $this->Components->load('Paginator');
			$conditions['OR'] = array(
				array('User.name Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
				array('User.phonenumber Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
				array('Bill.name Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
				array('Bill.phonenumber Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
			);
			if($this->Session->read('Bills.begin_date') && $this->Session->read('Bills.end_date')){
				$conditions['Bill.created >='] = $this->Session->read('Bills.begin_date');
				$conditions['Bill.created <='] = $this->Session->read('Bills.end_date');
			}
			$this->Paginator->settings = array(
				'Bill' => array(
					'recursive' => -1,
					'contain' => array(
						"BillService", "User",
					),
					'conditions' => $conditions,
					'order' => array(
						'Date' => 'DESC'
					),
					'limit' => 20,
					'paramType' => 'querystring',
				)
			);
			
			$Bills = $this->Paginator->paginate();

			$this->loadModel('User');
			$this->loadModel('StaffGroupService');
			for($i=0; $i< count($Bills); $i++){
				if($Bills[$i]['Bill']['user_id'] != 3){
					$customer = $this->User->read(null,$Bills[$i]['Bill']['user_id']);
					$Bills[$i]['User'] = $customer['User'];
				}
				else{
					$Bills[$i]['User'] = array(
						"name" => $Bills[$i]['Bill']['name'],
						"phonenumber" => $Bills[$i]['Bill']['phonenumber'],
					);
				}
				$Bills[$i]['Service'] = array();
				foreach ($Bills[$i]['BillService'] as $key => $Service) {
					$Sv = $this->StaffGroupService->find("first", array(
						"conditions" => array(
							"StaffGroupService.id" => $Service['service_id'], 
						),
						"contain" => array("Service", "StaffGroup"),
					));
					$Bills[$i]['Service'][] = $Sv;
				}
			}

			$this->set(compact('Bills'));

		  	$this->render('/Elements/Bills/admin_index');
			return;
		}
		$this->Paginator = $this->Components->load('Paginator');

		$this->Paginator->settings = array(
			'Bill' => array(
				'contain' => array(
					"BillService","User",
				),
				'conditions' =>array(
                               'OR'	=>array(
                               	    array('Bill.name Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
                                    array('Bill.phonenumber Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
                                    array('User.name Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
                                    array('User.phonenumber Like' => '%'.$this->Session->read('Bills.filter_keyword').'%'),
                                )),
				'order' => array(
					'created' => 'DESC'
				),
				'limit' => 20,
				'paramType' => 'querystring',
			)
		);
		$Bills = $this->Paginator->paginate();
		$this->loadModel('User');
		$this->loadModel('StaffGroupService');
		for($i=0; $i< count($Bills); $i++){
			if($Bills[$i]['Bill']['user_id'] != 3){
				$customer = $this->User->read(null,$Bills[$i]['Bill']['user_id']);
				$Bills[$i]['User'] = $customer['User'];
			}
			else{
				$Bills[$i]['User'] = array(
					"name" => $Bills[$i]['Bill']['name'],
					"phonenumber" => $Bills[$i]['Bill']['phonenumber'],
				);
			}

			$Bills[$i]['Service'] = array();
			foreach ($Bills[$i]['BillService'] as $key => $Service) {
				$Sv = $this->StaffGroupService->find("first", array(
					"conditions" => array(
						"StaffGroupService.id" => $Service['service_id'], 
					),
					"contain" => array("Service", "StaffGroup"),
				));
				$Bills[$i]['Service'][] = $Sv;
			}
		}

		$this->set(compact('Bills'));
	}

	public function admin_view($id){
		$this->loadModel("Setup");
		$this->Setup->id = $id;
		if (!$this->Setup->exists()) {
			throw new NotFoundException('Lịch không tồn tại!');
		}
		$Setup = $this->Setup->find("first", array(
			"conditions" => array(
				"Setup.id" => $id
			),
			"contain" => array("SetupService"),
		));
		$this->loadModel("StaffGroupService");
		foreach ($Setup['SetupService'] as $key => $Service) {
			$Sv = $this->StaffGroupService->find("first", array(
				"conditions" => array(
					"StaffGroupService.id" => $Service['service_id'], 
				),
				"contain" => array("Service", "StaffGroup"),
			));
			$Setup['Service'][] = $Sv;
		}
		pr($Setup);
		exit;

	}
	public function admin_edit($id){
		$this->Bill->id = $id;
		if (!$this->Bill->exists()) {
			throw new NotFoundException('Hóa đơn không tồn tại!');

		}
		if($this->request->is(array('post','put'))) {
			$data = $this->request->data;
			if($data['Bill']['user_id'] == 0){
				$this->Session->setFlash('Bạn chưa chọn khách hàng', 'flash_error');
				return $this->redirect(array('action'=>'add'));
			}

			$this->loadModel("StaffGroupService");
			$total = $this->StaffGroupService->find("all", array(
				"conditions" => array(
					"id" => $data['Service'],
				),
				"fields" => array("sum(price) as total")
			));
			$total = $total[0][0]['total'];
			$oldBill = $this->Bill->find("first",array(
				"conditions" => array(
					"Bill.id" => $id),
				"contain" => array("User")));
			#### xu ly tinh toan lai tien #######
			$needBalance = 0;
			if($oldBill['Bill']['pay_type'] == 0 && $data['Bill']['pay_type'] == 1){
				$needBalance = $total - $data['Bill']['discount'];
			}
			elseif($oldBill['Bill']['pay_type'] == 1 && $data['Bill']['pay_type'] == 1){
				$needBalance = ($total - $data['Bill']['discount']) - ($oldBill['Bill']['total_money'] - $oldBill['Bill']['discount']);
			}
			elseif($oldBill['Bill']['pay_type'] == 1 && $data['Bill']['pay_type'] == 0){
				$needBalance = - ($total - $data['Bill']['discount']);
			}
			if($needBalance > $oldBill['User']['balance']){
				$this->Session->setFlash("Số dư tài khoản không đủ!","flash_error");
				return $this->redirect(array('action'=>'edit',$id));
			}
			################################
			$save = array(
				"Bill.id" => $id,
				"total_money" => $total,
				"user_id" => $data['Bill']['user_id'],
				"discount" => $data['Bill']['discount'],
				"pay_type" => $data['Bill']['pay_type'],
			);
			$this->loadModel("BillService");
			$listService = $this->BillService->find("list", array(
				"conditions" => array('bill_id' => $id),
				"fields" => array("service_id"),
			));
			if($this->Bill->save($save)){
				$Bill_id = $id;
				foreach ($data['Service'] as $key => $Service) {
					if($Service !=0 && !in_array($Service, $listService)){
						$this->BillService->Create();
						$this->BillService->save(array(
							"bill_id" => $Bill_id,
							"service_id" => $Service
						));
					}
				}
				foreach ($listService as $key => $Service) {
					if(!in_array($Service, $data['Service'])){
						$this->BillService->deleteAll(array("BillService.service_id" => $Service, "BillService.bill_id" => $id));
					}
				}
				$this->loadModel("User");
				if($data['Bill']['pay_type'] == 1){
					$this->User->UpdateAll(array("balance"=> "balance - $needBalance"),array("User.id" => $data['Bill']['user_id']));
					$newBalance = $oldBill['User']['balance'] - $needBalance;
					$listService = $this->StaffGroupService->find("list", array(
						"conditions" => array(
							"StaffGroupService.id" => $data['Service'],
						),
						"fields" => array("Service.name"),
						"contain" => array("Service"),
					));
					$listService = implode($listService, ", ");
					$reason = "Sua Hoa don #".$oldBill['Bill']['id'].". (SD dich vu ".$listService.") . Ngay ".date("d/m/Y",strtotime($oldBill['Bill']['created']));
					$text = sprintf(SMS_BALANCE,number_format(-$needBalance),number_format($newBalance),$reason);
					$this->send_sms($oldBill['User']['phonenumber'],$text);
				}
				$this->Session->setFlash('Sửa hóa đơn thành công', 'flash_success');
				return $this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash('Có lỗi khi sửa hóa đơn', 'flash_error');
			return $this->redirect(array('action'=>'index'));
			
		}


		$cBill = $this->Bill->find("first", array(
			"conditions" => array("Bill.id" => $id),
			"contain" => array("User"),
		));
		if($cBill['Bill']['user_id'] == 3){
			$cBill['User'] = array(
				"name" => $cBill['Bill']['name']." <i>(Khách)</i>",
				"phonenumber" => $cBill['Bill']['phonenumber'],
				"address" => "<i>người dùng ở chế độ khách, có thể chọn lại người dùng là thành viên.</i>"
			);
		}
		$this->request->data = $cBill;
		$this->loadModel("BillService");
		$listService = $this->BillService->find("list", array(
			"conditions" => array("bill_id" => $id),
			"fields" => array("service_id"),
		));
		$ArrServices = array();

		$this->loadModel('ServiceGroup');
		$ServiceGroups = $this->ServiceGroup->find("all",		
		array()
		);
		$this->loadModel('Service');
		$this->loadModel('StaffGroupService');
		for($i = 0;$i<count($ServiceGroups); $i++)
		{
			$Service = $this->Service->find("all",		
				array
				(
					"conditions" => "service_group_id=".$ServiceGroups[$i]['ServiceGroup']['id'],
				)
			);
			$ServiceGroups[$i]['Service'] = $Service;
			for($j = 0; $j<count($Service);$j++)
			{
				$StaffGroupServices = $this->StaffGroupService->find("all",
					array
					(
						'contain' => array("StaffGroup"),
						'conditions' => "StaffGroupService.service_id = ".$Service[$j]['Service']['id'],
						'fields' => array("StaffGroup.*","StaffGroupService.*")
					)
				);
				foreach ($StaffGroupServices as $key => $StaffGroupService) {
					if(in_array($StaffGroupService['StaffGroupService']['id'],$listService)){
						$StaffGroupServices[$key]['StaffGroupService']['selected'] = true;
					}
					else{
						$StaffGroupServices[$key]['StaffGroupService']['selected'] = false;
					}
				}
				$ServiceGroups[$i]['Service'][$j]['StaffGroup'] = $StaffGroupServices;

			}
		}
		$this->set(compact('ServiceGroups'));

	}
	public function admin_delete($id){
		$this->Bill->id = $id;
		if (!$this->Bill->exists()) {
			throw new NotFoundException('Hóa đơn không tồn tại!');
		}
		if ($this->Bill->delete()) {
			$this->Session->setFlash('Xóa Hóa đơn thành công', 'flash_success');
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Có lỗi, hãy thử lại', 'flash_error');
		return $this->redirect(array('action' => 'index'));

	}
	public function admin_find_user(){
		$this->autoRender = false;
		if($this->RequestHandler->isAjax())
		{
			$data = $this->request->data;
			$check = $this->User->find("all", array(
				"conditions" => array(
					"OR" => array(
						"phonenumber like" => "%".$data['q']."%",
						"name like" => "%".$data['q']."%",
					),
				)
			));
			if($check){
				$check = Set::extract("/User/.",$check);
			}
			else{
				$check = array();
			}
			echo json_encode($check);
		}
	}
	
	

}
?>