<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::uses('ChatboxController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class HomesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
public $uses = array();

private $error_messages  = array(
	'name'    => 'Hãy điền tên của bạn.',
	'email'   => 'Hãy điền chính xác địa chỉ email của bạn.',
	'subject' => 'Hãy điền tiêu đề.',
	'message' => 'Hãy điền nội dung.',
	'else'    => 'Có lỗi xảy ra.',
	);

private $success_message  = 'Email đã được gửi thành công!';
/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
public function admin_home()
{
	$this->loadModel("StaffGroupService");
	$this->loadModel("BillService");
	$this->loadModel("User");
	$this->loadModel("Service");
	$Services = $this->StaffGroupService->find("all", array(
		"contain" => array("Service"),
		));
	$ret = array();
	foreach ($Services as $key => $Service) {
		
		$duration = $Service['Service']['duration'];
		$result = $this->BillService->find("all", array(
			"conditions" => array(
				"BillService.service_id" => $Service['StaffGroupService']['id'],
				"Bill.created <=" => date('Y-m-d', strtotime(date("Y-m-d") . " - $duration day")),
				),
			"contain" => array("Bill"),
			"limit" => 100,
			));

		foreach ($result as $key => $serv) {
			if($serv['Bill']['user_id'] == 3){
				$User = array(
					"name" => $serv['Bill']['name']." <i>(Khách)</i>",
					"phonenumber" => $serv['Bill']['phonenumber'],
					);
			}
			else{
				$User = $this->User->read(null, $serv['Bill']['user_id']);
				$User = $User['User'];
			}
			$ret[] = array(
				"User" => $User,
				"Service" => $Service['Service'],
				"Bill" => $serv['Bill'],
				"BillService" => $serv['BillService'],
				);
		}
	}
	$this->Set("Services", $ret);

}
public function admin_dashboard(){

}

public function sent_sms()
{
	$this->loadModel("StaffGroupService");
	$this->loadModel("BillService");
	$this->loadModel("User");
	$this->loadModel("Service");
	$Services = $this->StaffGroupService->find("all", array(
		"contain" => array("Service"),
		));
	$ret = array();
	foreach ($Services as $key => $Service) {
		
		$duration = $Service['Service']['duration'];
		if($duration == 0 || $Service['Service']['message'] == ""){
			continue;
		}
		$result = $this->BillService->find("all", array(
			"conditions" => array(
				"BillService.service_id" => $Service['StaffGroupService']['id'],
				"Bill.created <=" => date('Y-m-d', strtotime(date("Y-m-d") . " - $duration day")),
				"BillService.sms" => 0,
				),
			"contain" => array("Bill"),
			"limit" => 100,
			));

		foreach ($result as $key => $serv) {
			if($serv['Bill']['user_id'] == 3){
				$User = array(
					"name" => $serv['Bill']['name'],
					"phonenumber" => $serv['Bill']['phonenumber'],
					);
			}
			else{
				$User = $this->User->read(null, $serv['Bill']['user_id']);
				$User = $User['User'];
			}
			$ret[] = array(
				"User" => $User,
				"Service" => $Service['Service'],
				"Bill" => $serv['Bill'],
				"BillService" => $serv['BillService'],
				);
		}
	}
	foreach ($ret as $customer) {
		$message = $customer['Service']['message'];
		$date = date("d-m",strtotime($customer['Bill']['created']));
		$cus_name = $customer['User']['name'];
		$phonenumber = $customer['User']['phonenumber'];
		$text = sprintf($message, $cus_name, $date);
		$this->send_sms($phonenumber,$text);
		$this->BillService->Create();
		$this->BillService->id = $customer['BillService']['id'];
		$this->BillService->saveField("sms","1");
		pr($text);
	}
	$this->autoRender = false;
}
function _substr($str, $length, $minword = 3)
{
	$sub = '';
	$len = 0;
	foreach (explode(' ', $str) as $word)
	{
		$part = (($sub != '') ? ' ' : '') . $word;
		$sub .= $part;
		$len += strlen($part);
		if (strlen($word) > $minword && strlen($sub) >= $length)
		{
			break;
		}
	}
	return $sub . (($len < strlen($str)) ? '...' : '');
}
public function index()
{
	$this->layout = 'home';
	$this->loadModel("News");

	//news & event
	$events = $this->News->getNewsHome(1,6);
	$this->set(compact('events'));

	//show quoc te
	$showEn = $this->News->getNewsHome(2,6);
	$this->set(compact('showEn'));
	
	//show vietnam
	$showVn = $this->News->getNewsHome(1,4);
	foreach ($showVn as $key => $value) {
		$showVn[$key]['News']['description'] = $this->_substr($showVn[$key]['News']['description'],80);
	}
	$this->set(compact('showVn'));


	$this->loadModel('Awards');
	$awards = $this->Awards->find("all", array
		(
		//	"conditions" => array("category_id" => 4),
			"order" => array('id desc'),
			)
		);
	$this->set(compact('awards'));


	$oscars = $this->News->getNewsHome(5,6);
	$this->set(compact('oscars'));


	$idol = $this->News->getNewsHome(6,6);
	$this->set(compact('idol'));

	$cliphot = $this->News->getNewsHome(8,9);
	$this->set(compact('cliphot'));

	$showhot = $this->News->getNewsHome(9,9);
	$this->set(compact('showhot'));

	$news = $this->News->getLastest(0,8);
	$this->set(compact('news'));

	$this->loadModel('Advertise');
	$rightadvert = $this->Advertise->find('all',array(
		'conditions' => array(
			'Advertise.location_id' => 2,
			'approved' => 1,
			),
		'order' => 'Advertise.order ASC',
		));
	foreach ($rightadvert as $key => $value) {
		$rightadvert[$key]['Advertise']['image'] = json_decode($value['Advertise']['image'], true);
		$rightadvert[$key]['Advertise']['url'] = json_decode($value['Advertise']['url'], true);
	}
	$this->set(compact('rightadvert'));

	$midadvert = $this->Advertise->find('all',array(
		'conditions' => array(
			'Advertise.location_id' => 3,
			'approved' => 1,
			),
		'order' => 'Advertise.order ASC',
		));
	foreach ($midadvert as $key => $value) {
		$midadvert[$key]['Advertise']['image'] = json_decode($value['Advertise']['image'], true);
		$midadvert[$key]['Advertise']['url'] = json_decode($value['Advertise']['url'], true);
	}
	$this->set(compact('midadvert'));

	$topadvert = $this->Advertise->find('all',array(
		'conditions' => array(
			'Advertise.location_id' => 1,
			'approved' => 1,
			),
		'order' => 'Advertise.order ASC',
		));
	foreach ($topadvert as $key => $value) {
		$topadvert[$key]['Advertise']['image'] = json_decode($value['Advertise']['image'], true);
		$topadvert[$key]['Advertise']['url'] = json_decode($value['Advertise']['url'], true);
	}
	$this->set(compact('topadvert'));
}

public function display() {
	$path = func_get_args();

	$count = count($path);
	if (!$count) {
		return $this->redirect('/');
	}
	$page = $subpage = $title_for_layout = null;

	if (!empty($path[0])) {
		$page = $path[0];
	}
	if (!empty($path[1])) {
		$subpage = $path[1];
	}
	if (!empty($path[$count - 1])) {
		$title_for_layout = Inflector::humanize($path[$count - 1]);
	}
	$this->set(compact('page', 'subpage', 'title_for_layout'));

	try {
		$this->render(implode('/', $path));
	} catch (MissingViewException $e) {
		if (Configure::read('debug')) {
			throw $e;
		}
		throw new NotFoundException();
	}
}

public function contact()
{
	$this->autoRender = false;

	if( $this->request->is( 'post' ) )
	{
		$data = $this->request->data;
		$errors = array();
		$response = array();
		if( !$data['name'] )
		{ 
			$errors[] = $this->error_messages['name'];		        		       
		} 
		if( !$data['subject'] ){ 

			$errors[] = $this->error_messages['subject'];
		} 
		if( !$data['message'] ){ 
			$errors[] = $this->error_messages['message'];
		} 

		if( empty( $data['email'] ) || ! filter_var( $data['email'], FILTER_VALIDATE_EMAIL )) 
		{  
			$errors[] = $this->error_messages['email']; 
		}
		if( count( $errors ) )
		{
			$response = array(
				'success' => 0,
				'message' => implode( '<br />', $errors )
				);		
			$this->json = json_encode($response);
			$this->response->body($this->json);
			return;         
		}

		$Email = new CakeEmail('gmail');
		$Email->from($data['email']);
		$Email->to( 'info@mqsolutions.vn' );
		$Email->subject( 'Mercari Contact Mail '. $data['subject'] );
		try {
			if( $Email->send( $data['message'] ))
			{
				$response = array(
					'success' => 1,
					'message' => $this->success_message
					);
			}
			else
			{
				$response = array(
					'success' => 0,
					'message' => $this->error_messages['else']
					);
			}
		} catch (Exception $e) {
			$response = array(
				'success' => 0,
				'message' => $this->error_messages['else']
				);
		}
		$this->json = json_encode( $response );			
	}
	else
	{
		return $this->redirect('/');
	}
	$this->response->body($this->json);
}
function getSubcategory($parent_id){
	$this->loadModel("Category");
	$Categories = $this->Category->find("all", array(
		"conditions" => array(
			"parent_id" => $parent_id,
			),
		"order" => array("sort asc"),
		));
	return $Categories;
}
}
