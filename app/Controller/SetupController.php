<?php
App::uses('AppController', 'Controller');
class SetupController  extends AppController {
	public $components = array('RequestHandler',);
	public function beforeFilter()
	{
		parent::beforeFilter();
		
	}
	
	public function index($type_id = 1)
	{
		$this->layout = "news";
		$logged = $this->Session->read('Auth.User');
		$info = array(
			"id" => "-1",
			"name" => "",
			"address" => "",
			"phonenumber" => "",
			);
		if(isset($logged['id']))
		{
			$info['id'] = $logged['id'];
			$this->set("info",$logged);
		}
		else
			$this->set("info",$info);
		$ArrServices = array();
		$this->loadModel('ServiceGroup');
		$ServiceGroups = $this->ServiceGroup->find("all",		
			array
			(
				"conditions" => array("group_type" => $type_id)
				)
			);
		$this->loadModel('Service');
		$this->loadModel('Staff');
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
						'conditions' => array(
							"StaffGroupService.service_id" =>$Service[$j]['Service']['id'],
							),
						'fields' => array("StaffGroup.*","StaffGroupService.*")
						)
					);
				$ServiceGroups[$i]['Service'][$j]['StaffGroup'] = $StaffGroupServices;

			}
		}
		$this->set(compact('ServiceGroups'));

		$date = date("Y-m-d");
		if(isset($this->request->data['date'])){
			$date = $this->request->data['date'];
		}
		//khi đổi ngày thì ajax gọi lại hàm này để render dữ liệu mới.
		list($listTask,$ListStaffName,$ListStaffID) = $this->_getDataTableTime($date);
		$this->set(compact('listTask'));
		$this->set(compact('ListStaffName'));
		$this->set(compact('ListStaffID'));
	}

	public function show(){
		if($this->RequestHandler->isAjax()){
			$this->loadModel('Staff');
			$id = $this->request->data['id'];
			if (!isset($id)){
				throw new NotFoundException('Id không tồn tại');
			}
			$Staffcontent = $this->Staff->find("first", array(
				"conditions" => array("Staff.id" => $id),
				));
			$this->set(compact("Staffcontent"));
			$this->render('/Elements/Setup/popup_content');
			return;
		} 
	}

	public function loadTaskDate(){
		$this->autoRender = false;
		$this->layout = false;
		if(isset($this->request->data['date'])){
			$date = $this->request->data['date'];
		}
		else{
			return false;
		}
		//khi đổi ngày thì ajax gọi lại hàm này để render dữ liệu mới.
		list($listTask,$ListStaffName,$ListStaffID) = $this->_getDataTableTime($date);
		return $listTask;
	}
	public function submitSetupRequest(){
		$this->layout = false;
		$arrInsert = array();
		foreach($this->request->data['services'] as $val)
		{
			if($val!=0)
				$arrInsert[] = array("setup_id" => "", "service_id" => $val);
		}
		if(count($arrInsert)>0)
		{
			$Setups = $this->Setup->create();
			$InsertSetup = $this->Setup->save( 
				array(
					'user_id' => "-1",
					'fullname' => $this->request->data['name'],
					'email' => $this->request->data['email'],
					'phone' => $this->request->data['phone'],
					'date' => $this->request->data['date'],
					'time' => $this->request->data['time'],
					'staff_id' => $this->request->data['staff'],
					)
				);
			$this->loadModel('SetupService');
			for($i = 0; $i<count($arrInsert);$i++)
			{
				$SetupServices = $this->SetupService->create();
				$InsertService = $this->SetupService->save(
					array("setup_id" => $InsertSetup['Setup']['id'], "service_id" => $arrInsert[$i]["service_id"])
					);
			}
			echo "1";
			exit;
		}
		echo "0";
		exit;
	}
	
	private function _getDataTableTime($date = null){
		$this->loadModel('Staff');
		if(!$date){
			$date = date("Y-m-d");
		}

		$Staff = $this->Staff->find("all",array(		
			));
		$ListStaffName = [];
		$ListStaffID = [];
		$listTask = [];
		foreach ($Staff as $key => $list) {
			array_push($ListStaffName,$list['Staff']['name']);
			array_push($ListStaffID,$list['Staff']['id']);
			$tasks = $this->Setup->find("list", array(
				"conditions" => array(
					"staff_id" => $list['Staff']['id'],
					"date" => $date,
					),
				"fields" => array("time")
				));
			foreach ($tasks as $key => $task) {
				$task = date("H:i", strtotime($task));
				$taskend = date("H:i", strtotime($task)+30*60);
				$listTask[$list['Staff']['id']][] = [$task,$taskend];
			}
		}
		$listTask = json_encode($listTask);
		$ListStaffName = json_encode($ListStaffName);
		$ListStaffID = json_encode($ListStaffID);
		return [
		$listTask,
		$ListStaffName,
		$ListStaffID,
		];
	}

	public function admin_index($category_id = null) {
		if($this->RequestHandler->isAjax())
		{ 
			if (isset($this->request->data['Setup']['keyword']))
			{
				$this->Session->write('Setup.filter_keyword',$this->request->data['Setup']['keyword']);
			}
			if(isset($this->request->data['Setup']['begin_date']) && isset($this->request->data['Setup']['end_date'])) {
				$this->Session->write('Setup.filter', $this->request->data['Setup']['filter']);
				$this->Session->write('Setup.begin_date', $this->request->data['Setup']['begin_date']);
				$this->Session->write('Setup.end_date', $this->request->data['Setup']['end_date']);
			} else {

			}
			$this->Paginator = $this->Components->load('Paginator');
			$conditions['OR'] = array(
				array('Setup.fullname Like' => '%'.$this->Session->read('Setup.filter_keyword').'%'),
				array('Setup.phone Like' => '%'.$this->Session->read('Setup.filter_keyword').'%'),
				);
			if($this->Session->read('Setup.begin_date') && $this->Session->read('Setup.end_date')){
				$conditions['Setup.date >='] = $this->Session->read('Setup.begin_date');
				$conditions['Setup.date <='] = $this->Session->read('Setup.end_date');
			}
			$this->Paginator->settings = array(
				'Setup' => array(
					'recursive' => -1,
					'contain' => array(
						"SetupService",
						),
					'conditions' => $conditions,
					'order' => array(
						'date' => 'DESC'
						),
					'limit' => 20,
					'paramType' => 'querystring',
					)
				);

			$Setups = $this->Paginator->paginate();

			$this->loadModel('User');
			$this->loadModel('StaffGroupService');
			for($i=0; $i< count($Setups); $i++){
				if($Setups[$i]['Setup']['user_id'] != -1){
					$customer = $this->User->read(null,$Setups[$i]['Setup']['user_id']);
					$Setups[$i]['User'] = $customer['User'];
				}
				$Setups[$i]['Service'] = array();
				foreach ($Setups[$i]['SetupService'] as $key => $Service) {
					$Sv = $this->StaffGroupService->find("first", array(
						"conditions" => array(
							"StaffGroupService.id" => $Service['service_id'], 
							),
						"contain" => array("Service", "StaffGroup"),
						));
					$Setups[$i]['Service'][] = $Sv;
				}
			}

			$this->set(compact('Setups'));

			$this->render('/Elements/Setup/admin_index');
			return;
		}
		$this->Paginator = $this->Components->load('Paginator');

		$this->Paginator->settings = array(
			'Setup' => array(
				'recursive' => -1,
				'contain' => array(
					"SetupService",
					),
				'conditions' =>array(
					'OR'	=>array(
						array('fullname Like' => '%'.$this->Session->read('Setup.filter_keyword').'%'),
						array('phone Like' => '%'.$this->Session->read('Setup.filter_keyword').'%'),
						)),
				'order' => array(
					'date' => 'DESC'
					),
				'limit' => 20,
				'paramType' => 'querystring',
				)
			);
		$Setups = $this->Paginator->paginate();
		$this->loadModel('User');
		$this->loadModel('StaffGroupService');
		for($i=0; $i< count($Setups); $i++){
			if($Setups[$i]['Setup']['user_id'] != -1){
				$customer = $this->User->read(null,$Setups[$i]['Setup']['user_id']);
				$Setups[$i]['User'] = $customer['User'];
			}
			$Setups[$i]['Service'] = array();
			foreach ($Setups[$i]['SetupService'] as $key => $Service) {
				$Sv = $this->StaffGroupService->find("first", array(
					"conditions" => array(
						"StaffGroupService.id" => $Service['service_id'], 
						),
					"contain" => array("Service", "StaffGroup"),
					));
				$Setups[$i]['Service'][] = $Sv;
			}
		}

		$this->set(compact('Setups'));
	}

	public function admin_update_state(){
		$this->autoRender = false;
		$id = $this->request->data['id'];
		$state = $this->request->data['state'];
		$this->Setup->id = $id;
		if (!$this->Setup->exists()) {
			echo json_encode(array("code" => "1004"));
			return;
		}
		$this->Setup->saveField("state", $state);

		echo json_encode(array("code" => "1000"));
		return;
	}

	public function admin_view($id){
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
		$this->Setup->id = $id;
		if (!$this->Setup->exists()) {
			throw new NotFoundException('Sản phẩm không tồn tại!');
		}

	}
	public function admin_delete($id){
		$this->Setup->id = $id;
		if (!$this->Setup->exists()) {
			throw new NotFoundException('Sản phẩm không tồn tại!');
		}
		if ($this->Setup->delete()) {
			$this->Session->setFlash('Xóa Lịch thành công', 'flash_success');
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('Có lỗi, hãy thử lại', 'flash_error');
		return $this->redirect(array('action' => 'index'));

	}
}
?>