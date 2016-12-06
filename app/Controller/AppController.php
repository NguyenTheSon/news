<?php
/**
* Application level Controller
*
* This file is application-wide controller file. You can put all
* application-wide controller-related methods here.
*
* PHP 5
*
* CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
* Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
* @link          http://cakephp.org CakePHP(tm) Project
* @package       app.Controller
* @since         CakePHP(tm) v 0.2.9
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
*/
//Configure::write('Session', [
//	'defaults' => 'php',
//	'timeout' => 1
//]);
App::uses('Controller', 'Controller');
App::import('Model', 'User');
App::import('Vendor','googleAPI/uploadImage');
/**
* Application Controller
*
* Add your application-wide methods in the class below, your controllers
* will inherit them.
*
* @package       app.Controller
* @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
*/

define("GOOGLE_API_KEY", "AIzaSyAFFTdA9ZjUxMa7OdGNE6CoS-EYp59JHLA");
define("PUSH_MODE", "QUEUE"); //QUEUE or SHELL
define("WEB", "spavideo.dev");
/*
	QUEUE: cho vao hang doi va tao 1 tien trinh de push
	SHELL: tư dong tao 1 tien trinh de push ngay lap tuc.
*/
	class AppController extends Controller {

////////////////////////////////////////////////////////////
	// public $view   = 'Theme';
 //    public $theme = "NewTheme";
	//public $theme = "Cakestrap";
		public $components = array(
			'Session',
			'Auth',
		//'DebugKit.Toolbar',
		//'Security',
			'Apns',
			'C2DM',
			'Esms',
			'SMSNhanh',
			'Chatbox',
			);
		public $helpers = array('Convert');
		public $uses = array('User');
		public $User;
		public $header = array();
////////////////////////////////////////////////////////////

		public function beforeFilter() {
			$this->User = new User;
			Configure::load('header');
			$this->header = Configure::read('header');
		//Load Configurations
			$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false);
			$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => true);
			$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => false);
			$this->Auth->authorize = array('Controller');

			$this->Auth->authenticate = array(
				AuthComponent::ALL => array(
					'userModel' => 'User',
					'fields' => array(
						'username' => 'phonenumber',
						'password' => 'password',
						),
					'scope' => array(
						'User.active' => 1,
						)
					), 'Form'
				);
		## Set User logined to View ##
			if($this->Session->check('Auth.User')) {
				$authUser = $this->Auth->user();
			}
			else{
				$authUser = "";
			}
			$this->set('authUser', $authUser);

		## Load Chatbox ##
			$chatbox = $this->Chatbox->init($authUser);
			$this->set(compact("chatbox"));

		## Load Menu ##
			$this->loadModel("Category");
			$Categories = $this->Category->find("all", array(
				"conditions" => array(
					"parent_id" => 0,
					),
				"order" => array("sort asc"),
				));
			$this->set(compact("Categories"));

			## Load footer ##
			$this->loadModel('News');
			$cliphai = $this->News->getNewsHome(7,6);
			$this->set(compact('cliphai'));
			####################################
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
		#####################################
			if(isset($this->request->params['admin']) && ($this->request->params['prefix'] == 'admin')) {
				if($this->checkPermission() == false) {
					$this->Session->setFlash('Access restricted !!!', 'flash_error');
					$this->redirect(array('controller' => 'users', 'action' => 'error', 'admin' => true));
					return false;
				};
				if($this->Session->check('Auth.User')) {
					$this->set('authUser', $this->Auth->user());
					$loggedin = $this->Session->read('Auth.User');
					$this->set(compact('loggedin'));
					$this->layout = 'admin';
				}

			} elseif(isset($this->request->params['user']) && ($this->request->params['prefix'] == 'user')) {
				if($this->Session->check('Auth.User')) {
					$this->set('authUser', $this->Auth->user());
					$loggedin = $this->Session->read('Auth.User');
					$this->set(compact('loggedin'));
					$this->layout = 'user';
				}
			} elseif($this->request->params['controller'] == 'api') {
				$this->layout = 'api';
				$this->Auth->allow();
			/*CakeLog::write('api-log',"#############################");
			CakeLog::write('api-log',"api name: ".$this->request->params['action']);
			CakeLog::write('api-log',"Date: ".date("H:i:s d-m-Y"));
			$output = print_r($this->request->data,true);
			CakeLog::write('api-log',"Params:".$output);*/
		} elseif($this->request->params['controller'] == 'cronjob') {
			$this->layout = 'cronjob';
			$this->Auth->allow();
			/*CakeLog::write('api-log',"#############################");
			CakeLog::write('api-log',"api name: ".$this->request->params['action']);
			CakeLog::write('api-log',"Date: ".date("H:i:s d-m-Y"));
			$output = print_r($this->request->data,true);
			CakeLog::write('api-log',"Params:".$output);*/
		} 
		else {
			$this->Auth->allow();
		}

	}
	public function beforeRender(){
		$this->set("header", $this->header);
		parent::beforeRender();
	}
////////////////////////////////////////////////////////////
	public function checkPermission() {
		$allow_controller = array("api");
		$allow_action = array("admin_error","login","logout");
		if(in_array($this->request->params['controller'],$allow_controller) || in_array($this->request->params['action'], $allow_action)) {
			return true;
		}
		$logged = $this->Session->read('Auth.User');
		$this->loadModel('User');
		$user = $this->User->find('first',
			array(
				'conditions' => array('User.id' => $logged['id']),
				'recursive' => -1
				)
			);
		if($user != null) {
			$this->loadModel('Action');
			$controller = ucfirst($this->request->params['controller']);
			$action = $this->request->params['action'];
			if(strpos($controller, '_')) {
				$controller = str_replace('_', ' ', $controller);
				$controller = ucwords($controller);
				$controller = str_replace(' ', '', $controller);
			} else {
				//echo 'khong co dau gach duoi <br>';
			}
			$actions = $this->Action->find('first',
				array(
					'conditions' => array(
						'AND' => array(
							'Action.controller' => $controller,
							'Action.action' => $action
							)
						)
					)
				);

			if(!$actions) {
				return false;
			}
			$this->loadModel('Permission');
			$GroupPermissions = $this->Permission->find('first',
				array(
					'conditions' => array(
						'Permission.group_id' => $user['User']['role'],
						'Permission.action_id' => $actions['Action']['id']
						)
					)
				);
			$UserPermissions = $this->Permission->find('first',
				array(
					'conditions' => array(
						'Permission.user_id' => $user['User']['id'],
						'Permission.action_id' => $actions['Action']['id']
						)
					)
				);

			if($UserPermissions) {
				if($UserPermissions['Permission']['state'] == 1) {
					return true;
				} elseif($UserPermissions['Permission']['state'] == -1) {
					return false;
				} else {
					if($GroupPermissions) {
						if($GroupPermissions['Permission']['state'] == 1) {
							return true;
						} else {
							return false;
						}
					} else {
						return false;
					}
				}
			} else {
				if($GroupPermissions) {
					if($GroupPermissions['Permission']['state'] == 1) {
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		} else {
			echo 'chua dang nhap';
		}
	}

////////////////////////////////////////////////////////////

	public function isAuthorized($user) {
		//print_r($user);
		if (($this->params['prefix'] === 'admin') && (!in_array($user['role'],array("1","2")))) {
			echo '<a href="'.Router::url('/', true).'users/logout">Logout</a><br />';
			die('Invalid request for '. $user['role'] . ' user.');
		}
		if (($this->params['prefix'] === 'user') && ($user['role'] != '3')) {
			echo '<a href="'.Router::url('/', true).'users/logout">Logout</a><br />';
			die('Invalid request for '. $user['role'] . ' user.');
		}

		return true;
	}

	protected function send_notifications($user_id, $message, $badge, $sound, $add_data_array)
	{
		App::import('Component', 'Apns');
		$this->loadModel('User');
		$user = $this->User->find('first',
			array(
				'conditions' => array(
					'User.id' => $user_id,
					),
				'fields' => array('User.devtoken', 'User.android_token')
				)
			);
		if (!$badge)
			$badge = 1;
		if ($sound == "") $sound = "default";
		if ($user['User']['devtoken'] != null)
		{
                $this->Apns->payloadMethod = 'simple'; // you can turn on this method for debuggin purpose
                $this->Apns->connectToPush();

                // adding custom variables to the notification
                if (is_array($add_data_array))
                	$this->Apns->setData($add_data_array);


                $send_result = $this->Apns->sendMessage($user['User']['devtoken'], $message, $badge, $sound);

                $this->Apns->disconnectPush();
            }

            if ($user['User']['android_token'] != null)
            {
            	$add_data_array['message'] = $message;
            	$add_data_array['sound'] = $sound;
            	$output = print_r($add_data_array, true);
            	CakeLog::write('api-log',"Params:".$output);
            	$result = $this->C2DM->sendMessage(GOOGLE_API_KEY,array($user['User']['android_token']),$add_data_array);
            	return $result;
            }


        }

        protected function send_sms($phonenumber, $message){
        	$service = Configure::read('Service_Default');
        	if($service == 0){
        		return true;
        	}
        	elseif($service == 1){
        		$BrandName = Configure::read('ESMS_BrandName');
        		$Type = Configure::read('ESMS_Type');
        		$result = $this->Esms->sentSMS($message, $phonenumber,$Type,$BrandName);
        	}
        	elseif($service == 2){
    		//SMS Nhanh
        		$result = $this->SMSNhanh->sentSMS($message,$phonenumber);
        	}
        	if($result['code'] == 1000) return true;
        	else return false;
        }

        public function view_category(){
        	$this->loadModel("ProdCategory");
        	$this->loadModel("Product");
        	$categories = $this->ProdCategory->find("all",
        		array
        		(
        			"order" => array("order DESC")
        			));
        	$this->set(compact("categories"));
        	$product_news = $this->Product->find("all", 
        		array
        		(
        			"order" => array("id DESC"),
        			"limit" => 4
        			));
        	$this->set(compact("product_news"));
        }

////////////////////////////////////////////////////////////
    }
