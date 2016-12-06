<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::import('Controller', 'Notification');


    define('IMAGE_FILE_SIZE_LIMIT', 5242880);
    define('VIDEO_FILE_SIZE_LIMIT', 5242880);
    
    define('AVATAR_UPLOAD_PATH', 'files/avatar/');
    define('IMAGE_PRODUCT_PATH','files/product/images/');
    define('VIDEO_PRODUCT_PATH','files/product/videos/');
    define('IMAGE_PRODUCT_THUMB_PATH','files/product/thumbnail/');
    define('IMAGE_MAXMIUM', 4); //số lượng ảnh tối đa trong 1 product
    define('INVITE_BOUNUE', 5000);
    define('BASE_URL', Router::url('/', true));
    define('MESSAGE_REJECT_OFFER', "% không còn muốn bán sản phẩm cho bạn với giá %VNĐ nữa.");
class ApiController extends AppController {
    protected $state_purchase = array(
        "0" => "request",
        "1" => "accept",
        "2" => "shipping",
        "3" => "waiting rate",
        "4" => "completed",
        "5" => "failed",
        "6" => "reject",

        "12" => "Chờ duyệt",
        "13" => "Đã duyệt",
        "14" => "Đang lấy hàng",
        "15" => "Lấy hàng không thành công",
        "16" => "Đã lấy hàng",
        "17" => "Đang phát hàng",
        "18" => "Phát hàng không thành công",
        "19" => "Đã phát hàng",
        "20" => "Chờ XN chuyển hoàn",
        "21" => "Đang chuyển hoàn",
        "22" => "Hủy đơn hàng",
        );
    protected $messages_sms = array(
        "REGISTER" => "Cảm ơn bạn đã đăng ký tài khoản ở MUBA. Mã số kích hoạt tài khoản của bạn là: ",
        "FORGOT_PASSWORD" => "Bạn vừa yêu cầu MUBA reset mật khẩu. Mã số xác nhận của bạn là: ",
        "WITHDRAW" => "Bạn vừa yêu cầu MUBA chuyển tiền đến tài khoản ngân hàng của bạn, Mã số của bạn là: ",
        );
    protected $home_url_not_allow = array("admin","categories","products","user","page");
    public $uses = array('UserSession','Product');
    public $components = array('RequestHandler', 'Webservice.Webservice', 'Email', 'ImageUploader','FileUploader','BalanceHis','Convert');
    public $helpers = array('Form', 'Html');


    protected $message = array(
        '1000' => 'OK.',
        '9990' => 'Balance is not enough.',
        '9991' => 'Spam.',
        '9992' => 'Product is not existed.',
        '9993' => 'Code verify is incorrect',
        '9994' => 'No Data or end of list data.',
        '9995' => 'User is not validated.',
        '9996' => 'User existed.',
        '9997' => 'Method is invalid.',
        '9998' => 'Token is invalid.',
        '9999' => 'Exception error.',
        '1001' => 'Can not connect to DB.',
        '1002' => 'Parameter is not enough.',
        '1003' => 'Parameter type is invalid.',
        '1004' => 'Parameter value is invalid.',
        '1005' => 'Unknown error.',
        '1006' => 'File size is too big.',
        '1007' => 'Upload File Failed!.',
        '1008' => 'Maximum number of images.',
        '1009' => 'Not access.',
        '1010' => 'action has been done previously by this user.',
        '1011' => 'The product has been sold.',
        '1012' => 'Address does not support Shipping.',
        '1013' => 'Url User\'s is exist.',
        '1014' => 'Promotional code expired.',
    );
    
    protected $body = array(
        'code' => '1000',
        'message' => 'OK',
        'data' => array()
    );

    
    public function beforeFilter() {
        if(isset($this->request->data['token'])){
            $token = $this->request->data['token'];
            $this->loadModel("UserSession");
            $cUser = $this->UserSession->find("first", array("conditions" => array(
                "token" => $token)));
            if($cUser){
                $this->loadModel("UserOnline");
                $this->UserOnline->Create(false);
                $this->UserOnline->save(array(
                    "user_id" => $cUser['UserSession']['login_id'],
                     "modified" => time())
                );
            }
        }
        parent::beforeFilter();
    }
    public function get_verify_signup_code($phonenumber) {
        $this->loadModel('UserActive');
        $c = $this->UserActive->find('first',array(
            'conditions' => array(
                'phonenumber' => $phonenumber)));
        if(!$c){
            echo "eo co";
        }
        else{
            echo $c['UserActive']['code_verify'];
        }
        
        $this->autoRender = false;
        return;
    }

    public function get_verify_forgot_code($phonenumber) {
        $this->loadModel('SmsCode');
        $c = $this->SmsCode->find('first',array(
            'conditions' => array(
                'phonenumber' => $phonenumber)));
        if(!$c){
            echo "eo co";
        }
        else{
            echo $c['SmsCode']['verify_code'];
        }
        
        $this->autoRender = false;
        return;
    }

    public function login() {
        if($this->request->is('post')) {
            $check_items = array('phonenumber', 'password');
            
            if ($this->validate_param($check_items) == false)
                return;

            $post['phonenumber'] = $this->request->data['phonenumber'];
            $post['password'] = $this->request->data['password'];        

            $data['hash'] = $this->Auth->password($post['password']);
            try{
                $check = $this->User->find('first',
                    array(
                        'conditions' => array(
                        'phonenumber' => $post['phonenumber'],
                        'password' => $data['hash'],
                    )
                ));

                $save = array();
                $return = array();
                if($check) {
                    if ($check['User']['active'] == 0)
                        $this->error(9995);
                    else {
                        $save['login_id'] = $check['User']['id'];
                        $save['token'] = $this->Auth->password($post['phonenumber'].date('Y-m-d H:i:s').rand(0,9999));
                        if($check['User']['id']==1){
                            $save['token'] = 1;
                        }
                        $save['registed'] = date('Y-m-d H:i:s');
                        
                        $this->UserSession->deleteAll(array('login_id' => $check['User']['id']));
                        
                        if($this->UserSession->save($save)) {
                            $return['token'] = $save['token'];
                            $return['id'] = $check['User']['id'];
                            $return['username'] = $check['User']['username'];
                            $return['avatar'] = $check['User']['avatar'];
                            $return['active'] = $check['User']['active'];
                            $this->body['data'] = $return;
                            $this->output($this->body);
                        } else {
                            $this->error(1004);
                        }
                    }
                } else {
                    $this->error(1004);

                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        } else
        {
            $this->error(9997);
        }
        
    }

    public function check_password() {
        if($this->request->is('post')) {
            $check_items = array('token', 'password');
            
            if ($this->validate_param($check_items) == false)
                return;

            $post['token'] = $this->request->data['token'];
            $post['password'] = $this->request->data['password'];        

            $post['hash'] = $this->Auth->password($post['password']);
            try{
                $check = $this->UserSession->find('first',
                    array(
                        'conditions' => array(
                        'token' => $post['token'],
                    )
                ));

                $return = array();
                if($check) {
                        $save['login_id'] = $check['UserSession']['login_id'];
                        $cPassword = $this->User->find('first', array(
                            "conditions" => array(
                                "id" => $save['login_id'],
                                "password" => $post['hash'],
                                )));
                        if($cPassword){
                            $return['is_correct'] = 1;
                        }
                        else
                        {
                            $return['is_correct'] = 0;
                        }
                            $this->body['data'] = $return;
                            $this->output($this->body);
                } else {
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        } else
        {
            $this->error(9997);
        }
        
    }

    public function login_admin() {
        if($this->request->is('post')) {
            $check_items = array('phonenumber', 'password');
            
            if ($this->validate_param($check_items) == false)
                return;

            $post['phonenumber'] = $this->request->data['phonenumber'];
            $post['password'] = $this->request->data['password'];        

            $post['hash'] = $this->Auth->password($post['password']);
            try{
                $check = $this->User->find('first',
                    array(
                        'conditions' => array(
                        'phonenumber' => $post['phonenumber'],
                        'password' => $post['hash'],
                        'role' => 'admin',
                    ),
                        "fields" => array("id","username","email","phonenumber","birthday","indentify_card","avatar"),
                ));

                $return = array();
                if($check) {
                       $this->body['data'] = $check['User'];
                       $this->output($this->body);
                       return;
                } else {
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        } else
        {
            $this->error(9997);
        }
        
    }

    public function set_devtoken(){
        if($this->request->is('post')) {
            $check_items = array('token','devtype','devtoken');
            
                if ($this->validate_param($check_items) == false)
                    return;
                try{
                     $this->loadModel("UserSession");
                     $check = $this->UserSession->find("first",array("conditions" => 
                        array("token" => $this->request->data['token']),
                        'contain' => 'User'));
                     if(!$check){
                        $this->error(9998);
                        return;
                     }
                     $this->User->Create(false);
                     $save['id'] = $check['User']['id'];
                     $current_devtoken = "";
                     if($check['User']['devtoken'] !=""){
                        $current_devtoken = $check['User']['devtoken'];
                     }
                     elseif($check['User']['android_token'] !=""){
                        $current_devtoken = $check['User']['android_token'];
                     }
                    if($this->request->data['devtype'] == 1){
                        $save['android_token'] = $this->request->data['devtoken'];
                        $save['devtoken'] = "";
                    }else{
                        $save['devtoken'] = $this->request->data['devtoken'];
                        $save['android_token'] = "";            
                    }
                    //check login from other device
                    if($current_devtoken !="" && $current_devtoken != $this->request->data['devtoken']){
                        $notification_id = $this->set_notification("ohter_device_login",$check['User']['id'], $check['User']['id']);
                        $Notification = new NotificationController;
                        $detail = $Notification->getDetailsNotification($notification_id);
                         $push_info = array(
                            "type" => ($detail['type'] ? $detail['type']: ""),
                            "object_id" => ($detail['object_id'] ? $detail['object_id'] : ""),
                            "avatar" => ($detail['avatar'] ? $detail['avatar'] : ""),
                        );
                        $this->send_notifications($check['User']['id'],$detail['title'],0,$detail['sound'],$push_info);
                    }
                    if($this->User->save($save)){
                        $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }
                     
                } catch (Exception $e) {
                    $message = $e->getMessage();
                    $this->error_detail(9999, $message);
                }
            } else
            {
                $this->error(9997);
            }
    }

    public function login_social () {
        if($this->request->is('post')) {
            $check_items = array('social_id', 'social_token','social_type');
            
            if ($this->validate_param($check_items) == false)
                return;

            $post['social_id'] = $this->request->data['social_id'];
            $post['social_token'] = $this->request->data['social_token'];        
            $post['social_type'] = $this->request->data['social_type'];      
            try{
                $this->loadModel('Social');
                $check = $this->Social->find('first',
                    array(
                        'conditions' => array(
                        'social_id' => $post['social_id'],
                        'social_type' => $post['social_type'],
                        ),
                        'recursive' => 0,
                ));

                $save = array();
                $return = array();
                if($check) {
                    if ($check['User']['active'] == 0)
                        $this->error(9995);
                    else {
                        $save['login_id'] = $check['User']['id'];
                        $save['token'] = $this->Auth->password($post['social_id'].date('Y-m-d H:i:s'));
                        $save['registed'] = date('Y-m-d H:i:s');
                        $this->UserSession->deleteAll(array('login_id' => $check['User']['id']));
                        if($this->UserSession->save($save)) {
                            $this->Social->Create(false);
                            $this->Social->id = $check['Social']['id'];
                            $this->Social->saveField('social_token',$post['social_token']);
                            $return['token'] = $save['token'];
                            $return['id'] = $check['User']['id'];
                            $return['username'] = $check['User']['username'];
                            $return['avatar'] = $check['User']['avatar'];
                            $this->body['data'] = $return;
                            $this->output($this->body);
                        } else {
                            $this->error(1004);
                        }
                    }
                } else {
                    $this->error(1004);

                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        } else
        {
            $this->error(9997);
        }
        
    }

    public function logout () {
        if($this->request->is('post')) {
            $check_items = array('token');
            
            if ($this->validate_param($check_items) == false)
               return;

            try{
                $this->loadModel('UserSession');
                $User = $this->UserSession->find("first",array("conditions" => 
                    array("token" => $this->request->data['token']),
                    ));
                if($this->UserSession->deleteAll(array('token' => $this->request->data['token']))) {
                    if($User){
                        $this->User->Create(false);
                        $this->User->id = $User['UserSession']['login_id'];
                        $this->User->saveField("devtoken","");
                        $this->User->saveField("android_token","");
                    }
                    $this->output($this->body);
                } else {
                    $this->error(1004);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        } else
        {
            $this->error(9997);
        }
        
    }

    public function signup() {
        if ($this->request->is('post')) {
            $check_items = array('phonenumber', 'password');
            $allow_items = array(
                'string'    => array('phonenumber', 'password'),);

            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            if ($this->validate_param($check_items) == false)
                return;

            try{
                $check = $this->User->find('first',
                    array(
                        'conditions' => array(
                        'phonenumber' => $data['phonenumber'],

                    )
                )
                );

                if($check) {
                    if($check['User']['active'] != 0)
                    {
                        $this->error(9996);
                        return;
                    }
                    else{
                         $save['username'] = "No name";
                        $save['password'] = $data['password'];
                        $this->User->id = $check['User']['id'];
                        if($this->User->save($save)){
                           $this->resend_sms_verify($data['phonenumber']);
                           $this->output($this->body);
                           return;
                        }
                        else {
                            $this->error(1004);
                        }
                    }
                }
                $save = array();
                $save['role'] = 'user';
                $save['phonenumber'] = $data['phonenumber'];
                $save['password'] = $data['password'];
                $save['username'] = "No name";
                do{
                    $save['invite_code'] = $this->getToken(6);
                    $kt = $this->User->find('first',array('conditions' => array(
                        'invite_code' => $save['invite_code'])));
                }
                while($kt);
                $save['active'] = false;
                
                $this->User->Create(false);
                if ($this->User->save($save)) {
                    ######################
                    $code_verify = rand(1000,9999);
                    $save_active['phonenumber'] = $save['phonenumber'];
                    $save_active['code_verify'] = $code_verify;
                    $this->loadModel('UserActive');
                    $this->UserActive->save($save_active);
                    //send sms here
                    $this->send_sms( $save['phonenumber'],$this->messages_sms['REGISTER'].$code_verify);
                    $this->output($this->body);   
                } else {
                    $this->error(1004);
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        } else
        {
            $this->error(9997);
        }
    }

    public function get_invite_code(){
         if($this->request->is('post')) {
            $check_items = array('token');
          $allow_items = array(
                'string'    => array('token'),
                    );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),
                                'recursive' =>0,      
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $this->body['data']['invite_code'] = $check['User']['invite_code'];
                $this->output($this->body);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

   public function create_code_reset_password(){
         if($this->request->is('post')) {
            $check_items = array('phonenumber');
          $allow_items = array(
                'string'    => array('phonenumber'),
                    );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->User->find('first', array(
                                'conditions' => array('phonenumber' => $data['phonenumber']),
                                
                ));
                if(!$check){
                    $this->error(1004);
                    return;
                }
                $this->loadModel('SmsCode');
                $check_reset_code = $this->SmsCode->find('first',array(
                    'conditions' => array(
                        'phonenumber' => $data['phonenumber'],)));

                if($check_reset_code && time() - strtotime($check_reset_code['SmsCode']['modified']) < 300){
                    $this->error(9991);
                    return;
                }
                $reset_code = rand(1000,9999);
                $save = array('phonenumber' => $data['phonenumber'],
                                'verify_code' => $reset_code);
                if($check_reset_code)
                {
                    $save['id'] = $check_reset_code['SmsCode']['id'];
                }
                else{
                    $save['phonenumber'] = $data['phonenumber'];
                }
                if($this->SmsCode->save($save)){
                    #####
                    ##### SEND SMS HERE ###############
                    $this->send_sms( $save['phonenumber'],$this->messages_sms['FORGOT_PASSWORD'].$reset_code);
                    $this->output($this->body);
                    return;
                }
                $this->error(1005);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function check_code_reset_password(){
         if($this->request->is('post')) {
            $check_items = array('phonenumber','reset_code');
          $allow_items = array(
                'string'    => array('phonenumber'),
                'numberic' => array(
                    '>0' => array('reset_code')),
                    );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->User->find('first', array(
                                'conditions' => array('phonenumber' => $data['phonenumber']),
                                
                ));
                if(!$check){
                    $this->error(1004);
                    return;
                }
                $this->loadModel('SmsCode');
                $check_reset_code = $this->SmsCode->find('first',array(
                    'conditions' => array("verify_code" => $data['reset_code'],
                                    "phonenumber" => $data['phonenumber'],
                                    "type" => 0)));

                if(!$check_reset_code){
                    $this->error(9993);
                    return;
                }
                $this->SmsCode->Create(false);
                $this->SmsCode->id = $check_reset_code['SmsCode']['id'];
                if($this->SmsCode->saveField('is_verified','1')){
                    $this->output($this->body);
                    return;
                }
                
                $this->error(1005);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function reset_password(){
        if($this->request->is('post')) {
            $check_items = array('phonenumber','password','devtoken');
          $allow_items = array(
                'string'    => array('phonenumber','password','devtoken'),
                    );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->User->find('first', array(
                                'conditions' => array('phonenumber' => $data['phonenumber']),
                                
                ));
                if(!$check){
                    $this->error(1004);
                    return;
                }
                $this->loadModel('SmsCode');
                $check_reset_verified = $this->SmsCode->find('first',array(
                    'conditions' => array(
                        'phonenumber' => $data['phonenumber'],
                        'is_verified' => 1)));

                if(!$check_reset_verified){
                    $this->error(1009);
                    return;
                }
                $this->SmsCode->Create(false);
                $this->SmsCode->id = $check_reset_verified['SmsCode']['id'];

                $this->User->Create(false);
                $this->User->id = $check['User']['id'];

                $this->SmsCode->begin();
                if($this->SmsCode->delete() && $this->User->saveField('password',$data['password'])){
                    $this->SmsCode->commit();
                    //login
                    $this->login();
                    $this->output($this->body);
                    return;
                }

                $this->SmsCode->rollback();
                $this->error(1005);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }
    public function sms_verify(){
        if($this->request->is('post')) {
            $check_items = array('phonenumber', 'code_verify');
            
            if ($this->validate_param($check_items) == false)
                return;
            try{
                $check = $this->User->find('first', array(
                                'conditions' => array('phonenumber' => $this->request->data['phonenumber'],
                                    'active' => 0),
                ));
                if($check){
                    $this->loadModel('UserActive');
                    $verify = $this->UserActive->find('first', array(
                                'conditions' => array('phonenumber' => $this->request->data['phonenumber'],
                                    'code_verify' => $this->request->data['code_verify'],
                                ),
                    ));
                    if($verify){
                        $this->User->Create(false);
                        $this->User->id = $check['User']['id'];
                        $this->User->saveField('active',1);
                        $this->UserActive->deleteAll(array('UserActive.phonenumber' => $this->request->data['phonenumber']));
                       
                        $this->output($this->body); 
                    }
                    else{
                        $this->error(9993);
                    }
                }
                else{
                    $this->error(1004);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function resend_sms_verify($phonenumber = null){
        if($this->request->is('post') || $phonenumber !=null) {
            if($phonenumber !=null) $this->request->data['phonenumber'] = $phonenumber;
            $check_items = array('phonenumber');
            
            if ($this->validate_param($check_items) == false)
                return;
            try{
                $check = $this->User->find('first', array(
                                'conditions' => array('User.phonenumber' => $this->request->data['phonenumber'],
                                    'active' => 0),
                                'recursive' => 0
                ));
                if($check){
                    
                    $code_verify = rand(1000,9999);
                    $this->loadModel('UserActive');
                    $save = array('code_verify' =>$code_verify,
                        'phonenumber' => $this->request->data['phonenumber']);
                    $UserActive = $this->UserActive->find("first", array(
                        "conditions" => array(
                            "phonenumber" => $this->request->data['phonenumber'])));
                    $this->UserActive->Create(false);
                   
                    if($UserActive){
                        $save['id'] = $UserActive['UserActive']['id'];
                    }
                    $this->UserActive->save($save);
                    $this->output($this->body);
                    //send sms
                    $this->send_sms( $save['phonenumber'],$this->messages_sms['REGISTER'].$code_verify);
                }
                else{
                    $this->error(1004);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function change_info_after_signup(){
        if($this->request->is('post')) {
            $check_items = array('token','username');
            $allow_items = array(
                'string'    => array('token','username','invite_code'),
            );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
           try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                if(isset($data['invite_code'])){
                   $user_invited = $this->User->find('first',array(
                    'conditions' => array(
                        'invite_code' => $data['invite_code'],
                        )));
                   if(!$user_invited){
                        $this->error(1004);
                        return;
                   }
                }

                $this->User->Create(false);
                $this->User->id = $check['User']['id'];
                $data['username'] = trim($data['username']);
                $user_url = $this->Convert->vn_str_filter(str_replace(".","", $data['username'])).".".$check['User']['id'];
                $save = array("active" => 1,
                            "username" => $data['username'],
                            "url" => $user_url,
                            "invited_by_id" => isset($user_invited['User']['id'])? $user_invited['User']['id']: null,);
                if($this->User->save($save)){
                    if(isset($data['invite_code'])){
                        $this->set_balance($user_invited['User']['id'], INVITE_BOUNUE, "invite_friend", $check['User']['id']);
                    }
                    if(isset($this->request['form']['avatar'])){
                            $this->set_user_info();
                    }
                    $this->output($this->body);
                    return;
                }
                $this->error(1005);
                return;
    
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function get_categories(){
        if($this->request->is('post')) {
           try{
            $conditions = array();
            $this->loadModel('Category');
                if(isset($this->request->data['parent_id'])){
                    $parent_id = $this->request->data['parent_id'];
                    if($parent_id==''){
                        $parent_id = 0;
                    }
                    elseif(!is_numeric($parent_id)){
                        $this->error(1003);
                        return;
                    }
                    else{
                        $category = $this->Category->find('first', array(
                                    'conditions' => array('id' => $parent_id),
                        ));
                        if(!$category && $parent_id!=0){
                            $this->error(1004);
                            return;
                        }
                        else{
                            $conditions = array('parent_id' => $parent_id);
                        }
                    }
                }

                $category = $this->Category->find('all',array('conditions'=>$conditions,
                            'order' => array('parent_id ASC','sort ASC')));
                if($category){

                    $categories =  Set::extract('/Category/.',$category);
                    $this->loadModel("BrandCategory");
                    $this->loadModel("ProductSizeCategory");
                    //check category has child?
                    foreach ($categories as $key => $category) {
                        //check has childen
                        $has_child = $this->Category->find("first",array("conditions" => array(
                            'parent_id' => $category['id'])));
                        if($has_child){
                            $categories[$key]["has_child"] = "1"; 
                        }
                        else{
                            $categories[$key]["has_child"] = "0";
                        }
                        //check has Brand in Category
                        $has_Brand = $this->BrandCategory->find("first",array("conditions" => array(
                            'category_id' => $category['id'])));
                        if($has_Brand){
                            $categories[$key]["has_brand"] = "1"; 
                        }
                        else{
                            $categories[$key]["has_brand"] = "0";
                        }
                        //check has Size in Category
                        $has_Size = $this->ProductSizeCategory->find("first",array("conditions" => array(
                            'category_id' => $category['id'])));
                        if($has_Size){
                            $categories[$key]["has_size"] = "1"; 
                        }
                        else{
                            $categories[$key]["has_size"] = "0";
                        }
                    }
                    $this->body['data'] = $categories;
                    $this->output($this->body);
                }
                else
                {
                    $this->error(9994);
                    return; 
                }
                            
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function get_list_products(){
        if($this->request->is('post')) {
            $this->loadModel('Category');
            $check_items = array('index', 'count');
            $allow_items = array(
                'numberic'  => array(
                    '>=0' => array('count','category_id'),
                    '>=0' => array('index'),
                    ),
            );
            //require image list phia duoi
           if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $index = $this->request->data['index'];
                $count = $this->request->data['count'];
                
                if(isset($this->request->data['category_id'])){
                    $category_id =$this->request->data['category_id'];
                    if($category_id==''){
                        $category_id = 0;
                    }
                    elseif(!is_numeric($category_id)){
                        $this->error(1003);
                        return;
                    }
                    elseif($category_id < 0){
                        $this->error(1004);
                        return;
                    }
                }
                else
                {
                    $category_id = 0;
                }
                $listid = $this->Category->findChild($category_id);
                $listid[] = $category_id;
                $this->loadModel("UserSetting");
                $vacation_user = $this->UserSetting->find("list", array(
                    "conditions" => array("vacation_mode" => '1'),
                    "fields" => array("user_id"),
                ));
                $this->loadModel('Product');
              
                $check = $this->Product->find('all', array(
                                'conditions' => array(
                                    'category_id' => $listid,
                                    'is_deleted' => 0,
                                    'is_sold' => 0,
                                    "NOT" => array("seller_id" => $vacation_user,),
                                   ),
                                'offset' => $index,
                                'limit' => $count,
                                'order' => 'Product.created DESC',
                                'recursive' => 0,        
                ));
                
               $this->loadModel('ProductLike');
                $this->loadModel('ProductComment');
                $this->loadModel('ProductOtherImage');
                $userid=0;
                if(isset($this->request->data['token']) && $this->request->data['token']!=''){
                    $user = $this->UserSession->find('first',array('conditions' => array(
                        'token' => $this->request->data['token'])));
                    if($user)
                        $userid = $user['UserSession']['login_id'];
                    else{
                            $this->error(9998);
                            return;
                        }
                }

                if($check){
                    $data = array();
                    $key=0;
                    $this->loadModel("Purchase");
                    foreach ($check as $i => $value) {
                        $data[$key]['id'] = $value['Product']['id'];
                        $data[$key]['name'] = $value['Product']['name'];
                        $data[$key]['price'] = $value['Product']['price'];
                        $data[$key]['price_new'] = $value['Product']['price_new'];
                        if($data[$key]['price_new'] != 0){
                            $data[$key]['price_percent'] = (100- (ceil($data[$key]['price'] / $data[$key]['price_new'] * 100)))."%";
                        }
                        else{
                            $data[$key]['price_percent'] = "0%";
                        }
                        $data[$key]['brand'] = (isset($value['Brand']['brand_name'])? $value['Brand']['brand_name']: "");
                        $data[$key]['created'] = $value['Product']['created'];
                        $data[$key]['described'] = $value['Product']['described'];
                        if($value['Product']['video']){
                            $data[$key]['video']['url'] = $value['Product']['video'];
                            $data[$key]['video']['thumb'] = "";
                            $imgs = $this->ProductOtherImage->find('first',array('conditions'=>array(
                            'product_id' => $data[$key]['id'])));
                            if($imgs)
                                $data[$key]['video']['thumb'] = $imgs['ProductOtherImage']['image'];
                        

                        }
                        else{
                            $imgs = $this->ProductOtherImage->find('all',array('conditions'=>array(
                            'product_id' => $data[$key]['id'])));
                            if($imgs)
                               {
                                foreach ($imgs as $img) {
                                    $data[$key]['image'][] = $img['ProductOtherImage']['image'];
                                }
                               }
                            else{
                                $data[$key]['image'] = "";

                            }
                        }

                        $data[$key]['like'] = $this->ProductLike->find('count',array(
                                    'conditions' => array('product_id' => $data[$key]['id'])))."";
                        $data[$key]['comment'] = $this->ProductComment->find('count',array(
                                    'conditions' => array('product_id' => $data[$key]['id'])))."";
                        
                        $data[$key]['is_liked'] = ($this->ProductLike->find('first',array('conditions'=> array(
                            'product_id' => $data[$key]['id'],
                            'user_id' => $userid)))? "1":"0");
                        $this->loadModel("UserBlock");
                        $data[$key]['is_blocked'] = ($this->UserBlock->find('first',array('conditions'=> array(
                                            'user_id' => $value['User']['id'],
                                            'blocked_id' => $userid)))? "1":"0");
                        $list_bought_product = $this->Purchase->find("list",array(
                            "conditions" => array("product_id" => $value['Product']['id'],
                                                    "state >=" => 0,
                                                    "state <=" => 4),
                            "fields" => array("buyer_id")));
                    
                        $data[$key]['can_edit'] = ($userid == $value['Product']['seller_id'] && !$this->Purchase->find('first',array('conditions'=> 
                                            array('product_id' => $value['Product']['id'],
                                                    'state >' => 0,
                                                    'state <=' => 4 ))));
                        $data[$key]['is_sold'] = $value['Product']['is_sold'];
                        $data[$key]['seller'] = array(
                        'id' => $value['User']['id'],
                        'username' => $value['User']['username'],
                        'avatar' => $value['User']['avatar'],
                        );

                        $seller_setting = $this->_get_user_setting($value['Product']['seller_id']);
                        $WaitRate = false;
                        $cWaitRate = $this->Purchase->find("all", array(
                            "conditions" => array(
                         //       "Purchase.buyer_rated" => 0,
                                "Purchase.state" => 3,
                                "Purchase.buyer_id" => $userid,
                                )));
                        $this->loadModel("UserRate");
                        foreach ($cWaitRate as $rate) {
                            $cRated = $this->UserRate->find("first", array(
                                "conditions" => array("purchase_id" => $rate['Purchase']['id'],
                                    "rater_id" => $userid)));
                            if(!$cRated){
                                $WaitRate = $rate;
                                break;
                            }
                        }
                        if($userid == 0){
                                $data[$key]['can_buy'] = -4; // chua login
                        }
                        elseif($userid == $value['Product']['seller_id']){
                                $data[$key]['can_buy'] = -1; // khong the mua chinh minh
                        }
                        elseif($WaitRate){
                                $data[$key]['product_waiting_rate'] = $WaitRate['Purchase']['product_id'];
                                $data[$key]['can_buy'] = -3; // phải rate sản phẩm
                        }
                        elseif($seller_setting['vacation_mode']==1){
                                $data[$key]['can_buy'] = -2; // seller nghi ban
                        }
                        elseif(in_array($userid, $list_bought_product)){
                            $cState = $this->Purchase->find("first", array("conditions" => array(
                                "product_id" => $value['Product']['id'],
                                "buyer_id" => $userid)));
                            if($cState['Purchase']['state'] >= 1){
                                $data[$key]['can_buy'] = 0; // da mua
                            }
                            else{
                                $data[$key]['can_buy'] = 2;
                            }
                        }
                        else{
                                $data[$key]['can_buy'] = 1;
                        }
                        $key++;
                    }
                   
                    $this->body['data'] = $data;
                    $this->output($this->body);
                }
                else{
                    $this->error(9994);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function get_products(){

         if($this->request->is('post')) {
            $check_items = array('id');
            
            if ($this->validate_param($check_items) == false)
                return;
            try{
                $id = $this->request->data['id'];
                if(!is_numeric($id))
                {
                    $this->error(1003);
                    return;
                }

                $check = $this->Product->find('first', array(
                                'conditions' => array(
                                    'Product.id' => $id,
                                    'Product.is_deleted' => 0),
                                'recursive' => 1,
                                
                ));
                if($check){
                    $userid=0;
                    if(isset($this->request->data['token']) && $this->request->data['token']!=""){
                       
                        $user = $this->UserSession->find('first',array('conditions' => array(
                            'token' => $this->request->data['token'])));
                        if($user)
                            $userid = $user['UserSession']['login_id'];
                        else{
                            $this->error(9998);
                            return;
                        }
                    }
                    $category = $check['Category'];
                    $ret_category[] = array(
                        "id" => $category['id'],
                        "name" => $category['name']);
                    $this->loadModel('Category');
                    while($category['parent_id']!=0){
                        $parent = $this->Category->read(null,$category['parent_id']);
                        $category = $parent['Category'];
                         $ret_category[] = array(
                            "id" => $category['id'],
                            "name" => $category['name']); 
                    }
                    $ret_category = array_reverse($ret_category);

                    $this->loadModel('ProductLike');
                    $this->loadModel('Purchase');
                    $this->loadModel('UserBlock');
                    $list_bought_product = $this->Purchase->find("list",array(
                        "conditions" => array("product_id" => $check['Product']['id'],
                                                "state >=" => 0,
                                                "state <=" => 4),
                        "fields" => array("buyer_id")));
                    
                    $seller_setting = $this->_get_user_setting($check['Product']['seller_id']);
                  $data = array(
                        'id' => $check['Product']['id'],
                        'name' => $check['Product']['name'],
                        'price' => $check['Product']['price'],
                        'price_new' => $check['Product']['price_new'],
                        'price_percent' => ($check['Product']['price_new'] >0 ? (100 - ceil($check['Product']['price'] / $check['Product']['price_new'] * 100))."%" : "0%"),
                        'described' => $check['Product']['described'],
                        'ships_from' => $check['Product']['ships_from'],
                        'ships_from_id' => (isset($check['Product']['ships_from_id']) ? json_decode($check['Product']['ships_from_id']) :""),
                        'condition' => $check['Product']['condition'],
                        'created' => $check['Product']['created'],
                        'modified' => $check['Product']['modified'],
                        'like' => count($check['ProductLike'])."",
                        'comment' => count($check['ProductComment'])."",
                        'size' => array('id' => isset($check['ProductSize']['id']) ? $check['ProductSize']['id']:"0",
                                        'size_name' => isset($check['ProductSize']['id']) ? $check['ProductSize']['size_name']: ""),
                        'brand' => array('id' => isset($check['Brand']['id'])? $check['Brand']['id']: "0",
                                        'brand_name' =>isset($check['Brand']['id']) ? $check['Brand']['brand_name']: ""),
                        'seller' => array('id' => $check['User']['id'],
                                        'name' =>$check['User']['username'],
                                        'avatar' =>($check['User']['avatar']==null?"":$check['User']['avatar']),
                                        'score' =>$this->User->rate($check['User']['id']),
                                        'listing' =>$this->User->numProduct($check['User']['id']),),
                        'category' => $ret_category,
                        'is_liked' => ($this->ProductLike->find('first',array('conditions'=> array(
                                            'product_id' => $check['Product']['id'],
                                            'user_id' => $userid)))? "1":"0"),
                        'is_sold' => ($this->Purchase->find('first',array('conditions'=> array(
                                            'product_id' => $check['Product']['id'],
                                            'state' => 4)))? "1":"0"),
                        'is_blocked' => ($this->UserBlock->find('first',array('conditions'=> array(
                                            'user_id' => $check['Product']['seller_id'],
                                            'blocked_id' => $userid)))? "1":"0"),
                        'can_edit' => ($userid == $check['Product']['seller_id'] && !$this->Purchase->find('first',array('conditions'=> 
                                            array('product_id' => $check['Product']['id'],
                                                    'state >' => 0,
                                                    'state <=' => 4 )))),
                        'url' => Router::url( array("controller" => "products","action" => "details"),true )."/".str_replace(".", "-", $this->Convert->vn_str_filter($check['Product']['name']))."-".$check['Product']['id'].".html",
                        );

                    ########## check can_buy status ############################
                    $WaitRate = false;
                    $cWaitRate = $this->Purchase->find("all", array(
                            "conditions" => array(
                                
                                "Purchase.state" => 3,
                                "Purchase.buyer_id" => $userid,
                                )));
                    $this->loadModel("UserRate");
                   
                    foreach ($cWaitRate as $rate) {
                            $cRated = $this->UserRate->find("first", array(
                                "conditions" => array("purchase_id" => $rate['Purchase']['id'],
                                    "rater_id" => $userid)));
                            if(!$cRated){
                                $WaitRate = $rate;
                                break;
                            }
                        }
                    if($userid == 0){
                             $data['can_buy'] = -4; // chưa login
                    }
                    elseif($userid == $check['Product']['seller_id']){
                                $data['can_buy'] = -1; // khong the mua chinh minh
                    }
                    elseif($WaitRate){
                            $data['product_waiting_rate'] = $WaitRate['Purchase']['product_id'];
                            $data['can_buy'] = -3; // phải rate sản phẩm
                    }
                    elseif($seller_setting['vacation_mode']==1){
                            $data['can_buy'] = -2; // seller nghi ban
                    }
                    elseif(in_array($userid, $list_bought_product)){
                        $cState = $this->Purchase->find("first", array("conditions" => array(
                            "product_id" => $check['Product']['id'],
                            "buyer_id" => $userid)));
                        if($cState['Purchase']['state'] >= 1){
                            $data['can_buy'] = 0; // da mua
                        }
                        else{
                            $data['can_buy'] = 2;
                        }
                    }
                    else{
                            $data['can_buy'] = 1;
                    }
                    
                    //get best offers
                    $this->loadModel("Purchase");
                    $best_offers = $this->Purchase->find("all", array("conditions" => array(
                        'product_id' => $check['Product']['id'],
                        'state <=' => 4),
                        'fields' => array("MAX(offers) as best_offers"),
                        ));

                    $data['best_offers'] = $best_offers[0][0]["best_offers"];
                    if($data['best_offers']=="") $data['best_offers'] = 0;

                    //get gia da offer truoc do neu co
                    $this->loadModel("PurchaseAcceptOffer");
                    $cAcceptOffer = $this->PurchaseAcceptOffer->find("first", array(
                        "conditions" => array(
                            "product_id" => $check['Product']['id'],
                           // "buyer_id" => $userid
                            )
                        ));
                    if($cAcceptOffer && ($userid == $check['Product']['seller_id'] || $userid == $cAcceptOffer['PurchaseAcceptOffer']['buyer_id'])){
                        $data['offers'] = $cAcceptOffer['PurchaseAcceptOffer']['offers'];
                    }
                    else{
                        $data['offers'] = 0;
                    }
                    if(!$check['Product']['video']){
                        foreach ($check['ProductOtherImage'] as $key =>  $value) {
                            $data['image'][$key]['id'] = $value['id'];

                            $data['image'][$key]['url'] = str_replace(IMAGE_PRODUCT_THUMB_PATH,IMAGE_PRODUCT_PATH,$value['image']);
                        }
                    }
                    else{
                        if(isset($check['ProductOtherImage'][0]['image'])) $thumb = $check['ProductOtherImage'][0]['image'];
                        else $thumb = "";
                        $data['video']['thumb'] = str_replace(IMAGE_PRODUCT_THUMB_PATH,IMAGE_PRODUCT_PATH,$thumb);
                        $data['video']['url'] = $check['Product']['video'];
                    }
                    
                    $this->body['data'] = $data;
                    $this->output($this->body);
                }
                else{
                    $this->error(9992);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }                           

    public function add_products(){
        if($this->request->is('post')) {
            $check_items = array('token', 'name','price','ships_from','ships_from_id','category_id','condition');
            $allow_items = array(
                'string' => array('token','name','described','ships_from','condition'),
                'numberic'  => array(
                    '>0' => array('price','price_new','category_id','product_size_id','brand_id'),
                    ),
                'array' => array('ships_from_id'));
            //require image list phia duoi
           if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),
                                'recursive' => 0,
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $data['seller_id'] = $check['User']['id'];
                if(!is_array($data['ships_from_id']) && count($data['ships_from_id']) < 3){
                    $this->error(1004);
                    return;
                }
                if(!$this->ShipChung->checkShipFromSupport($data['ships_from_id'])){
                    $this->error(1012);
                    return;
                }

                $data['ships_from_id'] = json_encode($data['ships_from_id']);
                $this->loadModel("Product");
                /*$cExist = $this->Product->find("first",array("conditions" => array(
                    'name like' => '%'.$data['name'].'%',
                    'seller_id' => $data['seller_id']
                    )));
                if($cExist){
                    $this->error(1010);
                    return;
                }*/
                $this->loadModel('ProductSizeCategory');
                $this->loadModel('BrandCategory');
                if(isset($data['product_size_id'])){
                    $check = $this->ProductSizeCategory->find('first',array('conditions' => array(
                    'product_size_id' => $data['product_size_id'],
                    'category_id' => $data['category_id'])));
                    if(!$check){
                        $this->error(1004);
                        return;
                    }
                }
                
                if(isset($data['brand_id'])){
                    $check = $this->BrandCategory->find('first',array('conditions' => array(
                    'brand_id' => $data['brand_id'],
                    'category_id' => $data['category_id'])));
                    if(!$check){
                        $this->error(1004);
                        return;
                    }
                }
                

                
                if (isset($this->request['form']['video']) && ($this->request['form']['video']['error'] != 4)) {
                        if(!isset($this->request['form']['thumb'])){
                            $this->error(1002);
                            return;
                        }
                        $file = $this->request['form']['video'];

                        if ($file['size'] > VIDEO_FILE_SIZE_LIMIT)
                        {
                            $this->error(1011);
                            return;
                        }


                        //print_r($file);
                        $ext = $this->get_file_ext($file['name']);
                        if(strtoupper($ext) !==".MP4")
                        {
                            $this->error(1004);
                            return;
                        }

                        $file['name'] = md5($file['name'].time().rand(0,99999)).$ext; 
                        $this->FileUploader->create_destination(TRUE);
                        $this->FileUploader->setDestination(VIDEO_PRODUCT_PATH);
                        $this->FileUploader->upload($file, VIDEO_PRODUCT_PATH);
                        $data['video'] = Router::url('/', true).$this->FileUploader->getDestination().$this->FileUploader->getFilename();
                   
                    ///upload thumbnail video
                    $url_image = array();
                    $file = $this->request['form']['thumb'];
                    if($file['error'] != 4){
                        if ($file['size'] > IMAGE_FILE_SIZE_LIMIT)
                        {
                            $this->error(1006);
                            return;
                        }
                        $fileDestination = IMAGE_PRODUCT_PATH;
                         $options = array(
                            'max_width'=>600,
                            'max_height' => 600,
                            'thumbnail' => array('max_width'=> 300 ,'max_height' => 300,'path' => IMAGE_PRODUCT_THUMB_PATH));  
                       
                        $ext = $this->get_file_ext($file['name']);
                        $file['name'] = md5($data['name'].time().rand(0,99999)).$ext; 
                        try{
                            $output = $this->ImageUploader->upload($file,$fileDestination,$options);
                        }catch(Exception $e){
                                $message = $e->getMessage();
                                $this->error_detail(9999, $message);
                        }
                        if ($output['bool'] == 1)
                        {
                            $url_image[] = $output['thumb_path'];
                        } else 
                        {
                            $this->error(1007);
                            return;
                            
                        }
                    }
                    else
                    {
                        $this->error(1004);
                        return;
                    }

                        
                }
                elseif(isset($this->request['form']['image'])){
                    $image = $this->request['form']['image'];
                    $n = count($image['name']);
                    if($n > IMAGE_MAXMIUM){
                        $this->error(1008);
                        return;
                    }
                    $url_image = array();
                   for($i=0; $i< $n; $i++){
                        $file['name'] = $image['name'][$i];
                        $file['size'] = $image['size'][$i];
                        $file['type'] = $image['size'][$i];
                        $file['tmp_name'] = $image['tmp_name'][$i];
                        $file['error'] = $image['error'][$i];
                        if($file['error'] != 4){
                            if ($file['size'] > IMAGE_FILE_SIZE_LIMIT)
                            {
                                $this->error(1006);
                                return;
                            }
                            $fileDestination = IMAGE_PRODUCT_PATH;
                         $options = array(
                            'max_width'=>600,
                            'max_height' => 600,
                            'thumbnail' => array('max_width'=> 300 ,'max_height' => 300,'path' => IMAGE_PRODUCT_THUMB_PATH));  
                           
                            $ext = $this->get_file_ext($file['name']);
                            $file['name'] = md5($data['name'].time().rand(0,99999)).$ext; 
                            try{
                                $output = $this->ImageUploader->upload($file,$fileDestination,$options);
                            }catch(Exception $e){
                                    $message = $e->getMessage();
                                    $this->error_detail(9999, $message);
                            }
                            if ($output['bool'] == 1)
                            {
                                $url_image[] = $output['thumb_path'];
                            } else 
                            {
                                $this->error(1007);
                                return;
                                
                            }
                        }
                        else
                        {
                            $this->error(1007);
                            return;
                        }
                    }
                    if(count($url_image) <= 0){
                        $this->error(1002);
                        return;
                    }
                }
                
                if($this->Product->save($data)){
                    $id = $this->Product->id;
                    if(count($url_image)){
                        $this->loadModel('ProductOtherImage');
                        foreach ($url_image as $value) {
                            $data1['product_id'] = $id;
                            $data1['image'] = $value;
                            $this->ProductOtherImage->Create(false);
                            $this->ProductOtherImage->save($data1);
                        }
                    }
                   // $notification_id = $this->set_notification("add_products",$id, $check['UserSession']['login_id']);
                            
                    //push
                    $Notification = new NotificationController;
                    $this->loadModel("UserFollow");
                    $list_userid = $this->UserFollow->find("list",array(
                        "conditions" => array(
                            "followee_id" => $data['seller_id']),
                        "fields" => array("follower_id")));
                    foreach ($list_userid as $key => $uid) {
                        $notification_id = $this->set_notification("add_products",$id, $uid);
                    }
                    if(isset($notification_id)){
                        $this->push_notification($notification_id,$list_userid);
                    }
                    $ret = array(
                        'id' => $id,
                        'url' => Router::url( array("controller" => "products","action" => "details"),true )."/".str_replace(".", "-", $this->Convert->vn_str_filter($data['name']))."-".$id.".html",
                    );
                    $this->body['data'] = $ret;
                    $this->output($this->body);
                }
                else{
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9998);
        }
    }

    public function edit_products(){
          if($this->request->is('post')) {
            $check_items = array('token','id', 'name','price','category_id');
            //require image list phia duoi
           if ($this->validate_param($check_items) == false)
                return;
            try{
                $data = $this->request->data;
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),
                                'recursive' => 0,
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }

                if(!is_numeric($data['price']) || !is_numeric($data['category_id'])
                    || !is_numeric($data['id'])){
                    $this->error(1003);
                    return;
                }

                $Product = $this->Product->find('first',array("conditions"=>array(
                    'Product.id' => $data['id']),
                    'Product.is_deleted' => 0,
                'recursive' => 0));
                if(!$Product){
                    $this->error(9992);
                    return;
                }

                if($Product['Product']['seller_id']!=$check['User']['id']){
                    $this->error(1009);
                    return;
                }

                if(!is_array($data['ships_from_id']) && count($data['ships_from_id']) < 3){
                    $this->error(1004);
                    return;
                }
                
                if(!$this->ShipChung->checkShipFromSupport($data['ships_from_id'])){
                    $this->error(1012);
                    return;
                }
                $data['ships_from_id'] = json_encode($data['ships_from_id']);

                $this->loadModel('ProductSizeCategory');
                $this->loadModel('BrandCategory');
                if(isset($data['product_size_id']) && $data['product_size_id']!=""){
                    $check = $this->ProductSizeCategory->find('first',array('conditions' => array(
                    'product_size_id' => $data['product_size_id'],
                    'category_id' => $data['category_id'])));
                    if(!$check){
                        $this->error(1004);
                        return;
                    }
                }
                else{
                    $data['product_size_id'] ="";
                }
                if(isset($data['brand_id']) && $data['brand_id'] !=""){
                    $check = $this->BrandCategory->find('first',array('conditions' => array(
                        'brand_id' => $data['brand_id'],
                        'category_id' => $data['category_id'])));
                    if(!$check){
                        $this->error(1004);
                        return;
                    }
                }
                else{
                    $data['brand_id'] = "";
                }

                if(isset($data['price_new']) && !is_numeric($data['price_new'])){
                    $this->error(1004);
                    return;
                }
               
                 $this->loadModel('ProductOtherImage');

                $img_del = array();
  
                    if(isset($data['image_del'])){
                        $img_del = array_filter($data['image_del']);
                        $conditions['id'] = $img_del;
                    
                          $c =  $this->ProductOtherImage->find('count',array(
                            'conditions'=> array("product_id" => $data['id'],
                                                'id' => $img_del),
                            ));
                            if($c < count($img_del)){
                                $this->error(1009);
                                return;
                            }
                    }
         
                $url_image = array();
                if (isset($this->request['form']['video']) && ($this->request['form']['video']['error'] != 4)) {
                        $file = $this->request['form']['video'];

                        if ($file['size'] > VIDEO_FILE_SIZE_LIMIT)
                        {
                            $this->error(1011);
                            return;
                        }


                        //print_r($file);
                        $ext = $this->get_file_ext($file['name']);
                        if(strtoupper($ext) !==".MP4")
                        {
                            $this->error(1004);
                            return;
                        }

                        $file['name'] = md5($file['name'].time().rand(0,99999)).$ext; 
                        $this->FileUploader->create_destination(TRUE);
                        $this->FileUploader->setDestination(VIDEO_PRODUCT_PATH);
                        $this->FileUploader->upload($file, VIDEO_PRODUCT_PATH);
                        $data['video'] = Router::url('/', true).$this->FileUploader->getDestination().$this->FileUploader->getFilename();

                        ///upload thumbnail video
                        //delete last thumbnail
                         $this->ProductOtherImage->deleteAll(array("product_id" => $data['id']));
                        $url_image = array();
                        $file = $this->request['form']['thumb'];
                        if($file['error'] != 4){
                            if ($file['size'] > IMAGE_FILE_SIZE_LIMIT)
                            {
                                $this->error(1006);
                                return;
                            }
                            $fileDestination = IMAGE_PRODUCT_PATH;
                             $options = array(
                                'max_width'=>600,
                                'max_height' => 600,
                                'thumbnail' => array('max_width'=> 300 ,'max_height' => 300,'path' => IMAGE_PRODUCT_THUMB_PATH));  
                           
                            $ext = $this->get_file_ext($file['name']);
                            $file['name'] = md5($data['name'].time().rand(0,99999)).$ext; 
                            try{
                                $output = $this->ImageUploader->upload($file,$fileDestination,$options);
                            }catch(Exception $e){
                                    $message = $e->getMessage();
                                    $this->error_detail(9999, $message);
                            }
                            if ($output['bool'] == 1)
                            {
                                $url_image[] = $output['thumb_path'];
                            } else 
                            {
                                $this->error(1007);
                                return;
                                
                            }
                        }
                        else
                        {
                            $this->error(1004);
                            return;
                        }
                        
                        
                }
                elseif(isset($this->request['form']['image']))
                {
                    //delete if change from video to image
                    if($Product['Product']['video']!=""){
                        $data['video'] = "";
                        $this->ProductOtherImage->deleteAll(array("product_id" => $data['id']));
                    }
                    $count_old_img = $this->ProductOtherImage->find('count',array('conditions' =>array(
                        'product_id' => $data['id'])));
                    $image = $this->request['form']['image'];
                    $n = count($image['name']);
                    if($n + $count_old_img - count($img_del) > IMAGE_MAXMIUM){
                        $this->error(1008);
                        return;
                    }
                   for($i=0; $i< $n; $i++){
                        $file['name'] = $image['name'][$i];
                        $file['size'] = $image['size'][$i];
                        $file['type'] = $image['size'][$i];
                        $file['tmp_name'] = $image['tmp_name'][$i];
                        $file['error'] = $image['error'][$i];
                        if($file['error'] != 4){
                            if ($file['size'] > IMAGE_FILE_SIZE_LIMIT)
                            {
                                $this->error(1006);
                                return;
                            }
                            $fileDestination = IMAGE_PRODUCT_PATH;
                            $options = array(
                                'max_width'=>512,
                                'max_height' => 512,
                                'thumbnail' => array('max_width'=> 100 ,'max_height' => 100,'path' => IMAGE_PRODUCT_THUMB_PATH)); 

                            $ext = $this->get_file_ext($file['name']);
                            $file['name'] = md5($data['name'].time().rand(0,99999)).$ext; 
                            try{
                                $output = $this->ImageUploader->upload($file,$fileDestination,$options);
                            }catch(Exception $e){
                                    $message = $e->getMessage();
                                    $this->error_detail(9999, $message);
                            }
                            if ($output['bool'] == 1)
                            {
                                $url_image[] = $output['thumb_path'];
                            } else 
                            {
                                $this->error(1007);
                                return;
                            }
                        }
                        else
                        {
                            $this->error(1007);
                            return;
                        }
                    }
                    if(count($url_image) <= 0){
                        $this->error(1002);
                        return;
                    }
                }
                
                
                if($img_del)
                foreach ($img_del as $id) {
                    $this->ProductOtherImage->Create(false);
                    $this->ProductOtherImage->id = $id;
                    $this->ProductOtherImage->delete();
                }
                
                if($this->Product->save($data)){

                    if($url_image)
                        foreach ($url_image as $value) {

                            $data1['product_id'] = $data['id'];
                            $data1['image'] = $value;
                            $this->ProductOtherImage->Create(false);
                            $this->ProductOtherImage->save($data1);
                        }
                    $this->loadModel("Purchase");
                    $list_buyer = $this->Purchase->find("list", array(
                        "conditions" => array(
                            "product_id" => $data['id']),
                        "fields" => array("buyer_id"),
                        ));
                   
                    foreach ($list_buyer as $key => $uid) {
                        $notification_id = $this->set_notification("edit_products",$data['id'], $uid);
                    }
                    if(isset($notification_id)){
                        $this->push_notification($notification_id,$list_buyer);
                    }
                    $this->output($this->body);
                }
                else{
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9998);
        }
    }

    public function del_products(){
        if($this->request->is('post')) {
            $check_items = array('token', 'id');
            
            if ($this->validate_param($check_items) == false)
                return;
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $this->request->data['token']),
                                'recursive' => 0,
                ));
                if($check){
                    $Product = $this->Product->find('first',array("conditions"=>array(
                        'Product.id' => $this->request->data['id'],
                        'is_deleted' => '0'),
                    ));

                    if(!$Product){
                            $this->error(9992);
                            return;
                        }
                    if($Product['Product']['seller_id']!=$check['User']['id']){
                        $this->error(1009);
                        return;
                    }
                    $this->Product->id = $this->request->data['id'];
                    if($this->Product->saveField('is_deleted','1')){
                        $this->loadModel("Purchase");
                        $PurchaseFailed = $this->Purchase->find("all",array(
                            "conditions" => array("product_id" => $this->request->data['id'],
                                                "Purchase.state <=" => 2)));
                        foreach ($PurchaseFailed as $key => $purchase) {
                            $this->Purchase->Create(false);
                            $this->Purchase->id = $purchase['Purchase']['id'];
                            $this->Purchase->saveField("state",6);
                            if($purchase['Purchase']['pay_type'] == 2){
                                $this->set_balance($purchase['Purchase']['buyer_id'],$purchase['Purchase']['offers'] + $purchase['Purchase']['ship_fee'], "buy_product_failed", $purchase['Purchase']['id']);
                            }
                            $notification_id = $this->set_notification("reject_buyer",$purchase['Purchase']['id'],$purchase['Purchase']['buyer_id']);
                            $list_user_push = $purchase['Purchase']['buyer_id'];
                            if(isset($notification_id)){
                                $this->push_notification($notification_id,$list_user_push);
                            }
                        }
                        
                        $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }

                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function like_products(){
        if($this->request->is('post')) {
            $check_items = array('token', 'id');
            
            if ($this->validate_param($check_items) == false)
                return;
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $this->request->data['token'])
                ));
                if($check){
                    $Product = $this->Product->find('first',array("conditions"=>array(
                        'Product.id' => $this->request->data['id'],
                        'is_deleted' => '0'),
                    ));

                    if(!$Product){
                            $this->error(9992);
                            return;
                    }
                    $this->loadModel('ProductLike');
                    $this->ProductLike->Create(false);
                    $this->ProductLike->set('product_id',$this->request->data['id']);
                    $this->ProductLike->set('user_id',$check['UserSession']['login_id']);
                   if($this->ProductLike->exists()){
                        if($this->ProductLike->delete()){
                            $this->loadModel('NotificationUser');
                            $notifi_user = $this->NotificationUser->find('first',array('conditions' =>array(
                                'Notification.type' => "like_products",
                                'Notification.object_id' => $this->request->data['id'],
                                'NotificationUser.user_id' => $check['UserSession']['login_id']),
                            'recursive' => 0));
                            if($notifi_user && $notifi_user['NotificationUser']['user_id'] != $Product['Product']['seller_id']){
                                $this->NotificationUser->Create(false);
                                $this->NotificationUser->id = $notifi_user['NotificationUser']['id'];
                                $this->NotificationUser->delete();
                            }
                            $this->loadModel("ProductComment");
                            $user_comented = $this->ProductComment->find("first", array(
                                "conditions" => array(
                                    "product_id" => $this->request->data['id'],
                                    "poster_id" => $check['UserSession']['login_id']
                                    )));
                            if(!$user_comented){
                                $notifi_user = $this->NotificationUser->find('first',array('conditions' =>array(
                                    'Notification.type' => "comment_products",
                                    'Notification.object_id' => $this->request->data['id'],
                                    'NotificationUser.user_id' => $check['UserSession']['login_id']),
                                'recursive' => 0));
                                if($notifi_user){
                                    $this->NotificationUser->Create(false);
                                    $this->NotificationUser->id = $notifi_user['NotificationUser']['id'];
                                    $this->NotificationUser->delete();
                                }
                            }
                            $like = $this->ProductLike->find("count",array("conditions" => array(
                                'product_id' => $this->request->data['id'])));
                            $this->body['data']['like'] = $like;
                            $this->output($this->body);
                            return;
                        }
                    }
                    else{
                        $is_not_first = $this->ProductLike->find("first", array("conditions" => array(
                                "product_id" => $this->request->data['id'])));
                        if(!$is_not_first){
                            $notification_id = $this->set_notification("like_products",$this->request->data['id'], $Product['Product']['seller_id']);
                        }

                        if($this->ProductLike->save()){
                            $notification_id = $this->set_notification("like_products",$this->request->data['id'], $check['UserSession']['login_id']);

                            //push
                            /*$Notification = new NotificationController;
                            $list_userid_like = $Notification->getListUserByNotificationID($notification_id,$check['UserSession']['login_id']);
                            $list_userid_comment = $Notification->getListUserByNotificationConditions(array("type" => "comment_products","object_id" => $this->request->data['id']), $check['UserSession']['login_id']);
                            foreach ($list_userid_comment as $key => $value) {
                                if(!in_array($value, $list_userid_like)){
                                    $notification_id = $this->set_notification("like_products",$this->request->data['id'], $value);
                                }
                            }
                            //get lai de loai bo nhung nguoi tat push setting
                            $list_userid = $Notification->getListUserByNotificationID($notification_id,$check['UserSession']['login_id']);
                           */

                            // $this->push_notification($notification_id,$list_userid);
                             $this->push_notification($notification_id,$Product['Product']['seller_id']);
                             $like = $this->ProductLike->find("count",array("conditions" => array(
                                'product_id' => $this->request->data['id'])));
                             $this->body['data']['like'] = $like;
                             $this->output($this->body);
                            return;
                        }
                    }
                    $this->error(1004);
                    return;
                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }                             

    public function buy_products(){
        if($this->request->is('post')) {
            $check_items = array('token','id','firstname','lastname','address','address_id','pay_type');
          $allow_items = array(
                'string'    => array('token','firstname','lastname','address','city','promotion_code'),
                'numberic'  => array(
                    '>0' => array('id','pay_type','offers'),
                    '<=2' => array('pay_type'),
                    ),
                'array' => array('address_id'));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),
                                'recursive' => 0,      
                ));
                if($check){
                    $this->loadModel('Purchase');
                    $this->Purchase->Create(false);
                    $this->Purchase->set('product_id',$data['id']);
                    $this->Purchase->set('buyer_id',$check['UserSession']['login_id']);

                    //kiem tra user da mua san pham hay chua
                    $cPurchase = $this->Purchase->find("first",array(
                        "conditions" => array(
                            'product_id' => $data['id'],
                            'buyer_id' => $check['UserSession']['login_id'])));

                    if($cPurchase && $cPurchase['Purchase']['state'] <= 4){
                        $this->error(1010);
                        return;
                    }
                    //kiem tra ton tai cua san pham
                    $cproduct = $this->Product->find('first',array('conditions' => array(
                        'id' => $data['id'],
                        'is_deleted' => 0)));
                    if(!$cproduct){
                        $this->error(9992);
                        return;
                    }

                    //kiem tra user có waiting rate hay không
                    $WaitRate = false;
                        $cWaitRate = $this->Purchase->find("all", array(
                            "conditions" => array(
                         //       "Purchase.buyer_rated" => 0,
                                "Purchase.state" => 3,
                                "Purchase.buyer_id" => $check['UserSession']['login_id'],
                                )));
                        $this->loadModel("UserRate");
                        foreach ($cWaitRate as $rate) {
                            $cRated = $this->UserRate->find("first", array(
                                "conditions" => array("purchase_id" => $rate['Purchase']['id'],
                                    "rater_id" => $check['UserSession']['login_id'])));
                            if(!$cRated){
                                $this->error(1009);
                                return;
                            }
                        }
                    //save data
                    $save = $data;
                    $save['address_id'] = json_encode($data['address_id']);
                    $save['product_id'] = $data['id'];
                    $save['buyer_id'] = $check['UserSession']['login_id'];
                    $save['state'] = "0";
                    unset($save['id']);
                    if(!isset($save['offers'])) $save['offers'] = $cproduct['Product']['price'];
                    if($data['pay_type'] == 2 && $check['User']['balance'] < $save['offers']){
                        $this->error(9990);
                        return;
                    }
                    //check neu da ton tai giao dich va giao dich bị fail thi reset state.
                    if($cPurchase){
                        $save['state'] = 0;
                        $this->Purchase->id = $cPurchase['Purchase']['id'];
                        $save['created'] = date("Y-m-d H:i:s");
                    }
                    ################################################
                    //check da offers trước đó hay chưa. nếu có rồi thì offer = gia offer da thong nhat
                    $this->loadModel("PurchaseAcceptOffer");
                    $cAcceptOffer = $this->PurchaseAcceptOffer->find("first", array(
                        "conditions" => array(
                            "product_id" => $save['product_id'],
                            "buyer_id" => $save['buyer_id'],
                            "approve" => "1",
                            ),
                        ));
                    if($cAcceptOffer){
                        /*//get lastest offers, kiem tra xem nguoi mua co phai nguoi tra gia cuoi cung khong,
                        //neu gia gia cuoi cung thì set state = 1 (accept) neu khong thi state = 0 (request)
                        $cLastOffers = $this->PurchaseAcceptOffer->find("first", array(
                            "conditions" => array(
                                "product_id" => $save['product_id'],
                                "approve" => array("1","3"), // lay tat ca offer đã đồng ý
                            ),
                            "order" => array("modified DESC")));
                        if($cLastOffers['PurchaseAcceptOffer']['id'] == $cAcceptOffer['PurchaseAcceptOffer']['id']){
                            $save['state'] = 1;
                        }*/
                        $save['state'] = 1;
                        
                        $save['offers'] = $cAcceptOffer['PurchaseAcceptOffer']['offers'];
                    }
                    ########################################
                    //get ship fee
                    $data_getShipFee = array(
                        "city_id" => $data['address_id'][0],
                        "province_id" => $data['address_id'][1],
                        "ward_id" => $data['address_id'][2],
                        "offers" => $save['offers'],
                        );
                    if($data['pay_type'] == 2){
                        $config_Ship = array(
                            "CoD" => 2,
                            "Payment" => 1,
                            );
                    }
                    else{
                        $config_Ship = array(
                            "CoD" => 1,
                            "Payment" => 2,
                            );
                    }
                    $shipFee = $this->ShipChung->getShipFee($save['product_id'],$data_getShipFee, $config_Ship);
                    $save['ship_fee'] = $shipFee['totalFee'];

                    ####################check ma khuyen mai#####################
                    $discount = 0;
                    if(isset($data['promotion_code']) && $data['promotion_code'] !=""){
                        $this->loadModel("PromotionCategory");
                        $cPromotion = $this->PromotionCategory->find("first", array(
                            "conditions" => array(
                                "code" => $data['promotion_code'],
                                "approve" => 1,
                                "PromotionCategory.category_id" => $cproduct['Product']['category_id']),
                            "contain" => array("Promotion")));
                        if(!$cPromotion){
                            $this->error(1004);
                            return;
                        }
                        if(($cPromotion['Promotion']['quantity'] > 0 && $cPromotion['Promotion']['used'] == $cPromotion['Promotion']['quantity']) || $cPromotion['Promotion']['endtime'] < date("Y-m-d H:i:s")){
                            $this->error(1014);
                            return;
                        }
                        $save['promotion_id'] = $cPromotion['Promotion']['id'];
                        $discount = $cPromotion['Promotion']['discount'];
                        //tang bien dem ma khuyen mai
                        $this->loadModel("Promotion");
                        $this->Promotion->UpdateAll(array("Promotion.used" => "Promotion.used + 1"), array("id" => $save['promotion_id']));
                    }
                    #########################################

                    $this->Purchase->Create(false);
                    if($this->Purchase->save($save)){
                        $id = $this->Purchase->id;
                        if($data['pay_type'] == 2){
                            $this->set_balance($save['buyer_id'], -($save['offers'] + $save['ship_fee'] - $discount), "buy_product", $id);
                        }
                        
                        //save state history
                        //delete state history lan giao dich fail truoc
                        $this->loadModel("PurchaseStatusHistory");
                        $this->PurchaseStatusHistory->deleteAll(array("purchase_id" => $id));
                        $this->save_history_purchase($id,0);
                        if($cAcceptOffer){
                            if($save['state'] == 1){
                                $this->save_history_purchase($id,1);
                            }
                            //delete offer da su dung
                            $this->PurchaseAcceptOffer->delete($cAcceptOffer['PurchaseAcceptOffer']['id']);
                        }
                        $notification_id  = $this->set_notification("buy_products", $id, $cproduct['Product']['seller_id']);
                        
                        //push
                        $this->push_notification($notification_id,$cproduct['Product']['seller_id']);
                        $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }
                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }
    public function set_offers(){
        if($this->request->is('post')) {
            $check_items = array('token','product_id','offers');
            $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>0' => array('product_id','offers'),
                    ),
            );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),
                                'recursive' => -1,      
                ));
                if($check){
                    $this->loadModel("Product");
                    $cProduct = $this->Product->read(null,$data['product_id']);
                    if(!$cProduct){
                        $this->error(9992);
                        return;
                    }
                    
                    $this->loadModel("Purchase");
                    $cState = $this->Purchase->find("first", array("conditions" => array(
                        "product_id" => $data['product_id'],
                        "state <=" => 4,
                        "state >" => 1)));
                    if($cState){
                        $this->error(1009);
                        return;
                    }
                    
                    $this->loadModel("PurchaseAcceptOffer");
                    $cExistAcceptOffters = $this->PurchaseAcceptOffer->find("first", array(
                        "conditions" => array(
                            "product_id" => $data['product_id'],
                            "buyer_id" => $check['UserSession']['login_id'],
                            "approve !=" => 1)));

                    unset($data['token']);
                    $data['approve'] = 0;
                    $data['buyer_id'] = $check['UserSession']['login_id'];
                    $this->PurchaseAcceptOffer->Create(false);
                    if($cExistAcceptOffters){
                        $this->PurchaseAcceptOffer->id = $cExistAcceptOffters['PurchaseAcceptOffer']['id'];
                    }
                    if($this->PurchaseAcceptOffer->save($data)){
                        $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }

                }
                else{
                    $this->error(9998);
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function accept_offers(){
        if($this->request->is('post')) {
            $check_items = array('token','product_id','buyer_id',"is_accept");
            $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>0' => array('product_id','buyer_id'),
                    '>=0' => array('is_accept'),
                    '<=1' => array('is_accept'),
                    ),
            );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),
                                'recursive' => 0,      
                ));
                if($check){
                    $this->loadModel("Product");
                    $cProduct = $this->Product->read(null,$data['product_id']);
                    if(!$cProduct){
                        $this->error(9992);
                        return;
                    }
                    if($cProduct['Product']['seller_id'] != $check['UserSession']['login_id']){
                        $this->error(1009);
                        return;
                    }
                    
                    $this->loadModel("PurchaseAcceptOffer");
                    $AcceptOffters = $this->PurchaseAcceptOffer->find("first", array(
                        "conditions" => array(
                            "product_id" => $data['product_id'],
                            "buyer_id" => $data['buyer_id'],
                            "approve" => "0")));
                    if(!$AcceptOffters){
                        $this->error(1004);
                        return;
                    }

                    //neu tu choi thi xoa offer, neu dong y thi phai check dieu kien tiep
                    if($data['is_accept'] == 0){
                        $this->PurchaseAcceptOffer->Create(false);
                        if($this->PurchaseAcceptOffer->delete($AcceptOffters['PurchaseAcceptOffer']['id'])){
                            $this->output($this->body);
                            return;
                        }
                        else{
                            $this->error(1005);
                            return;
                        }
                    }

                    //kiem tra trạng thai san pham truoc khi dong y
                    $this->loadModel("Purchase");
                    $cState = $this->Purchase->find("first", array("conditions" => array(
                        "product_id" => $data['product_id'],
                        "state <=" => 4,
                        "state >" => 1)));
                    if($cState){
                        $this->error(1009);
                        return;
                    }

                    #################################################
                    //huy tat ca cac giao dich da accept truoc do.
                    $purchases = $this->Purchase->find("all", array(
                        "conditions" => array(
                            "product_id" => $data['product_id'],
                            "state" => 1,
                            "buyer_id !=" => $data['buyer_id'])));
                    foreach ($purchases as $key => $purchase) {
                        $this->Purchase->Create(false);
                        $this->Purchase->id = $purchase['Purchase']['id'];
                        $this->Purchase->saveField("state",6);
                        
                        if($purchase['Purchase']['pay_type'] == 2){
                                $this->set_balance($purchase['Purchase']['buyer_id'],$purchase['Purchase']['offers'] + $purchase['Purchase']['ship_fee'], "buy_product_failed", $purchase['Purchase']['id']);
                        }
                        // set & push notification
                        $notification_id = $this->set_notification("reject_buyer",$purchase['Purchase']['id'],$purchase['Purchase']['buyer_id']);
                        $list_user_push = $purchase['Purchase']['buyer_id'];
                        if(isset($notification_id)){
                            $this->push_notification($notification_id,$list_user_push);
                        }
                        //save state history
                        //$this->save_history_purchase($purchase['Purchase']['id'],6);
                    }
                    
                    //update state in purchase to fail
                    $this->Purchase->UpdateAll(
                        array("state" => 6),
                        array(
                            "product_id" => $data['product_id'],
                            "state" => 1,
                            "buyer_id !=" => $data['buyer_id']));
                    #########################
                    //huy tat ca cac accept offer truoc do cua san pham
                    $AcceptFail = $this->PurchaseAcceptOffer->find("first", array(
                        "conditions" => array(
                            "product_id" => $data['product_id'],
                            "approve" => "1")));
                    if($AcceptFail){
                        //sent message to conversation
                        $message = array(
                            "product_id" => $data['product_id'],
                            "user_id" => $AcceptFail['PurchaseAcceptOffer']['buyer_id'],
                            "sender_name" => $check['User']['username'],
                            "sender_id" => $check['User']['id'],
                            "message" => sprintf(MESSAGE_REJECT_OFFER,$username,$AcceptFail['PurchaseAcceptOffer']['offers']),
                        );
                        $this->sentMessageToConversation($message);
                        $this->PurchaseAcceptOffer->delete($AcceptFail['PurchaseAcceptOffer']['id']);
                    }
                   

                    unset($data['token']);

                    //kiem tra da ton tai giao dich chua, neu ton tai roi thi update gia offer vao giao dich luon
                    $cExist = $this->Purchase->find("first", array(
                        "conditions" => array(
                            "buyer_id" => $data['buyer_id'],
                            "product_id" => $data['product_id'])));

                    if($cExist){
                        $this->Purchase->Create(false);
                        $this->Purchase->id = $cExist['Purchase']['id'];
                        if($this->Purchase->save(array("offers" => $AcceptOffters['PurchaseAcceptOffer']['offers'],"state" => 1))){

                            //tinh toan lai so tien can tra lai cho nguoi mua
                            if($cExist['Purchase']['pay_type'] == 2){
                                $oldOffer = $cExist['Purchase']['offers'];
                                $need_banlance = $AcceptOffters['PurchaseAcceptOffer']['offers'] - $oldOffer;
                                $this->set_balance($data['buyer_id'], -$need_banlance, "buy_product_edit", $cExist['Purchase']['id']);    
                            }
                            //delete offer da su dung
                            $this->PurchaseAcceptOffer->delete($AcceptOffters['PurchaseAcceptOffer']['id']);
                            $this->output($this->body);
                            return;
                        }
                        $this->error(1005);
                        return;

                    }
                    else{
                        $this->PurchaseAcceptOffer->Create(false);
                        $this->PurchaseAcceptOffer->id = $AcceptOffters['PurchaseAcceptOffer']['id'];
                        $this->PurchaseAcceptOffer->deleteAll(array(
                            "buyer_id" => $data['buyer_id'],
                            "product_id" => $data['product_id'],
                            "approve" => "1"));
                        if($this->PurchaseAcceptOffer->saveField("approve","1")){
                            $this->output($this->body);
                            return;
                        }
                        else{
                            $this->error(1004);
                            return;
                        }
                    }

                }
                else{
                    $this->error(9998);
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }
    public function get_purchase(){
        if($this->request->is('post')) {
            $check_items = array('token','product_id');
          $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>0' => array('product_id'),
                    ));

            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),      
                ));
                if($check){
                    $this->loadModel("Purchase");
                    $cPurchase = $this->Purchase->find('first',array('conditions' => array(
                        'product_id' => $data['product_id'],
                        'buyer_id' => $check['UserSession']['login_id'],
                        ),
                        "fields" => array("id","created","modified","pay_type","firstname","lastname","address","address_id","city","offers","promotion_id"),
                        ));
                    if(!$cPurchase){
                        $this->error(1004);
                        return;
                    }
                    $return = Set::extract('/Purchase/.',$cPurchase);
                    if(isset($return[0]['address_id'])){
                        $return[0]['address_id'] = json_decode($return[0]['address_id']);
                        $data_getShipFee = array(
                            "city_id" => $return[0]['address_id'][0],
                            "province_id" => $return[0]['address_id'][1],
                            "ward_id" => $return[0]['address_id'][2],
                            "offers" => $return[0]['offers'],
                            );
                        if($return[0]['pay_type'] == 2){
                            $config_Ship = array(
                                "CoD" => 2,
                                "Payment" => 1,
                                );
                        }
                        else{
                            $config_Ship = array(
                                "CoD" => 1,
                                "Payment" => 2,
                                );
                        }
                        $ShipFee = $this->ShipChung->getShipFee($data['product_id'],$data_getShipFee, $config_Ship);
                        $return[0] = array_merge($return[0], $ShipFee);
                        ###################check khuyen mai #############################
                        $return[0]['promotion'] = array(
                                    "id" => "",
                                    "code" => "",
                                    "discount" => "0",
                                    );
                        if($return[0]['promotion_id'] > 0){
                            $this->loadModel("Promotion");
                            $cPromotion = $this->Promotion->find("first", array(
                                "conditions" => array(
                                    "id" => $return[0]['promotion_id'])));
                            if($cPromotion){
                                $return[0]['promotion'] = array(
                                    "id" => $cPromotion['Promotion']['id'],
                                    "code" => $cPromotion['Promotion']['code'],
                                    "discount" => $cPromotion['Promotion']['discount'],
                                    );
                            }
                        }
                        unset($return[0]['promotion_id']);
                    }
                    else{
                       $this->error(1004);
                       return;
                    }
                    $this->body['data'] = $return;
                   $this->output($this->body);
                   return;
                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function edit_purchase(){
        if($this->request->is('post')) {
            $check_items = array('token','id','firstname','lastname','address','address_id','pay_type');
          $allow_items = array(
                'string'    => array('token','firstname','lastname','address',"promotion_code"),
                'numberic'  => array(
                    '>0' => array('id','offers','pay_type'),
                    '<=2' => array('pay_type'),
                    ),
                'array' => array('address_id'));

            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),
                                'recursive' => 0      
                ));
                if($check){
                    $this->loadModel("Purchase");
                    $cPurchase = $this->Purchase->read(null,$data['id']);
                    if(!$cPurchase){
                        $this->error(1004);
                        return;
                    }

                    if($cPurchase['Purchase']['buyer_id'] != $check['UserSession']['login_id']){
                        $this->error(1009);
                        return;
                    }
                    if($cPurchase['Purchase']['state'] > 0){
                        $this->error(1009);
                        return;
                    }
                    $offers = (isset($data['offers']) ? $data['offers']: $cPurchase['Purchase']['offers']);
                    $data_getShipFee = array(
                        "city_id" => $data['address_id'][0],
                        "province_id" => $data['address_id'][1],
                        "ward_id" => $data['address_id'][2],
                        "offers" => $offers,
                        );
                    if($data['pay_type'] == 2){
                        $config_Ship = array(
                            "CoD" => 2,
                            "Payment" => 1,
                            );
                    }
                    else{
                        $config_Ship = array(
                            "CoD" => 1,
                            "Payment" => 2,
                            );
                    }
                    $shipFee = $this->ShipChung->getShipFee($cPurchase['Purchase']['product_id'],$data_getShipFee, $config_Ship);
                    
                    $this->Purchase->id = $cPurchase['Purchase']['id'];
                    $save = array(
                        "firstname" => $data['firstname'],
                        "lastname" => $data['lastname'],
                        "address" => $data['address'],
                        "address_id" => json_encode($data['address_id']),
                       // "city" => $data['city'],
                        "pay_type" => $data['pay_type'],
                        "ship_fee" => $shipFee['totalFee'],
                        );
                     $cProduct = $this->Product->find("first", array("conditions" => array(
                            "id" => $cPurchase['Purchase']['product_id'])));
                    if(isset($data['offers'])){
                        $save['offers'] = $data['offers'];
                    }
                    else
                    {
                        $save['offers'] = $cProduct['Product']['price'];
                    }

                    ####################check ma khuyen mai#####################
                    $this->loadModel("Promotion");
                    $cPromotion = $this->Promotion->read(null,$cPurchase['Purchase']['promotion_id']);
                    if(!$cPromotion){
                        $cPromotion['Promotion']['code'] = "";
                        $oldDiscount = 0;
                    }
                    else{
                        $oldDiscount = $cPromotion['Promotion']['discount'];
                    }
                    $newDiscount = $oldDiscount;
                    if(isset($data['promotion_code']) && $data['promotion_code'] !="" && $data['promotion_code'] != $cPromotion['Promotion']['code']){
                        $this->loadModel("PromotionCategory");
                        $cPromotion = $this->PromotionCategory->find("first", array(
                            "conditions" => array(
                                "code" => $data['promotion_code'],
                                "approve" => 1,
                                "PromotionCategory.category_id" => $cProduct['Product']['category_id']),
                            "contain" => array("Promotion")));
                        if(!$cPromotion){
                            $this->error(1004);
                            return;
                        }
                        if(($cPromotion['Promotion']['quantity'] > 0 && $cPromotion['Promotion']['used'] == $cPromotion['Promotion']['quantity']) || $cPromotion['Promotion']['endtime'] < date("Y-m-d H:i:s")){
                            $this->error(1014);
                            return;
                        }
                        $save['promotion_id'] = $cPromotion['Promotion']['id'];
                        $newDiscount = $cPromotion['Promotion']['discount'];
                        //tang bien dem su dung ma khuyen mai
                        $this->Promotion->UpdateAll(array("Promotion.used" => 'Promotion.used+1'), array("id" => $save['promotion_id']));
                    }
                    #########################################

                    $need_banlance = 0;
                    if($data['pay_type'] == 2){
                        if($cPurchase['Purchase']['pay_type'] ==1)
                            $cur_paid = 0;
                        else
                            $cur_paid = $cPurchase['Purchase']['offers'] + $cPurchase['Purchase']['ship_fee'] - $oldDiscount;

                        $need_banlance = ($save['offers'] + $save['ship_fee'] - $newDiscount) - $cur_paid;
                        if($check['User']['balance'] < $need_banlance){
                            $this->error(9990);
                            return;
                        }
                    }
                    else{
                        if($cPurchase['Purchase']['pay_type'] == 2){
                            // doi tu thanh toan the sang thanh toan tien mat, phai tra lai cho nguoi dung so tien da thu lan truoc
                            $need_banlance = -($cPurchase['Purchase']['offers'] + $cPurchase['Purchase']['ship_fee'] - $oldDiscount);
                        }
                    }
                    if($this->Purchase->save($save)){
                        if($need_banlance != 0){
                            $this->set_balance($check['UserSession']['login_id'], -$need_banlance, "buy_product_edit", $cPurchase['Purchase']['id']);
                        }
                       
                        $notification_id  = $this->set_notification("buy_products_edit",$cPurchase['Purchase']['id'], $cProduct['Product']['seller_id']);
                        //push
                        $this->push_notification($notification_id,$cProduct['Product']['seller_id']);
                        $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }
                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }
    

    public function get_list_buyer_products(){
        if($this->request->is('post')) {
            $check_items = array('token','product_id', 'index','count');
          $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>=0' => array('index'),
                    '>0' => array('count','product_id'),
                    ));

            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),      
                ));
                if($check){
                    $cproduct = $this->Product->find('first',array('conditions' => array(
                        'id' => $data['product_id'],
                        'Product.seller_id' => $check['UserSession']['login_id'],
                        'is_deleted' => 0)));
                    if(!$cproduct){
                        $this->error(9992);
                        return;
                    }
                   /* if($cproduct['Product']['is_completed']){
                        $this->error(1011);
                        return;
                    }*/

                    $this->loadModel('Purchase');
                    $list = $this->Purchase->find('all',array('conditions' =>array(
                        'product_id' => $data['product_id'],
                        'verify' => 1,
                        'state <=' => 4
                        ),
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'fields' => array('product_id','buyer_id','firstname','lastname','pay_type','city','created','modified','state','offers'),
                    'order' => 'Purchase.created DESC',
                    'recursive' => 0,
                    ));
                    if(!$list){
                        $this->error(9994);
                        return;
                    }

                    $data = Set::extract('/Purchase/.',$list);
                    $state = 0;
                    foreach ($data as $key => $value) {
                        if($value['state'] ==0)
                            $data[$key]['is_accept'] = 0;
                        else
                            $data[$key]['is_accept'] = 1;
                        
                        $buyer = $this->User->read(null,$value['buyer_id']);
                        $data[$key]['avatar'] = $buyer['User']['avatar'];
                        $all_purchase = $this->Purchase->find("count",array("conditions" => array(
                            'buyer_id' => $value['buyer_id'],
                            'state <' => '6',
                            )));
                        $susccess_purchase = $this->Purchase->find("count",array("conditions" => array(
                            'buyer_id' => $value['buyer_id'],
                            'state' => '4'
                            )));
                        $data[$key]['per_purchase_suscess'] = $susccess_purchase."/".$all_purchase;
                        if($value['state'] > $state){
                            $state = $value['state'];
                        }
                        unset($data[$key]['state']);
                    }
                    $this->body['data']['list_buyer'] = $data;
                    $this->body['data']['state'] = $this->state_purchase[$state];

                   $this->output($this->body);
                   return;
                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function set_accept_buyer(){
        if($this->request->is('post')) {
            $check_items = array('token', 'product_id','buyer_id','is_accept');
            
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>0' => array('buyer_id','product_id'),
                    '>=0' => array('is_accept'),
                    '<=1' => array('is_accept'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;

            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token'])
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $cproduct = $this->Product->find('first',array('conditions' => array(
                    'id' => $data['product_id'],
                    'is_deleted' => 0,
                    )));
                if(!$cproduct){
                    $this->error(9992);
                    return; 
                }
                if($cproduct['Product']['seller_id']!=$check['UserSession']['login_id']){
                    $this->error(1009);
                    return;
                }
                $this->loadModel("Purchase");
                $cState = $this->Purchase->find("first",array(
                    "conditions" => array(
                        'product_id' => $data['product_id'],
                        'state >' => 1,
                        'state <' => 5,
                      )
                     ));
                if($cState){
                    $this->error(1004);
                    return;
                }

                $this->loadModel('Purchase');
                $cPurchase = $this->Purchase->find('first',array('conditions' => array(
                    'product_id' => $data['product_id'],
                    'buyer_id' => $data['buyer_id'],
                )));
                if(!$cPurchase){
                    $this->error(1004);
                    return;
                }
                $this->Purchase->Create(false);
                $this->Purchase->id = $cPurchase['Purchase']['id'];
                if($this->Purchase->saveField('state',($data['is_accept']? 1:6) )){
                    if($data['is_accept']){
                        $notification_id = $this->set_notification("accept_buyer",$cPurchase['Purchase']['id'], $data['buyer_id']);
                    }
                    else{
                        if($cPurchase['Purchase']['pay_type'] == 2){
                            $this->set_balance($cPurchase['Purchase']['buyer_id'], $cPurchase['Purchase']['offers'] + $cPurchase['Purchase']['ship_fee'], "buy_product_failed", $cPurchase['Purchase']['id']);
                        }
                        $notification_id = $this->set_notification("reject_buyer",$cPurchase['Purchase']['id'], $data['buyer_id']);
                    }
                    //save state history
                    $this->save_history_purchase($cPurchase['Purchase']['id'],$data['is_accept']);
                
                    //push
                    $this->push_notification($notification_id,$data['buyer_id']);
                    $this->output($this->body);
                    return;
                }
                else{
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }  

    public function set_confirm_purchases(){
        if($this->request->is('post')) {
            $check_items = array('token', 'product_id','value');
            
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>0' => array('product_id'),
                    '>=0' => array('value'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;

            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token'])
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $cproduct = $this->Product->find('first',array('conditions' => array(
                    'id' => $data['product_id'],
                    'is_deleted' => 0,
                    )));
                if(!$cproduct){
                    $this->error(9992);
                    return; 
                }
                

                $this->loadModel('Purchase');
                $cPurchase = $this->Purchase->find('first',array('conditions' => array(
                    'product_id' => $data['product_id'],
                    'buyer_id' => $check['UserSession']['login_id'],
                )));
                if(!$cPurchase){
                    $this->error(1004);
                    return;
                }
                if($cPurchase['Purchase']['state'] > 1){
                    $this->error(1009); 
                }
                $cProduct = $this->Product->find("first",array("conditions" => array(
                    'id' => $data['product_id'],
                    'is_deleted' => '0')
                ));

                 if(!$cProduct){
                    $this->error(1004);
                    return;
                }
                $this->Purchase->Create(false);
                $this->Purchase->id = $cPurchase['Purchase']['id'];
                if($data['value']==0){
                    if($this->Purchase->saveField('state',6)){
                        if($cPurchase['Purchase']['pay_type'] == 2){
                            $this->set_balance($check['UserSession']['login_id'], $cPurchase['Purchase']['offers'] + $cPurchase['Purchase']['ship_fee'], "cancel_buy_products", $cPurchase['Purchase']['id']);
                        }
                        //save state history
                        $this->save_history_purchase($cPurchase['Purchase']['id'],6);

                        $notification_id = $this->set_notification("cancel_buy_products",$cPurchase['Purchase']['id'], $cProduct['Product']['seller_id']);
                         //push
                        $this->push_notification($notification_id,$cProduct['Product']['seller_id']);
                        $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }
                } 
                else{
                        $this->error(1004);
                        return;
                    }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }  

    public function search(){
        if($this->request->is('post')) {
            $check_items = array('index','count');
          $allow_items = array(
                'string'    => array('token','keyword','condition'),
                'numberic'  => array(
                    '>=0' => array('index','category_id','brand_id','product_size_id','price_min','price_max'),
                    '>0' => array('count'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                
                    $index = $data['index'];
                    $count = $data['count'];
                    $conditions = array();
                   
                    foreach ($data as $key => $value) {

                        if(($key=='price_min' || $key == 'price_max') && $value!=0){
                            if($key=='price_min') $conditions['price >='] = $value;
                            else $conditions['price <='] = $value;
                        }
                        elseif($key=='keyword'){
                            $conditions['name like'] = "%$value%";

                        }
                        elseif($key=='condition' && $value !=''){
                            $conditions['condition'] = "$value";

                        }
                        elseif($key == 'category_id' && $value!=0){
                            $this->loadModel('Category');
                            $listid = $this->Category->findChild($value);
                            $listid[] = $value;
                            $conditions['category_id'] = $listid;
                        }
                        elseif(!in_array($key,array('token','index','count')) && $value!=0){
                            $conditions[$key] = $value;
                        }
                       
                    }
                    $conditions["is_deleted"] = "0";
                    $list = $this->Product->find('all',array(
                        'conditions' => $conditions,
                        'offset' => $index,
                        'limit' => $count,
                        'fields' => array('id','name','price','price_new'),
                        'order' => array("created DESC")
                        ));
                    if(!$list){
                        $this->error(9994);
                        return;
                    }
                    $this->loadModel('ProductLike');
                    $this->loadModel('ProductComment');
                    $this->loadModel('ProductOtherImage');
                    $userid = 0;
                    if(isset($data['token'])){
                        $User = $this->UserSession->find('first',array('conditions'=> array(
                        'token' => $data['token'])));
                        if($User){
                            $userid = $User['UserSession']['login_id'];
                        }
                    }

                    $data = array();
                    foreach ($list as $key => $value) {
                        $data[$key] = $value['Product'];
                        $data[$key]['like'] = $this->ProductLike->find('count',array(
                                    'conditions' => array('product_id' => $data[$key]['id'])));
                        $data[$key]['comment'] = $this->ProductComment->find('count',array(
                                    'conditions' => array('product_id' => $data[$key]['id'])));
                        $img = $this->ProductOtherImage->find('first',array('conditions'=>array(
                            'product_id' => $data[$key]['id'])));
                        if($img)
                            $data[$key]['image'] = $img['ProductOtherImage']['image'];
                        else
                            $data[$key]['image'] = null;
                        $data[$key]['is_liked'] = ($this->ProductLike->find('first',array('conditions'=> array(
                            'product_id' => $data[$key]['id'],
                            'user_id' => $userid)))? true:false);
                        
                        if($data[$key]['price_new'] != 0){
                            $data[$key]['price_percent'] = (100- (ceil($data[$key]['price'] / $data[$key]['price_new'] * 100)))."%";
                        }
                        else{
                            $data[$key]['price_percent'] = "0%";
                        }
                    }
                    $this->body['data'] = $data;
                    $this->output($this->body);
                    return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function save_search(){
        if($this->request->is('post')) {
            $check_items = array('token');
          $allow_items = array(
                'string'    => array('token','keyword','condition'),
                'numberic'  => array(
                    '>=0' => array('category_id','brand_id','product_size_id','price_min','price_max'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,true,true)) return;
            try{
                    $check = $this->UserSession->find('first', array(
                        'conditions' => array(
                            'token' => $data['token']),));
                    if(!$check){
                        $this->error(9998);
                        return;
                    }
                    $data['user_id'] = $check['UserSession']['login_id'];
                    unset($data['token']);
                    if(count($data)<2){
                        $this->error(1002);
                        return;
                    }
                    foreach ($data as $key => $value) {
                        if(in_array($key,array('category_id','brand_id','product_size_id','price_min','price_max'))){
                            if($value == '' || $value == 0){
                                unset($data[$key]);
                            }
                        }
                    }
                    $this->loadModel('SearchHistory');
                    $cExist = $this->SearchHistory->find('first',array(
                        'conditions' => $data,
                        ));
                    if($cExist){
                        $this->error(1010);
                        return;
                    }

                    if($this->SearchHistory->save($data)){
                         $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }
                   
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function delete_saved_search(){
        if($this->request->is('post')) {
            $check_items = array('token','search_id');
          $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>0' => array('search_id'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,true,true)) return;
            try{
                    $check = $this->UserSession->find('first', array(
                        'conditions' => array(
                            'token' => $data['token']),));
                    if(!$check){
                        $this->error(9998);
                        return;
                    }
                    //check exist Searh History
                    $this->loadModel('SearchHistory');
                    $cExist = $this->SearchHistory->find('first',array(
                        'conditions' => array(
                            'id' => $data['search_id'],
                            'user_id' => $check['UserSession']['login_id']),
                        ));

                    if(!$cExist){
                        $this->error(1004);
                        return;
                    }
                    $this->SearchHistory->Create(false);
                    $this->SearchHistory->id = $data['search_id'];
                    if($this->SearchHistory->delete()){
                         $this->output($this->body);
                        return;
                    }
                    else{
                        $this->error(1004);
                        return;
                    }
                   
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function get_list_saved_search(){
        if($this->request->is('post')) {
            $check_items = array('token','index','count');
          $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>0' => array('count'),
                    '>=0' => array('index'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            try{
                    $check = $this->UserSession->find('first', array(
                        'conditions' => array(
                            'token' => $data['token']),));
                    if(!$check){
                        $this->error(9998);
                        return;
                    }
                    $user_id = $check['UserSession']['login_id'];
                   
                    $this->loadModel('SearchHistory');
                    $list = $this->SearchHistory->find('all',array(
                        'conditions' => array('user_id' => $user_id),
                        'offset' => $data['index'],
                        'limit' => $data['count'],
                        'fields' => array('SearchHistory.id','SearchHistory.keyword','SearchHistory.price_max','SearchHistory.price_min','SearchHistory.condition',
                                    'Category.id','Category.name','Brand.id','Brand.brand_name','ProductSize.id','ProductSize.size_name'),
                        'recursive' => 0,
                        ));
                    if(!$list){
                        $this->error(9994);
                        return;
                    }
                    foreach ($list as $key => $search) {
                        $ret[$key] = $search['SearchHistory'];
                        $ret[$key]['Category'] = $search['Category'];
                        $ret[$key]['Brand'] = $search['Brand'];
                        $ret[$key]['ProductSize'] = $search['ProductSize'];
                    }
                    
                    $this->body['data'] = $ret;
                    $this->output($this->body);
                    return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function get_my_likes(){
        if($this->request->is('post')) {
            $check_items = array('token','index','count');
          $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>=0' => array('index'),
                    '>0' => array('count'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),      
                ));
                if($check){
                    $this->loadModel('ProductLike');
                    $list = $this->ProductLike->find('all',array('conditions' =>array(
                        'user_id' => $check['UserSession']['login_id'],
                        'Product.is_deleted' => 0),
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'fields' => array('Product.id','Product.name','Product.price'),
                    'recursive' => 0));
                    if(!$list){
                        $this->error(9994);
                        return;
                    }
                    $data = Set::extract('/Product/.',$list);
                    $this->loadModel('ProductOtherImage');
                    $this->loadModel('Purchase');
                    foreach ($data as $key => $value) {
                        $img = $this->ProductOtherImage->find('first',array('conditions' =>array(
                            'product_id' => $data[$key]['id']),
                        'fields' => 'image'));
                        if($img) $data[$key]['image'] = $img['ProductOtherImage']['image'];
                       else $data[$key]['image'] = null;

                       $data[$key]['is_sold'] = $this->Purchase->find("first",array("conditions" => array(
                        'state' => 4,
                        'product_id' => $data[$key]['id']))) ? "1":"0";
                    }
                    $this->body['data'] = $data;
                   $this->output($this->body);
                   return;
                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function get_user_listings(){
        if($this->request->is('post')) {
            $check_items = array('index','count');
          $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>=0' => array('index','type'),
                    '>0' => array('count','user_id'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $userid=null;
                $myid = 0;
                $type = 0;
                if(isset($data['user_id'])){
                    $check = $this->User->find('first', array(
                                'conditions' => array('id' => $data['user_id'])));
                    if(!$check){
                        $this->error(1004);
                        return;
                    } 
                    $userid = $data['user_id'];
                }
                if(isset($data['token'])){
                    $check = $this->UserSession->find('first',array('conditions' => array(
                        'token' => $data['token'])));
                    if(!$check){
                        $this->error(9998);
                        return;
                    }
                    if($userid===null){
                        $userid = $check['UserSession']['login_id'];
                    } 
    
                    $myid = $check['UserSession']['login_id'];
                }
                if($userid===null){
                    $this->error(1002);
                    return;
                }
                if(isset($data['type']) && $myid == $userid) $type = $data['type'];

                $conditions = array('seller_id' => $userid,'is_deleted' => 0);
                if($type==1){ //listting
                    $this->loadModel('Purchase');
                    //lay list nhung san pham dang giao dich
                    $list_not_in = $this->Purchase->find('list',array('conditions' =>array(
                        'seller_id' => $userid,
                        'state <=' => 4,
                        ),
                    'fields' => array('product_id'),
                    'contain' => 'Product'
                    ));

                    $conditions['NOT'] = array("Product.id" => $list_not_in);
                }
                elseif($type==2){
                    //in process
                    $this->loadModel('Purchase');

                    $list_completed = $this->Purchase->find('all',array('conditions' =>array(
                        'seller_id' => $userid,
                        'Purchase.state' => '3',
                            ),
                   //     'fields' => array('product_id'),
                        'contain' => array('Product')
                        ));
                    $this->loadModel("UserRate");
                    foreach ($list_completed as $key => $value) {
                        $cRated = $this->UserRate->find("first", array(
                            "conditions" => array("purchase_id" => $value['Purchase']['id'],
                                            "rater_id" => $userid
                            )));
                        if(!$cRated){
                            unset($list_completed[$key]);
                        }
                        else{
                            $list_completed[$key] = $value['Product']['id'];
                        }
                    }

                    $list_in_process = $this->Purchase->find('list',array('conditions' =>array(
                        'seller_id' => $userid,
                        'state <=' => 3,
                        'NOT' => array("Purchase.product_id" => $list_completed),
                        ),
                    'fields' => array('product_id'),
                    'contain' => 'Product'
                    ));
                //    pr($list_in_process);
                    $conditions['Product.id'] = $list_in_process;
                }
                elseif($type==3){
                    //completed
                    $this->loadModel('Purchase');
                    $list_completed = $this->Purchase->find('all',array('conditions' =>array(
                        'seller_id' => $userid,
                        'Purchase.state' => array(3,4),
                
                        ),
                  //  'fields' => array('product_id'),
                    'contain' => 'Product'
                    ));

                    $this->loadModel("UserRate");
                    foreach ($list_completed as $key => $value) {
                        $cRated = $this->UserRate->find("first", array(
                            "conditions" => array("purchase_id" => $value['Purchase']['id'],
                                            "rater_id" => $userid
                            )));
                        if(!$cRated){
                            unset($list_completed[$key]);
                        }
                        else{
                            $list_completed[$key] = $value['Product']['id'];
                        }
                    }
                    $conditions['Product.id'] = $list_completed;
                }
                $check = $this->Product->find('all', array(
                                'conditions' => $conditions,
                                'offset' => $data['index'],
                                'limit' => $data['count'],
                                'fields' => array('id','name','price','price_new','created','described','video'),
                                'order' => array("created DESC"),         
                ));
                if($check){
                    $this->loadModel('ProductLike');
                    $this->loadModel('ProductComment');
                    $this->loadModel('ProductOtherImage');
                    $this->loadModel('Purchase');
                    $this->loadModel('UserRate');
                    $data = array();
                    foreach ($check as $key => $value) {
                        $data[$key] = $value['Product'];
                        if($data[$key]['price_new'] != 0){
                            $data[$key]['price_percent'] = (100- (ceil($data[$key]['price'] / $data[$key]['price_new'] * 100)))."%";
                        }
                        else{
                            $data[$key]['price_percent'] = "0%";
                        }
                        $data[$key]['like'] = $this->ProductLike->find('count',array(
                                    'conditions' => array('product_id' => $data[$key]['id'])));
                        $data[$key]['comment'] = $this->ProductComment->find('count',array(
                                    'conditions' => array('product_id' => $data[$key]['id'])));
                        $data[$key]['buyer_num'] = $this->Purchase->find('count',array(
                                    'conditions' => array('product_id' => $data[$key]['id'],
                                                        'state <=' => '4')));

                        $img = $this->ProductOtherImage->find('first',array('conditions'=>array(
                            'product_id' => $data[$key]['id'])));
                        if($img)
                            $data[$key]['image'] = $img['ProductOtherImage']['image'];
                        else
                            $data[$key]['image'] = null;
                        //check video or image
                        if($data[$key]['video'] !=''){
                            $temp['url'] = $data[$key]['video'];
                            $temp['thumb'] = $data[$key]['image'];
                            unset($data[$key]['video']);
                            $data[$key]['video'] = $temp;
                             unset($data[$key]['image']);
                        }
                        else{
                            unset($data[$key]['video']);
                        }
                        $data[$key]['is_liked'] = ($this->ProductLike->find('first',array('conditions'=> array(
                            'product_id' => $data[$key]['id'],
                            'user_id' => $myid)))? true:false);
                         $data[$key]['is_sold'] = $this->Purchase->find("first",array("conditions" => array(
                                                    'state >=' => 3,
                                                    'state <=' => 4,
                                                    'product_id' => $data[$key]['id']))) ? "1":"0";

                       //check state
                       $cState = $this->Purchase->find("first",array("conditions" =>
                            array('product_id' => $data[$key]['id'],
                            'state <=' => 4),
                            'order' => array('state DESC'),
                            'contain' => "UserRate"));
                       if($cState){
                            if($cState['Purchase']['state'] == 3 && $cState['Purchase']['seller_rated']){
                                $cState['Purchase']['state'] = 4;
                            }
                            $data[$key]['state'] = $this->state_purchase[$cState['Purchase']['state']];
                            if($cState['Purchase']['state'] == 4){
                                $data[$key]['created'] = $cState['Purchase']['modified'];
                            }
                       }
                       else{
                             $data[$key]['state'] = "request";
                       }

                      
                    }
                    if(count($data) == 0){
                        $this->error(9994);
                        return;
                    }
                    //sap xep lai theo trinh tu thoi gian
                    for($i=0; $i< count($data) - 1; $i++){
                        for($j = $i+1; $j < count($data); $j++){
                            if($data[$i]['created'] < $data[$j]['created']){
                                $tmp = $data[$i]['created'];
                                $data[$i]['created'] = $data[$j]['created'];
                                $data[$j]['created'] = $tmp;
                            }
                        }
                    }
                    $this->body['data'] = $data;
                    $this->output($this->body);
                    return;
                }
                else{
                    $this->error(9994);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function get_my_purchases(){
        if($this->request->is('post')) {
            $check_items = array('token','index','count','type');
          $allow_items = array(
                'string'    => array('token'),
                'numberic'  => array(
                    '>=0' => array('index','type'),
                    '>0' => array('count'),
                    '<=2' => array('type'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;
            
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $data['token']),      
                ));
                if($check){
                    $conditions = array(
                        'buyer_id' => $check['UserSession']['login_id'],
                        'Product.is_deleted' => 0);
                    $this->loadModel("Purchase");
                    $this->loadModel("UserRate");
                    $rated = array();
                    if($data['type'] == 0)
                    {
                        $conditions['state <'] = 4;
                      //  $conditions['Purchase.buyer_rated'] = 0;
                        $list_wait_rate = $this->Purchase->find("all", array(
                            "conditions" => array(
                                "state" => 3,
                                "buyer_id" => $check['UserSession']['login_id'])));
                        foreach ($list_wait_rate as $key => $value) {
                            $cRated = $this->UserRate->find("first", array(
                                "conditions" => array(
                                    "purchase_id" => $value['Purchase']['id'],
                                    "rater_id" => $check['UserSession']['login_id'])));
                            if($cRated){
                                $rated[] = $value['Purchase']['id'];
                            }
                        }
                        $conditions['NOT'] = array("Purchase.id" => $rated); 
                    }
                    elseif($data['type'] ==1)
                    {
                       // $conditions['Purchase.buyer_rated'] = 1;
                        $conditions['state'] = array(3,4);
                       $list_wait_rate = $this->Purchase->find("all", array(
                            "conditions" => array(
                                "state" => 3,
                                "buyer_id" => $check['UserSession']['login_id'])));
                       $no_rated = array();
                        foreach ($list_wait_rate as $key => $value) {
                            $cRated = $this->UserRate->find("first", array(
                                "conditions" => array(
                                    "purchase_id" => $value['Purchase']['id'],
                                    "rater_id" => $check['UserSession']['login_id'])));
                            if(!$cRated){
                                $no_rated[] = $value['Purchase']['id'];
                            }
                        }
                        $conditions['NOT'] = array("Purchase.id" => $no_rated);
                    }
                    elseif($data['type'] == 2)
                    {
                        $conditions['state'] = 5;
                    }

                    $this->loadModel('Purchase');
                    $list = $this->Purchase->find('all',array(
                    'conditions' => $conditions,
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'order' => 'Purchase.created DESC',
                    'recursive' => 0,
                    'contain' => array("UserRate","Product")));
                    if(!$list){
                        $this->error(9994);
                        return;
                    }
                    $_list = Set::extract('/Product/.',$list);
                    $this->loadModel('ProductOtherImage');
                    
                    foreach ($_list as $key => $value) {
                        
                        $return[$key]['id'] = $value['id'];
                        $return[$key]['name'] = $value['name'];
                    

                        $img = $this->ProductOtherImage->find('first',array('conditions' =>array(
                            'product_id' => $value['id']),
                        'fields' => 'image'));
                        if($img) $return[$key]['image'] = $img['ProductOtherImage']['image'];
                       else $return[$key]['image'] = null;

                       if($list[$key]['Purchase']['state'] == 3 && $list[$key]['Purchase']['buyer_rated']){
                            $list[$key]['Purchase']['state'] = 4;
                       }
                       
                        if( $list[$key]['Purchase']['state'] >= 4){
                            //lay ngay theo lan cuoi chinh sua
                            $return[$key]['created'] = $list[$key]['Purchase']['modified'];
                        }
                        else{
                            $return[$key]['created'] = $list[$key]['Purchase']['created'];
                        }
                        
                        $return[$key]['state'] =  $this->state_purchase[$list[$key]['Purchase']['state']];
                       
                    }
                    //sap xep lai theo trinh tu thoi gian
                    for($i=0; $i< count($return) - 1; $i++){
                        for($j = $i+1; $j < count($return); $j++){
                            if($return[$i]['created'] < $return[$j]['created']){
                                $tmp = $return[$i]['created'];
                                $return[$i]['created'] = $return[$j]['created'];
                                $return[$j]['created'] = $tmp;
                            }
                        }
                    }

                    $this->body['data'] = $return;
                   $this->output($this->body);
                   return;
                }
                else{
                    $this->error(9998);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function get_list_sizes(){
        if($this->request->is('post')) {
            $check_items = array('index','count');
            $allow_items = array(
                'numberic'  => array(
                    '>=0' => array('index','category_id'),
                    '>0' => array('count'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;
            
            try{
                    $this->loadModel('ProductSizeCategory');
                    if(!isset($data['category_id'])) $data['category_id']=0;
                  //  $listcat = $this->Category->findChild($data['category_id']);
                //$listcat[] = $data['category_id'];
                    $conditions = array();
                    if($data['category_id']!=0) {
                        $conditions = array('category_id' => $data['category_id']);
                        $order = 'ProductSizeCategory.sort ASC';
                    }
                    else{
                        $order = 'ProductSize.size_name ASC';
                    }
                    $list = $this->ProductSizeCategory->find('all',array(
                    'conditions' => $conditions,
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'recursive' => 0,
                    'order' => $order,
                    'fields' => array('ProductSize.id','ProductSize.size_name'),
                    'group' => "ProductSize.id",
                    ));
                    if(!$list){
                        $this->error(9994);
                        return;
                    }
                    $data = Set::extract('/ProductSize/.',$list);
                    
                    $this->body['data'] = $data;
                   $this->output($this->body);
                   return;
                

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function get_list_brands(){
        if($this->request->is('post')) {
            $check_items = array('index','count');
            $allow_items = array(
                'numberic'  => array(
                    '>=0' => array('index','category_id'),
                    '>0' => array('count'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;
            
            try{
                    $this->loadModel('BrandCategory');
                    if(!isset($data['category_id'])) $data['category_id']=0;
                   $conditions = array();
                    if($data['category_id']!=0) $conditions = array('category_id' => $data['category_id']);
                    $list = $this->BrandCategory->find('all',array(
                    'conditions' => $conditions,
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'recursive' => 0,
                    'order' => 'Brand.brand_name ASC',
                    'fields' => array('Brand.id','Brand.brand_name'),
                    'group' => "Brand.id",
                    ));
                    if(!$list){
                        $this->error(9994);
                        return;
                    }
                    $data = Set::extract('/Brand/.',$list);
                    
                    $this->body['data'] = $data;
                   $this->output($this->body);
                   return;
                

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }
    }

    public function get_comment_products(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }

         $check_items = array('product_id','index','count');
            $allow_items = array(
                'numberic'  => array(
                    '>=0' => array('index'),
                    '>0' => array('count','product_id'),
                    ),
                'string' => array('order',"token"),);
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;
            try{
                if(!isset($data['order']) || strtolower($data['order'])!="asc"){
                    $data['order'] = "DESC";
                }
                $this->loadModel('Product');
                $check = $this->Product->find('first', array('conditions' => array(
                    'id' => $data['product_id'],
                    'is_deleted' => 0)));
                if(!$check){
                    $this->error(9992);
                    return;
                }
                $user_id = 0;
                if(isset($data['token'])){
                    $User = $this->UserSession->find("first",array("conditions" => array(
                        "token" => $data['token'])));
                    if($User){
                        $user_id = $User['UserSession']['login_id'];
                    }
                }
                $this->loadModel('ProductComment');
                $list = $this->ProductComment->find('all', array(
                    'conditions'=> array('product_id' => $data['product_id']),
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'order' => 'created '.$data['order'],
                    'fields' => array('ProductComment.id','ProductComment.comment','ProductComment.created',
                                        'User.id','User.username','User.avatar'),
                    'recursive' => 0,));
                $this->loadModel("UserBlock");
                $this->body['is_blocked'] = ($this->UserBlock->find('first',array('conditions'=> array(
                                            'user_id' => $check['Product']['seller_id'],
                                            'blocked_id' => $user_id)))? "1":"0");
                if(!$list){
                    $this->error(9994);
                    return;
                }
                $data = Set::extract('/ProductComment/.',$list);
                foreach ($data as $key => $value) {
                    $data[$key]['poster'] = $list[$key]['User'];
                    $data[$key]['poster']['name'] = $data[$key]['poster']['username'];
                    unset($data[$key]['poster']['username']);
                }
                $this->body['data'] = $data;
                $this->output($this->body);

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function set_comment_products(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','product_id','comment');
            $allow_items = array(
                'string' => array('token','comment'),
                'numberic'  => array(
                    '>0' => array('product_id','count'),
                    '>=0' => array('index'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                    'contain' => array('User')));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $userid = $check['UserSession']['login_id'];

                $this->loadModel('Product');
                $cProduct = $this->Product->find('first', array('conditions' => array(
                    'id' => $data['product_id'],
                    'is_deleted' => 0)));
                if(!$cProduct){
                    $this->error(9992);
                    return;
                }
                $this->loadModel('ProductComment');
                $cComment = $this->ProductComment->find('first',array('conditions' => array(
                    'product_id' => $data['product_id'],
                    'poster_id' => $userid,
                    'comment' => $data['comment'],
                    'created >' => date('Y-m-d H:i:s', time()-00),

                )));
                if($cComment){
                    $this->error(9991);
                    return;
                }
                $is_not_first = $this->ProductComment->find("first", array("conditions" => array(
                                "product_id" => $data['product_id'])));
                if(!$is_not_first){
                    $notification_id = $this->set_notification("comment_products",$data['product_id'], $cProduct['Product']['seller_id']);
                }
                $save = array('product_id' => $data['product_id'],
                            'comment' => $data['comment'],
                            'poster_id' => $userid,
                            'created' => date('Y-m-d H:i:s', time()));

                if($this->ProductComment->save($save)){
                    $notification_id = $this->set_notification("comment_products",$data['product_id'], $userid);
                    //push
                    $Notification = new NotificationController;
                    
                    $list_userid_comment = $Notification->getListUserByNotificationID($notification_id,$userid);
                    $list_userid_like = $Notification->getListUserByNotificationConditions(array("type" => "like_products","object_id" => $data['product_id']),$userid);
                    foreach ($list_userid_like as $key => $value) {
                        if(!in_array($value, $list_userid_comment)){
                            $notification_id = $this->set_notification("comment_products",$data['product_id'], $value);
                        }
                    }
                    //get lai de loai bo nhung nguoi tat push setting
                    $list_userid = $Notification->getListUserByNotificationID($notification_id,$userid);
                    //$list_userid = array_unique($list_userid);

                    $this->push_notification($notification_id,$list_userid);

                    //get comment;
                    $this->request->data['order'] = "asc";
                    $return = $this->get_comment_products();
                  //  $this->output($this->body);
                    return;
                }
                else{
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function report_products(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','product_id','subject','details');
            $allow_items = array(
                'string' => array('token','subject','details'),
                'numberic'  => array(
                    '>0' => array('product_id'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token'])));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $userid = $check['UserSession']['login_id'];

                $this->loadModel('Product');
                $check = $this->Product->find('first', array('conditions' => array(
                    'id' => $data['product_id'],
                    'is_deleted' => 0)));
                if(!$check){
                    $this->error(9992);
                    return;
                }
                $this->loadModel('ProductReport');
                $cReport = $this->ProductReport->find('first',array('conditions' => array(
                    'product_id' => $data['product_id'],
                    'reporter_id' => $userid,
                )));
                if($cReport){
                    $this->error(1010);
                    return;
                }
                $save = array('product_id' => $data['product_id'],
                            'reporter_id' => $userid,
                            'subject' => $data['subject'],
                            'details' => $data['details']);
                if($this->ProductReport->save($save)){
                    $this->output($this->body);
                    return;
                }
                else{
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function get_ship_from() {
        if($this->request->is('post')) {
            $check_items = array('level', 'index', 'count');
            $allow_items = array(
                'numberic' => array(
                    '>=0' => array("index","checkshipsupport"),
                    '>0' => array("level","count","parent_id"),
                    '<=3' => array("level"),
                    '<=1' => array("checkshipsupport"),
                ),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $level = $data['level'];
            $checkshipsupport = false;
            if(isset($data['checkshipsupport']) && $data['checkshipsupport'])
                $checkshipsupport = true;
            switch($level) {
                case 1:
                    $result = $this->ShipChung->getCity($checkshipsupport);
                    break;
                case 2:
                    if(!isset($data['parent_id'])){
                        $this->error(1002);
                        return;
                    }
                    $result = $this->ShipChung->getProvince($data['parent_id'],$checkshipsupport);
                    break;
                case 3:
                    if(!isset($data['parent_id'])){
                        $this->error(1002);
                        return;
                    }
                    $result = $this->ShipChung->getWard($data['parent_id']);
                    break;
                default:
                    $this->error('1004');
            }
            if(isset($result) && $result != null) {
                $this->body['data'] = $result;
                $this->output($this->body);
            } else {
                $this->error('9994');
            }
            return;
        } else {
            $this->error('9997');
            return;
        }
        $this->autoRender = false;
    }


    public function get_notification(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
        $Notification = new NotificationController;
        $check_items = array('token','index','count');
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>0' => array('count'),
                    '>=0' => array('index','group'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token'])));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $user_id = $check['UserSession']['login_id'];
                if(!isset($data['group'])){
                    $data['group'] = -1;
                }
                $list = $Notification->getNotificationbyUserID($user_id,$data['index'],$data['count'],0,$data['group']);
                if(!$list){
                    $this->error(9994);
                    return;
                }


                foreach ($list as $key => $value) {
                    $oinfo = $Notification->getDetailsNotification($value['id'],$user_id);

                    //loai bo nhung notification khong ton tai
                    if(!$oinfo){
                        unset($list[$key]);
                        continue;
                    }
                    if($oinfo['type'] == "unknown"){
                        unset($list[$key]);
                        continue;
                    }
                    if(isset($oinfo['seller_id'])){
                        if($user_id != $oinfo['seller_id']){
                            if(isset($oinfo['seller_name'])) $seller_name = $oinfo['seller_name'];
                            else $seller_name = "";
                        
                        }
                        else{
                            if(isset($oinfo['seller_name'])) $seller_name = "bạn";
                            else $seller_name = "";
                            
                        }
                        $oinfo['title'] .= $seller_name;
                        unset($oinfo['seller_id']);
                        if(isset($oinfo['seller_name']))
                            unset($oinfo['seller_name']);
                    }
                    unset($list[$key]['id']);

                    $ret[] = array_merge($list[$key],$oinfo);
                }


                $this->body['last_update'] = time()."";
                $this->body['data'] = $ret;
                $this->output($this->body);

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
       
    }

    public function get_user_info(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
            $allow_items = array(
                'string'  => array('token','user_id'));
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $my_id=0;
                if(isset($data['token']))
                {
                    $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token'],),
                    'recursive' => 0));
                    if(!$check){
                        $this->error(9998);
                        return;
                    }
                    $my_id = $check['UserSession']['login_id'];
                }
               if(isset($data['user_id'])){
                     $check = $this->User->find('first',array('conditions' => array(
                    'id' => $data['user_id'],)));
                    if(!$check){
                        $this->error(1004);
                        return;
                    }
                }
                if(!isset($data['token']) && !isset($data['user_id'])){
                    $this->error(1002);
                    return;
                }
                $out['id'] = $check['User']['id'];
                $out['username'] = $check['User']['username'];
                $out['created'] = $check['User']['created'];
                $out['url'] = Router::url( "/", true ).$check['User']['url'];
                $out['status'] = $check['User']['status'];
                $out['avatar'] = $check['User']['avatar'];
                $this->loadModel('UserRate');
                $this->UserRate->virtualFields['count'] = "count(rate_level)";
                $rates = $this->UserRate->find('all',array('conditions'=>
                        array('user_id' => $out['id']),
                        'fields' => 'rate_level,count(rate_level) as UserRate__count',
                        'group' => 'rate_level',
                        'order' => 'rate_level ASC'));
                $out['rates_lv1'] = 0;
                $out['rates_lv2'] = 0;
                $out['rates_lv3'] = 0;
                for($i = 0; $i < count($rates); $i++){
                    $out['rates_lv'.$rates[$i]['UserRate']['rate_level']] = $rates[$i]['UserRate']['count'];
                }
                $out['score'] = $this->User->rate($out['id']);
                $out['listing'] = $this->User->numProduct($out['id']);
                if($out['id'] == $my_id){
                    $out['email'] = $check['User']['email'];
                    $out['phonenumber'] = $check['User']['phonenumber'];
                    $out['balance'] = $check['User']['balance'];
                    $this->loadModel('UserAddress');
                    $info = $this->UserAddress->find('first',array('conditions' => array(
                        'user_id' => $my_id)));
                    if($info){
                        $out['firstname'] = $info['UserAddress']['firstname'];
                        $out['lastname'] = $info['UserAddress']['lastname'];
                        $out['address'] = $info['UserAddress']['address'];
                        $out['city'] = $info['UserAddress']['city'];
                    }
                    else{
                        $out['firstname'] = "";
                        $out['lastname'] = "";
                        $out['address'] = "";
                        $out['city'] = "";
                    }
                    //get address order default
                    $this->loadModel("UserOrderAddress");
                    $AddressOrderDefault = $this->UserOrderAddress->find("first",array(
                        "conditions" => array(
                            "user_id" => $out['id'],
                            "default" => "1"
                            )));
                    if(!$AddressOrderDefault){
                        $out['default_address'] = "";
                    }else{
                        $out['default_address'] = array(
                            "address_id" => json_decode($AddressOrderDefault['UserOrderAddress']['address_id']),
                            "address" => $AddressOrderDefault['UserOrderAddress']['address']
                        );
                    }
                }  
                //check online status
                $this->loadModel("UserOnline");
                $cOnline = $this->UserOnline->find("first", array("conditions" => 
                    array("user_id" => $out['id'])));
                if($cOnline){
                    $out['online'] = 1;
                }
                else{
                    $out['online'] = 0;   
                }
                //check người dung hien tai da follow nguoi dang bi lay thong tin hay chua:
                $this->loadModel("UserFollow");
                $cFollow = $this->UserFollow->find("first", array("conditions" =>
                    array(
                        'follower_id' => $my_id,
                        'followee_id' => $out['id'],
                        )));
               $out['followed'] = ($cFollow? "1": "0");
                
                //check người hiện tại đã block người đang bị lấy thông tin hay chưa
               $this->loadModel("UserBlock");
                $cBlocked = $this->UserBlock->find("first", array("conditions" =>
                    array(
                        'user_id' => $my_id,
                        'blocked_id' => $out['id'],
                        )));
               $out['is_blocked'] = ($cBlocked? "1": "0");

                 $this->body['data']=$out;
                $this->output($this->body);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }
    
    public function set_user_info(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token');
            $allow_items = array(
                'string' => array('token','email','username','status','url','firstname','lastname','address','city','password'),
                );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token'])));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $userid = $check['UserSession']['login_id'];
                if(isset($this->request['form']['avatar'])){
                    $file = $this->request['form']['avatar'];
                    if($file['error'] == 4){
                        $this->error(1007);
                        return;
                    }
                   if ($file['size'] > IMAGE_FILE_SIZE_LIMIT)
                        {
                            $this->error(1006);
                             return;
                        }
                    $fileDestination = AVATAR_UPLOAD_PATH;
                    $options = array('max_width'=>100);  
                    $ext = $this->get_file_ext($file['name']);
                    $file['name'] = $file['name'] = 'avatar_'.$userid.$ext;
                    try{
                        $output = $this->ImageUploader->upload($file,$fileDestination,$options);
                    }catch(Exception $e){
                            $message = $e->getMessage();
                            $this->error_detail(9999, $message);
                    }
                    if ($output['bool'] == 1)
                    {
                        $data['avatar'] = $output['file_path'];
                    } 
                    else{
                        $this->error(1007);
                        return;
                    }
                }
               $save = array();
                $save['id'] =$userid;
                if(isset($data['email'])) $save['email'] = $data['email'];
                if(isset($data['username'])) $save['username'] = $data['username'];
                if(isset($data['status'])) $save['status'] = $data['status'];
                if(isset($data['password'])) $save['password'] = $data['password'];
                if(isset($data['avatar'])) $save['avatar'] = $data['avatar'];
                if(isset($data['url'])){
                    $data['url'] = trim($data['url']);
                    if($this->Convert->vn_str_filter($data['url']) != $data['url']){
                        $this->error(1004);
                    }
                    $cExist = $this->User->find("first", array(
                        "conditions" => array(
                            "url" => $data['url']),
                    ));
                    if($cExist || in_array($data['url'], $this->home_url_not_allow)){
                        $this->error(1013);
                        return;
                    }
                }
                if(!$this->User->save($save)){

                    $this->error(1004);
                    return;
                }
                $save = array();
                $save['user_id'] =$userid;
                if(isset($data['firstname'])) $save['firstname'] = $data['firstname'];
                if(isset($data['lastname'])) $save['lastname'] = $data['lastname'];
                if(isset($data['address'])) $save['address'] = $data['address'];
                if(isset($data['city'])) $save['city'] = $data['city'];
                $this->loadModel('UserAddress');
                if(!$this->UserAddress->save($save)){
                    $this->error(1004);
                    return;
                }
                $this->output($this->body);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function get_rates(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('level','index','count');
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>=0' => array('index','level'),
                    '>0' => array('count','user_id'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $user_id=0;
                if(isset($data['token']))
                {
                    $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token'],),
                    'recursive' => 0));
                    if(!$check){
                        $this->error(9998);
                        return;
                    }
                    $user_id = $check['UserSession']['login_id'];
                }
               if(isset($data['user_id'])){
                     $check = $this->User->find('first',array('conditions' => array(
                    'id' => $data['user_id'],)));
                    if(!$check){
                        $this->error(1004);
                        return;
                    }
                    $user_id = $data['user_id'];
                }
                $conditions = array('user_id' => $user_id);
                if($data['level']!=0) $conditions['rate_level'] = $data['level'];
                $this->loadModel('UserRate');
                $list = $this->UserRate->find('all',array(
                    'conditions' => $conditions,
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'order' => 'UserRate.created DESC',
                    'recursive' => 0,
                ));
               /* if(!$list){
                    $this->error(9994);
                    return;
                }*/
                $out = array();
                foreach ($list as $key => $rate) {
                    $out['rates_data'][$key]['id'] = $rate['Rater']['id'];
                    $out['rates_data'][$key]['username'] = $rate['Rater']['username'];
                    $out['rates_data'][$key]['avatar'] = $rate['Rater']['avatar'];
                    $out['rates_data'][$key]['content'] = $rate['UserRate']['content'];
                    $out['rates_data'][$key]['level'] = $rate['UserRate']['rate_level'];
                    $out['rates_data'][$key]['created'] = $rate['UserRate']['created'];
                }
                ### lay so luong moi level rates
                $this->loadModel('UserRate');
                $this->UserRate->virtualFields['count'] = "count(rate_level)";
                $rates = $this->UserRate->find('all',array('conditions'=>
                        array('user_id' => $user_id),
                        'fields' => 'rate_level,count(rate_level) as UserRate__count',
                        'group' => 'rate_level',
                        'order' => 'rate_level ASC'));
                $out['rates_lv1'] = 0;
                $out['rates_lv2'] = 0;
                $out['rates_lv3'] = 0;
                for($i = 0; $i < count($rates); $i++){
                    $out['rates_lv'.$rates[$i]['UserRate']['rate_level']] = $rates[$i]['UserRate']['count'];
                }
                $this->body['data'] = $out;
                $this->output($this->body);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function set_rates(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','product_id','rate_level','content');
            $allow_items = array(
                'string' => array('token','content'),
                'numberic'  => array(
                    '>0' => array('product_id','rate_level'),
                    '<=3' => array('rate_level'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $this->loadModel("Purchase");
                $purchase = $this->Purchase->find("first", array(
                    "conditions" => array("product_id" => $data['product_id'],
                                        "state" => array(3,4),
                    ),
                    'contain' => array('Product')
                    ));
                if(!$purchase){
                    $this->error(1004);
                    return;
                }
                $data['purchase_id'] = $purchase['Purchase']['id'];
                $data['rater_id'] = $check['UserSession']['login_id'];
                $this->loadModel('UserRate');
                $cRater = $this->UserRate->find("first",array("conditions" => array(
                    'rater_id' => $data['rater_id'],
                    'purchase_id' => $data['purchase_id'])));
                if($cRater){
                    $this->error(1010);
                    return;
                }
                
                //kiem tra xem nguoi vua rate la nguoi mua hay nguoi ban
                $this->User->begin();
                if($purchase['Purchase']['buyer_id'] == $data['rater_id']){
                    $data['user_id'] = $purchase['Product']['seller_id'];
                    //add vao state history
                    $this->save_history_purchase($data['purchase_id'],5);
                }
                elseif($purchase['Product']['seller_id'] == $data['rater_id']){
                    $data['user_id'] = $purchase['Purchase']['buyer_id'];
                    //add vao state history
                    $this->save_history_purchase($data['purchase_id'],4);
                    $this->set_balance($data['rater_id'], $purchase['Purchase']['offers'], "sell_product", $data['purchase_id']);
                   
                    
                }
                else{
                    $this->error(1004);
                    return;
                }
                if($this->UserRate->save($data)){
                    $id = $this->UserRate->getLastInsertId();
                    $notification_id = $this->set_notification("rates_user",$id,$data['user_id']);
                    //push
                    $this->push_notification($notification_id,$data['user_id']);
                    $this->User->commit();

                    $cRated = $this->UserRate->find("count",array("conditions" => array(
                    "purchase_id" => $purchase['Purchase']['id'],
                    )));
                    if($cRated == 2){
                         $this->Purchase->id = $purchase['Purchase']['id'];
                         $this->Purchase->saveField("state","4");
                    }
                    $this->output($this->body);
                    return;
                }
                else{
                    $this->User->rollback();
                    $this->error(1004);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function set_user_follow() {
        if($this->request->is('post')) {
            $check_items = array('token', 'followee_id');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array( '>0' => array('followee_id'))
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $this->loadModel('UserSession');
            $follower_id = $this->UserSession->find('first',
                array(
                    'conditions' => array('UserSession.token' => $data['token']),
                    'fields' => array('UserSession.login_id')
                )
            );
            if(!$follower_id) {
                $this->error('9998');
                return;
            }
            $follower_id = $follower_id['UserSession']['login_id'];
            $this->loadModel('User');
            $followee_id = $this->User->find('first',
                array(
                    'conditions' => array('User.id' => $data['followee_id']),
                    'fields' => array('User.id')
                )
            );
            if(!$followee_id) {
                $this->error('1004');
                return;
            }
            $followee_id = $data['followee_id'];
            if($follower_id == $followee_id) {
                $this->error('1004');
            }
            $this->loadModel('UserFollow');
            $check = $this->UserFollow->find('first',
                array(
                    'conditions' => array(
                        'follower_id' => $follower_id,
                        'followee_id' => $followee_id
                    )
                )
            );
            // Nếu đã từng Follow rồi thì unfollow
            if($check) {
                $this->UserFollow->delete(array('UserFollow.id' => $check['UserFollow']['id']));
                $this->body['data']['follow'] = $this->User->follow($followee_id);
                $this->output($this->body);
                return;
                // Trường hợp chưa từng follow thì insert field mới cho follow
            } else {
                $save = array(
                    'follower_id' => $follower_id,
                    'followee_id' => $followee_id
                );
                if($this->UserFollow->save($save)) {
                    //push notification
                    $notification_id = $this->set_notification("follows_user",$follower_id,$followee_id);
                    $this->push_notification($notification_id,$followee_id);

                    $this->body['data']['follow'] = $this->User->follow($followee_id);
                    $this->output($this->body);
                    return;
                } else {
                    $this->error('1004');
                    return;
                }
            }
        } else {
            $this->error('9997');
            return;
        }
    }

    public function search_user() {
        if($this->request->is('post')) {
            $check_items = array('keyword', 'index', 'count');
            $allow_items = array(
                'string' => array('keyword', 'index', 'count'),
                'numberic' => array(
                    '>=0' => array("index"),
                    '>0' => array("count")
                ),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data,false)) {
                return;
            }
            $keyword = trim($data['keyword']);
            $index   = $data['index'];
            $count   = $data['count'];

            $this->loadModel('User');
            $conditions = array(
                'conditions' => array(
                    "OR" => array(
                        'User.email LIKE'    => "%".$keyword."%",
                        'User.username LIKE' => "%".$keyword."%")

                ),
                'fields' => array(
                    'User.id', 'User.username', 'User.avatar'
                ),
                'offset' => $index,
                'limit' => $count,
                'order' => 'username ASC'
            );
            $result = $this->User->find('all', $conditions);
            if($result) {
                $result = Set::extract('/User/.',$result);
                $this->body['data'] = $result;
                $this->output($this->body);
                return;
            } else {
                $this->error('9994');
                return;
            }
        } else {
            $this->error('9997');
        }
    }

    public function get_list_news(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('index','count');
        $allow_items = array(
                'numberic' => array(
                    '>=0' => array('index'),
                    '>0' => array('count')),
            );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $this->loadModel('News');
                $list = $this->News->find('all',array(
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'order' => 'created DESC',
                    'fields' => array('id','title','created')
                ));
                if(!$list){
                    $this->error(9994);
                    return;
                }
                $list = Set::extract('/News/.',$list);
                $this->body['data'] = $list;
                $this->output($this->body);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function get_news(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('id');
        $allow_items = array(
                'numberic' => array(
                    '>0' => array('id')),
            );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $this->loadModel('News');
                $list = $this->News->find('first',array(
                    'conditions' => array('id' => $data['id']),
                    'fields' => array('title','content','created'),
                ));
                if(!$list){
                    $this->error(1004);
                    return;
                }
               // $list = Set::extract('/News/.',$list);
                $this->body['data'] = $list['News'];
                $this->output($this->body);
                return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function blocks(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','user_id','type');
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>0' => array('user_id'),
                    '>=0' => array('type'),
                    '<=1' => array('type'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token'])));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $save['user_id'] = $check['UserSession']['login_id'];
                $checku = $this->User->find('first',array('conditions' => array(
                    'id' => $data['user_id'])));
                if(!$checku){
                    $this->error(1004);
                    return;
                }
                $save['blocked_id'] = $checku['User']['id'];
                $this->loadModel('UserBlock');
                $c = $this->UserBlock->find('first',array('conditions' => $save));
                if($data['type']==0){
                    if($c){
                        $this->error(1010);
                        return;
                    }
                    if($this->UserBlock->save($save)){
                        $this->output($this->body);
                        return;
                    }else{
                        $this->error(1004);
                        return;
                    }
                }
                else{
                    if(!$c){
                        $this->error(1010);
                        return;
                    }
                    $this->UserBlock->Create(false);
                    $this->UserBlock->id = $c['UserBlock']['id'];
                    if($this->UserBlock->delete()){
                        $this->output($this->body);
                        return;
                    }else{
                        $this->error(1004);
                        return;
                    }

                }
                

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function get_list_blocks(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','index','count');
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>0' => array('count'),
                    '>=0' => array('index'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token'])));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $user_id = $check['UserSession']['login_id'];
                $this->loadModel('UserBlock');
                $list = $this->UserBlock->find('all',array(
                    'conditions' => array(
                        'user_id' => $user_id),
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    'recursive' => 0,
                    'fields' => array('Blocked.id','Blocked.username','Blocked.avatar'),
                    ));
                if(!$list){
                    $this->error(9994);
                    return;
                }
                $list = Set::extract('/Blocked/.',$list);
                $this->body['data'] = $list;
                $this->output($this->body);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function get_balance_history(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','index','count');
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>0' => array('count'),
                    '>=0' => array('index'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                
                $this->loadModel("BalanceHistory");
                $histories = $this->BalanceHistory->find("all",array(
                    "conditions" => array('user_id' => $check['User']['id'],),
                    'order' => 'created DESC',
                    'offset' => $data['index'],
                    'limit' => $data['count'],
                    ));
                if($histories){
                    foreach ($histories as $key => $history) {
                        $history = Set::extract("/BalanceHistory/.",$history);
                        $return[$key] = $this->BalanceHis->getDetail($history[0]);
                    }
                    $this->body['data'] = $return;
                    $this->output($this->body);
                    return;
                }
                else{
                    $this->error(9994);
                    return;
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function sent_sms_withdraw(){
        if($this->request->is('post')) {
            $check_items = array('token');
            
            if ($this->validate_param($check_items) == false)
                return;
            try{
                $check = $this->UserSession->find('first', array(
                                'conditions' => array('token' => $this->request->data['token']),
                                'recursive' => 0
                ));
                if($check){
                    
                    $verify_code = rand(100000,999999);
                    $this->loadModel('SmsCode');
                    $save = array('verify_code' =>$verify_code,
                        'phonenumber' => $check['User']['phonenumber'],
                        'type' => 1);

                    $SmsCode = $this->SmsCode->find("first", array(
                        "conditions" => array(
                            "phonenumber" => $check['User']['phonenumber'])));
                    if($SmsCode){
                        $save['id'] = $SmsCode['SmsCode']['id'];
                    }
                    $this->SmsCode->Create(false);
                    $this->SmsCode->save($save);
                    $this->output($this->body);
                    //send sms
                    $this->send_sms( $save['phonenumber'],$this->messages_sms['WITHDRAW'].$verify_code);
                }
                else{
                    $this->error(1004);
                }

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
        }
        else{
            $this->error(9997);
        }

    }

    public function request_withdraw(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','balance','bank_address','bank_name','bank_number','holder','verify_code');
            $allow_items = array(
                'string' => array('token','bank_address','bank_name','bank_number','holder'),
                'numberic'  => array(
                    '>0' => array('balance','verify_code'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                
               if($check['User']['balance'] < $data['balance']){
                    $this->error(9990);
                    return;
               }
               $this->loadModel("SmsCode");
               $check_verify_code = $this->SmsCode->find("first", array(
                "conditions" => array(
                    "phonenumber" => $check['User']['phonenumber'],
                    "verify_code" => $data['verify_code'],
                    "modified >" => date("Y-m-d H:i:s", time() - 600)
                    )));
               if(!$check_verify_code){
                $this->error(9993);
                return;
               }
               else{
                $this->SmsCode->delete($check_verify_code['SmsCode']['id']);
               }
               $this->User->begin();
               $save = $data;
               $save['user_id'] = $check['User']['id'];
               $save['state'] = 0;
           
               $this->loadModel("UserWithdraw");
               if(!$this->UserWithdraw->save($save)){
                    $this->User->rollback();
                    $this->error(1004);
                    return;
               }
               $wid = $this->UserWithdraw->id;
               if($this->set_balance($check['User']['id'],-$data['balance'],"withdraw",$wid)){
                    $this->User->commit();
                    $this->output($this->body);
                    return;
               }
               $this->User->rollback();
               $this->error(1004);
               return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function cancel_withdraw(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','request_id');
            $allow_items = array(
                'string' => array('token'),
                'numberic'  => array(
                    '>0' => array('request_id'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $this->loadModel("UserWithdraw");
                $cWithDraw = $this->UserWithdraw->find("first",array(
                "conditions" => array(
                    "id" => $data['request_id'],
                    "state" => "0"))); 

               if(!$cWithDraw){
                    $this->error(1004);
                    return;
               }
               $this->User->begin();
               
               
               $this->UserWithdraw->id = $cWithDraw['UserWithdraw']['id'];

               if(!$this->set_balance($check['User']['id'],$cWithDraw['UserWithdraw']['balance'],"cancel_withdraw",$cWithDraw['UserWithdraw']['id'])){
                   $this->User->rollback();
                   $this->error(1004);
                   return;
               }
               if($this->UserWithdraw->saveField("state","2")){
                    $this->User->commit();
                    $this->output($this->body);
                    return;
               }
               $this->User->rollback();
               $this->error(1004);
               return;
            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }
    public function get_current_balance() {
        if($this->request->is('POST')) {
            $check_items = array('token');
            $allow_items = array(
                'string' => array('token')
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $this->loadModel('User');
            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if($logged) {
                $this->loadModel("User");
                $result = $this->User->find('first',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'User.id' => $logged['UserSession']['login_id']
                        )
                    )
                );
                if($result) {
                    if($result['User']['balance']) {
                        $this->body['data']['balance'] = $result['User']['balance'];
                    } else {
                        $this->body['data']['balance'] = 0;
                    }
                    $this->output($this->body);
                    return;
                } else {
                    $this->error('9994');
                    return;
                }
            } else {
                $this->error('9998');
                return;
            }
        } else {$this->error(9997);
            return;
        }
    }

    ###################### SHIPPER #############################
    public function change_state_purchase(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','purchase_id','state');
            $allow_items = array(
                'string' => array('token','state'),
                'numberic'  => array(
                    '>0' => array('purchase_id'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                if($check['User']['role'] !="admin" && $check['User']['role'] !="shipper"){
                     $this->error(1009);
                    return; 
                }
                $user_id = $check['UserSession']['login_id'];
                $this->loadModel("Purchase");
                $cPurchase = $this->Purchase->find("first",array(
                    "conditions" => array(
                        'id' => $data['purchase_id'],
                        'state >=' => 1,
                        'state <=' => 2)));
                if(!$cPurchase){
                    $this->error(1004);
                    return;
                }
                $this->Purchase->Create(false);
                $this->Purchase->id = $data['purchase_id'];
                if($data['state'] == "shipping"){
                     if($cPurchase['Purchase']['state'] != 1){
                        $this->error(1010);
                        return;
                    }
                    $this->Purchase->saveField("state","2");
                }
                else{
                    if($cPurchase['Purchase']['state'] != 2){
                        $this->error(1004);
                        return;
                    }
                    if($data['state'] == "waiting rate"){
                        $this->Purchase->saveField("state","3");
                        $PurchaseFailed = $this->Purchase->find("all",array(
                            "conditions" => array("Purchase.id !=" => $data['purchase_id'],
                                                "Purchase.state" => "0")));
                        foreach ($PurchaseFailed as $key => $purchase) {
                            $this->Purchase->Create(false);
                            $this->Purchase->id = $purchase['Purchase']['id'];
                            $this->Purchase->saveField("state",6);
                            if($purchase['Purchase']['pay_type'] == 2){
                                $this->set_balance($purchase['Purchase']['buyer_id'],$purchase['Purchase']['offers'], "buy_product_failed", $purchase['Purchase']['id']);
                            }
                        }
                    }
                    elseif($data['state'] == "failed"){
                        $this->Purchase->saveField("state","5");
                        $purchase = $this->Purchase->read(null,$data['purchase_id']);
                        if($purchase['Purchase']['pay_type'] == 2){
                            $this->set_balance($purchase['Purchase']['buyer_id'],$purchase['Purchase']['offers'], "buy_product_failed", $purchase['Purchase']['id']);
                        }
                    }
                    else{
                        $this->error(1004);
                        return;
                    }

                }
                $this->output($this->body);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }
    public function get_list_purchase(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','index','count','state');
            $allow_items = array(
                'string' => array('token','state'),
                'numberic'  => array(
                    '>0' => array('count'),
                    '>=0' => array('index'),
                    ));
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                if($check['User']['role'] !="admin" && $check['User']['role'] !="shipper"){
                     $this->error(1009);
                    return; 
                }
                $user_id = $check['UserSession']['login_id'];
                $this->loadModel("Purchase");
                if($data['state'] =="accept"){
                    $conditions =  array(
                       'state' => 1);
        
                }
                elseif($data['state'] =="shipping"){
                    $conditions =  array(
                        'state' => 2);
                }
                else{
                    $this->error(1004);
                    return;
                }
                $Purchases = $this->Purchase->find("all",array(
                    "conditions" => $conditions,
                    "order" => array("Purchase.modified"),
                    "offset" => $data['index'],
                    "limit" => $data['count'],
                    "recursive" => 0,
                ));
                if(!$Purchases){
                    $this->error(9994);
                    return;
                }

                foreach ($Purchases as $key => $Purchase) {
                    $return[$key]["id"] = $Purchase['Purchase']['id'];
                    $return[$key]['Product']["id"] = $Purchase['Purchase']['product_id'];
                    $return[$key]['Product']["name"] = $Purchase['Product']['name'];
                    $return[$key]['Product']["offers"] = $Purchase['Purchase']['offers'];
                    $return[$key]['Product']["pay_type"] = $Purchase['Purchase']['pay_type'];
                    
                    $Seller = $this->User->find("first",array(
                        "conditions" => array(
                            "id" => $Purchase['Product']['seller_id']),
                        "fields" => array("id","username","phonenumber",)));
                    $return[$key]["Seller"] = $Seller['User'];

                    $Buyer = $this->User->find("first",array(
                        "conditions" => array(
                            "id" => $Purchase['Purchase']['buyer_id']),
                        "fields" => array("User.id","User.username","User.phonenumber")));
                    $return[$key]["Buyer"] = $Buyer['User'];
                    $return[$key]["Buyer"]['firstname'] = $Purchase['Purchase']['firstname'];
                    $return[$key]["Buyer"]['lastname'] = $Purchase['Purchase']['lastname'];
                    $return[$key]["Buyer"]['address'] = $Purchase['Purchase']['address'];
                    $return[$key]["Buyer"]['city'] = $Purchase['Purchase']['city'];
                }

                $this->body['data'] = $return;
                $this->output($this->body);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }
    ##############################################################

    public function get_list_followed() {
        if($this->request->is('post')) {
            $check_items = array('user_id','index','count');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                 '>0' => array('user_id','count'),
                 '>=0' => array('index'))
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $this->loadModel('User');
            $user = $this->User->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'User.id' => $data['user_id']
                    )
                )
            );

            if($user) {
                $this->loadModel('UserFollow');
                $result = $this->UserFollow->find('all',
                    array(
                        'recursive' => 1,
                        'conditions' => array(
                            'UserFollow.followee_id' => $data['user_id']
                        ),
                        'fields' => array('Follower.id', 'Follower.username', 'Follower.avatar'),
                        'offset' => $data['index'],
                        'limit' => $data['count'],
                    )
                );

                if($result) {
                    $result = Set::extract('/Follower/.',$result);
                    if(isset($data['token'])) {
                        $logged = $this->UserSession->find('first',
                            array(
                                'recursive' => -1,
                                'conditions' => array(
                                    'UserSession.token' => $data['token']
                                )
                            )
                        );
                        if($logged) {
                            foreach($result as $key => $value) {
                                $check = $this->UserFollow->find('first',
                                    array(
                                        'recursive' => -1,
                                        'conditions' => array(
                                            'UserFollow.followee_id' => $value['id'],
                                            'UserFollow.follower_id' => $logged['UserSession']['login_id']
                                        )
                                    )
                                );
                                if($check) {
                                    $result[$key]['followed'] = 1;
                                } else {
                                    $result[$key]['followed'] = 0;
                                }
                            }
                        } else {
                            $this->error('9998');
                            return;
                        }
                    } else {
                        foreach($result as $key => $value) {
                            $result[$key]['followed'] = 0;
                        }
                    }
                    $this->body['data'] = $result;
                    $this->output($this->body);
                    return;
                } else {
                    $this->error('9994');
                    return;
                }
            } else {
                $this->error('1004');
                return;
            }
        } else {
            $this->error('9997');
            return;
        }
    }

    // Lấy danh sách những người mà User_id đang theo dõi
    public function get_list_following() {
        if($this->request->is('post')) {
            $check_items = array('user_id','index','count');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>0' => array('user_id','count'),
                    '>=0' => array('index'))
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $this->loadModel('User');
            $user = $this->User->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'User.id' => $data['user_id']
                    )
                )
            );
            if($user) {
                $this->loadModel('UserFollow');
                $result = $this->UserFollow->find('all',
                    array(
                        'recursive' => 1,
                        'conditions' => array(
                            'UserFollow.follower_id' => $data['user_id']
                        ),
                        'fields' => array('Followee.id', 'Followee.username', 'Followee.avatar'),
                        'offset' => $data['index'],
                        'limit' => $data['count'],
                    )
                );
                if($result) {
                    $result = Set::extract('/Followee/.',$result);
                    if(isset($data['token'])) {
                        $logged = $this->UserSession->find('first',
                            array(
                                'recursive' => -1,
                                'conditions' => array(
                                    'UserSession.token' => $data['token']
                                )
                            )
                        );
                        if($logged) {
                            foreach($result as $key => $value) {
                                $check = $this->UserFollow->find('first',
                                    array(
                                        'recursive' => -1,
                                        'conditions' => array(
                                            'UserFollow.follower_id' => $logged['UserSession']['login_id'],
                                            'UserFollow.followee_id' => $value['id']
                                        )
                                    )
                                );
                                if($check) {
                                    $result[$key]['followed'] = 1;
                                } else {
                                    $result[$key]['followed'] = 0;
                                }
                            }
                        } else {
                            $this->error('9998');
                            return;
                        }
                    } else {
                        foreach($result as $key => $value) {
                            $result[$key]['followed'] = 0;
                        }
                    }
                    $this->body['data'] = $result;
                    $this->output($this->body);
                    return;
                } else {
                    $this->error('9994');
                    return;
                }
            } else {
                $this->error('1004');
                return;
            }
        } else {
            $this->error('9997');
            return;
        }
    }

    public function get_deposit_history() {
        if($this->request->is('POST')) {
            $check_items = array('token', 'index', 'count');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>=0' => array('index'),
                    '>0' => array('count')
                )
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $this->loadModel('User');
            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if($logged) {
                $this->loadModel("UserWithdraw");
                $result = $this->UserWithdraw->find('all',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'UserWithdraw.user_id' => $logged['UserSession']['login_id']
                        ),
                        'order' => 'UserWithdraw.created DESC',
                        'offset' => $data['index'],
                        'limit' => $data['count'],
                        'fields' => array('UserWithdraw.id','UserWithdraw.balance', 'UserWithdraw.bank_name', 'UserWithdraw.created','UserWithdraw.state')
                    )
                );
                if($result) {
                    $result = Set::extract('/UserWithdraw/.',$result);
                    foreach($result as $key => $value) {
                        $result[$key]['date'] = strtotime($result[$key]['created']);
                        unset($result[$key]['created']);
                    }
                    $this->body['data'] = $result;
                    $this->output($this->body);
                    return;
                } else {
                    $this->error('9994');
                    return;
                }
            } else {
                $this->error('9998');
                return;
            }

        } else {
            $this->error('9997');
            return;
        }
    }

    public function get_deposit_detail() {
        if($this->request->is('POST')) {
            $check_items = array('token', 'UserWithdraw_id');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>0' => array('UserWithdraw_id')
                )
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $this->loadModel('User');
            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if($logged) {
                $this->loadModel("UserWithdraw");
                $result = $this->UserWithdraw->find('first',
                    array(
                        'recursive' => -1,
                        'conditions' => array(
                            'UserWithdraw.id' => $data['UserWithdraw_id'],
                            'UserWithdraw.user_id' => $logged['UserSession']['login_id'],
                        ),
                        'fields' => array('UserWithdraw.id','UserWithdraw.holder', 'UserWithdraw.balance', 'UserWithdraw.bank_name','UserWithdraw.bank_number','UserWithdraw.bank_address', 'UserWithdraw.created','UserWithdraw.modified','UserWithdraw.state')
                    )
                );
                if($result) {
                    $result = Set::extract('/UserWithdraw/.',$result);
                    $this->body['data'] = $result;
                    $this->output($this->body);
                    return;
                } else {
                    $this->error('1004');
                    return;
                }
            } else {
                $this->error('9998');
                return;
            }

        } else {
            $this->error('9997');
            return;
        }
    }

    public function change_password(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token','password','new_password');
            $allow_items = array(
                'string' => array('token','password','new_password'),
                );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                
                $old_password = $this->Auth->password($data['password']);
                if($old_password != $check['User']['password']){
                    $this->error(1004);
                    return;
                }
                $save = array(
                    "id" => $check['User']['id'],
                    "password" => $data['new_password']
                );
                
                if($this->User->save($save)){
                    $this->output($this->body);
                    return;
                }

                $this->error(1004);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function get_push_setting(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token');
            $allow_items = array(
                'string' => array('token'),
                );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $push_setting = $this->_get_push_setting($check['UserSession']['login_id']);
                $this->body['data'] = $push_setting;
                $this->output($this->body);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function set_push_setting(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>=0' => array('like','comment','transaction','announcement'),
                    '<=1' => array('like','comment','transaction','announcement'),
                    )
                );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }

                $new_setting = $data;
                unset($new_setting['token']);
                $new_setting['user_id'] = $check['User']['id'];
                $this->loadModel("UserPush");
                if($this->UserPush->save($new_setting)){
                    $this->output($this->body);
                    return;
                }
                $this->error(1004);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function get_user_setting(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token');
            $allow_items = array(
                'string' => array('token'),
                );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }
                $UserSetting = $this->_get_user_setting($check['UserSession']['login_id']);
                $this->body['data'] = $UserSetting;
                $this->output($this->body);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }

    public function set_user_setting(){
        if(!$this->request->is('post')) {
            $this->error(9997);
            return;
        }
         $check_items = array('token');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>=0' => array('auto_with_draw','vacation_mode'),
                    '<=1' => array('auto_with_draw','vacation_mode'),
                    )
                );
            if ($this->validate_param($check_items) == false)
                return;
            $data = $this->request->data;
            if(!$this->check_param($allow_items,$data)) return;

            try{
                $check = $this->UserSession->find('first',array('conditions' => array(
                    'token' => $data['token']),
                'recursive' => 0
                ));
                if(!$check){
                    $this->error(9998);
                    return;
                }

                $new_setting = $data;
                unset($new_setting['token']);
                $new_setting['user_id'] = $check['User']['id'];
                $this->loadModel("UserSetting");
                if($this->UserSetting->save($new_setting)){
                    $this->output($this->body);
                    return;
                }
                $this->error(1004);
                return;

            } catch (Exception $e) {
                $message = $e->getMessage();
                $this->error_detail(9999, $message);
            }
    }
    public function get_order_status() {
        if($this->request->is('POST')) {
            $check_items = array('token');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>=0' => array('product_id','purchase_id')
                )
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if($logged) {
                if(isset($data['product_id']) && $data['product_id'] !=""){
                    $cProduct = $this->Product->find("first", array(
                        "conditions" => array(
                            "id" => $data['product_id']
                            )));
                    if(!$cProduct){
                        $this->error(1004);
                        return;
                    }
                    $conditions['Purchase.product_id'] = $data['product_id'];
                    if($cProduct['Product']['seller_id'] == $logged['UserSession']['login_id']){
                        //seller
                        $conditions['Purchase.state >'] = 0;
                        $conditions['Purchase.state <='] = 4;
                    }
                    else{
                        //buyer
                        $conditions['Purchase.buyer_id'] = $logged['UserSession']['login_id'];
                    }
                }
                elseif(isset($data['purchase_id']) && $data['purchase_id'] !=""){
                    $conditions['Purchase.id'] = $data['purchase_id'];
                }
                else{
                    $this->error(1002);
                    return;
                }
                $this->loadModel('Purchase');
                $product = $this->Purchase->find('first',
                    array(
                        'conditions' => $conditions,
                        'recursive' => -1,
                        'contain' => array('Product'),
                        'fields' => array(
                            'Purchase.id',
                            'Purchase.created',
                            'Purchase.offers',
                            'Purchase.city as ships_to',
                            'Purchase.address',
                            'Purchase.state',
                            'Purchase.ship_fee',
                           
                            'Product.id',
                            'Product.ships_from',
                            'Product.name',
                            'Product.seller_id',

                        )
                    )
                );
                if($product) {
                    $data['product_id'] = $product['Product']['id'];
                    unset($product['Product']['id']);
                    $this->loadModel('ProductOtherImage');
                    $productImages = $this->ProductOtherImage->find('all',
                        array(
                            'conditions' => array(
                                'ProductOtherImage.product_id' => $data['product_id']
                            ),
                            'recursive' => -1,
                        )
                    );
                    if($productImages) {
                        $product['Product']['image'] = $productImages[0]['ProductOtherImage']['image'];
                    } else {

                    }
                    $product['Purchase']['ships_to'] = $product['Purchase']['address'].", ".$product['Purchase']['ships_to'];
                    unset($product['Purchase']['address']);
                    $product['Purchase']['state'] = $this->state_purchase[$product['Purchase']['state']];
                    if($logged['UserSession']['login_id'] == $product['Product']['seller_id']){
                        $product['Product']['is_seller'] = 1;
                    }
                    else{
                        $product['Product']['is_seller'] = 0;
                    }
                    unset($product['Product']['seller_id']);
                    //get history
                    $this->loadModel("PurchaseStatusHistory");
                    $listHistory = $this->PurchaseStatusHistory->find("all", array("conditions" => array(
                        "purchase_id" => $product['Purchase']['id']),
                        "fields" => array("status_code","created"),
                        "order" => "created ASC"));

                    $listHistory = Set::extract("/PurchaseStatusHistory/.",$listHistory);
                    foreach ($listHistory as $key => $history) {
                        //kiem tra trang thai 4 hoac 5;
                        if($history['status_code'] == 4 && !$product['Product']['is_seller']){
                            unset($listHistory[$key]);
                            continue;
                        }
                        if($history['status_code'] == 5){
                            if($product['Product']['is_seller']){
                                unset($listHistory[$key]);
                                continue;
                            }
                            else{
                                $listHistory[$key]['status_code'] = 4;
                                $history['status_code'] = 4; 
                            }
                        }
                        $listHistory[$key]['status_name'] = $this->state_purchase[$history['status_code']];
                    }
                    ##############TRacking code ###################
                    $this->loadModel("Tracking");
                    $TrackingCode = $this->Tracking->find("first",array("conditions" => array(
                        "purchase_id" => $product['Purchase']['id'])));
                    if($TrackingCode){
                        $this->body['data']['TrackingCode'] = $TrackingCode['Tracking']['tracking_code'];
                    }
                    else{
                        $this->body['data']['TrackingCode'] = "";
                    }
                    $this->body['data'] += $product['Purchase'];
                    $this->body['data'] += $product['Product'];
                    
                    $this->body['data']['commission'] = 0;
                    $this->body['data']['state_history'] = array_values($listHistory);
                    $this->output($this->body);
                    return;
                } else {
                    $this->error(9994);
                    return;
                }
            } else {
                $this->error(9998);
                return;
            }
        } else {
            $this->error(9997);
            return;
        }
    }
    public function get_rating_data() {
        if($this->request->is('POST')) {
            $check_items = array('token','product_id');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>0' => array('product_id')
                )
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $check = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if($check) {
                    $this->loadModel("Purchase");
                    $Purchase = $this->Purchase->find("first",array(
                        "conditions" => array(
                            "product_id" => $data['product_id'],
                            "Purchase.state" => 3,
                        ),
                        "contain" => array("Product"),
                        ));
                    if(!$Purchase){
                        $this->error(1004);
                        return;
                    }
                    $this->loadModel("ProductOtherImage");
                    $Images = $this->ProductOtherImage->find("first", array(
                        "conditions" => array(
                            "product_id" => $data['product_id'],
                            )));
                    if(!$Images){
                        $Images['ProductOtherImage']['url'] = "";
                    }
                    $ret = array(
                        "id" => $Purchase['Product']['id'],
                        "name" => $Purchase['Product']['name'],
                        "image" => $Images['ProductOtherImage']['image'],
                        "is_seller" => ($check['UserSession']['login_id'] == $Purchase['Product']['seller_id'] ? "1" : "0"),
                        );
                    $this->body['data'] = $ret;
                    $this->output($this->body);
                    return;
            } else {
                $this->error(9998);
                return;
            }
        } else {
            $this->error(9997);
            return;
        }
    }

    public function check_new_version() {
        if($this->request->is('POST')) {
            $allow_items = array(
                'string' => array('token',"last_update"),
            );
           
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $this->loadModel("AppSetting");
            //get current version
            $version = $this->AppSetting->find("first", array(
                "conditions" => array("code" => "APP_VERSION")
                ));
            if($version){
                $version = Set::extract('/AppSetting/.',$version);
                $this->body['data']['Version'] = json_decode($version);
            }
            else{
                $version["version"] = "1.0";
                $version["require"] = "0";
                $version["url"] = "http://xxxx.com";

                $this->body['data']['Version'] = $version;
            }
            
            //check lock account
            if(isset($data['token'])){
                $cUser = $this->UserSession->find("first", array(
                    "conditions" => array("token" => $data['token']),
                    "contain" => array('User'),
                    "fields" => array("User.id", "User.active")));
                if(!$cUser){
                    $this->error(9998);
                    return;
                }
                //count notification
                if(isset($data['last_update'])){
                    $time = @date("Y-m-d H:i:s",$data['last_update']);
                    $this->loadModel("NotificationUser");
                    $Notification = new NotificationController;

                    $list = $Notification->getNotificationbyUserID($cUser['User']['id'],0,100,$time);
                   // pr($list);
                    $badge = count($list);
                    $this->body['data']['badge'] = $badge;
                }
                $this->body['data']['User'] = $cUser['User'];
                $this->body['data']['now'] = time();

            }


            $this->output($this->body);

            return;
        } else {
            $this->error(9997);
            return;
        }
    }
    public function get_ship_fee() {
        if($this->request->is('POST')) {
            $check_items = array('token','product_id',"city_id","province_id","ward_id");

            
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    ">0" => array("product_id","city_id","province_id","ward_id","pay_type"),
                    ),
            );
           
            $data = $this->request->data;
            if ($this->validate_param($check_items) == false) {
                return;
            }
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $config_Ship = array(
                "CoD" => 1,
                "Payment" => 2,
            );
            if(isset($data['pay_type']) && $data['pay_type'] == 2){
                        $config_Ship = array(
                            "CoD" => 2,
                            "Payment" => 1,
                            );
            }
            $ShipFee = $this->ShipChung->getShipFee($data['product_id'],$data,$config_Ship);
            if(!$ShipFee){
                $this->error(1012);
                return;
            }
            
            $this->body['data'] = $ShipFee;
            $this->output($this->body);

            return;
        } else {
            $this->error(9997);
            return;
        }
    }
    public function get_list_conversation() {
        if($this->request->is('POST')) {
            $check_items = array('token','index',"count");
            
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    ">=0" => array("index"),
                    ">0" => array("count"),
                    ),
            );
            $data = $this->request->data;
            
            if ($this->validate_param($check_items) == false) {
                return;
            }
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $check = $this->UserSession->find("first", array(
                "conditions" => array(
                    "token" => $data['token'])));
            if(!$check){
                $this->error(9998);
                return;
            }
            $user_id = $check['UserSession']['login_id'];
            $this->loadModel("Conversation");
            $cConversation = $this->Conversation->find("all", array(
                "conditions" => array(
                    "OR" => array(
                        "user_id1" => $user_id,
                        "user_id2" => $user_id,
                        ),
                    ),
                "order" => "Conversation.modified DESC",
                "offset" => $data['index'],
                "limit" => $data['count'],
                ));
            if(!$cConversation){
                $this->error(9994);
                return;
            }
            $ret = array();
            $numUnread = 0;
            foreach ($cConversation as $key => $conversation) {
                $partner_id = 0;
                if($conversation['Conversation']['user_id1'] == $user_id){
                    $partner_id = $conversation['Conversation']['user_id2'];
                }
                else{
                    $partner_id = $conversation['Conversation']['user_id1'];
                }
                $partner = $this->User->read(null,$partner_id);
                $product = $this->Product->find('first', array(
                    "conditions" => array("Product.id" => $conversation['Conversation']['product_id']),
                    "contain" => "ProductOtherImage"));
                $this->loadModel("ConversationDetail");
                $lastMessage = $this->ConversationDetail->find("first", array(
                    "conditions" => array(
                        "conversation_id" => $conversation['Conversation']['id']),
                    "order" => "created DESC"));
                $ret[] = array(
                    "id" => $conversation['Conversation']['id'],
                    "Partner" => array(
                        "id" => $partner['User']['id'],
                        "username" => $partner['User']['username'],
                        "avatar" => $partner['User']['avatar'],
                        ),
                    "Product" => array(
                        "id" => $product['Product']['id'],
                        "image" => $product['ProductOtherImage'][0]['image'],
                        "name" => $product['Product']['name'],
                        "price" => $product['Product']['price'],
                        ),
                    "LastMessage" => array(
                            "message" => $lastMessage['ConversationDetail']['messages'],
                            "unread" => $lastMessage['ConversationDetail']['unread'],
                            "created" => $lastMessage['ConversationDetail']['created'],
                        ),
                );
                if($lastMessage['ConversationDetail']['unread']) $numUnread++;

            }
                $this->body['data'] = array(
                    "conversations" => $ret,
                    "numNewMessage" => $numUnread,
                );
                $this->output($this->body);
                return;
           
        } else {
            $this->error(9997);
            return;
        }
    }

    public function set_conversation() {
        if($this->request->is('POST')) {
            $check_items = array('from_id','to_id',"messages","status");
            
            $allow_items = array(
                'string' => array('messages',"status"),
                'numberic' => array(
                    ">0" => array("product_id","from_id","to_id"),
                    ),
            );
            $data = $this->request->data;
            
            if ($this->validate_param($check_items) == false) {
                return;
            }
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            if(!isset($data['product_id'])){
                $data['product_id'] = 0;
            }
            $this->loadModel("Conversation");
            $cConversation = $this->Conversation->find("first", array(
                "conditions" => array(
                    "OR" => array(
                        array("user_id1" => $data['from_id'], "user_id2" => $data['to_id']),
                        array("user_id2" => $data['from_id'], "user_id1" => $data['to_id'])
                        ),
                    "product_id" => $data['product_id']
                    )));
            //echo $this->Conversation->getLastQuery();
            if(!$cConversation){
                $this->Conversation->Create();
                $save = array(
                    "user_id1" => $data['from_id'],
                    "user_id2" => $data['to_id'],
                    "product_id" => $data['product_id']);
                if($this->Conversation->save($save)){
                    $conversation_id = $this->Conversation->id;
                }
                else{
                    $this->error(1005);
                    return;
                }
            }else{
                $conversation_id = $cConversation['Conversation']['id'];
            }
            $this->loadModel("ConversationDetail");
            $save_conversation = array("conversation_id" => $conversation_id,
                    "sender_id" => $data['from_id'],
                    "messages" => $data['messages'],
                    "unread" => (trim($data['status']) == 'OFFLINE')? "1": "0" //neu dang offline => set la chua doc mess
            );

            if($this->ConversationDetail->save($save_conversation)){
                
                if(trim($data['status']) == 'OFFLINE'){
                    $this->loadModel("Product");
                    $cProduct = $this->Product->find("first", array(
                        "conditions" => array("id" => $data['product_id']),
                        "contain" => "ProductOtherImage"));
                    if($cProduct){
                        $seller_id = $cProduct['Product']['seller_id'];
                    }
                    else{
                        $seller_id = 0;
                    }
                    $Notification = new NotificationController;
                     $push_info = array(
                        "type" => "messages",
                        "from_id" => $data['from_id'],
                        "product_id" => $data['product_id'],
                        "seller_id" => $seller_id,
                        "conversation_id" => $conversation_id,
                        "product_name" => $cProduct['Product']['name'],
                        "product_price" => $cProduct['Product']['price'],
                        "product_image" => $cProduct['ProductOtherImage'][0]['image'],
                    );
        //             CakeLog::write('debug',print_r($push_info,true));
                    $this->send_notifications($data['to_id'],$data['messages'],0,'',$push_info);
                }
                else{
          //          CakeLog::write('debug',"error");
                }
                $this->output($this->body);
                return;
            }
            else{
                $this->error(1004);
                return;
            }
        } else {
            $this->error(9997);
            return;
        }
    }

    public function get_conversation(){
        if($this->request->is('POST')) {
            $check_items = array("token","index","count");
            
            $allow_items = array(
                "string" => array("token"),
                'numberic' => array(
                    ">=0" => array("index","product_id"),
                    ">0" => array("partner_id","conversation_id","count"),
                    ),
            );
           
            $data = $this->request->data;
            if ($this->validate_param($check_items) == false) {
                return;
            }
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $check = $this->UserSession->find("first", array("conditions" => 
                array(
                    "token" => $data['token'],
                )));
            if(!$check){
                $this->error(9998);
                return;
            }
            $this->loadModel("Conversation");
            if(!isset($data['conversation_id'])){
                if(!isset($data['product_id']) || !isset($data['partner_id'])){
                    $this->error(1002);
                    return;
                }
                $cProduct = $this->Product->find("first", array("conditions" => array(
                    "id" => $data['product_id'])));
                if(!$cProduct){
                    $this->error(1004);
                    return;
                }
                if($cProduct['Product']['seller_id'] != $check['UserSession']['login_id'] && $cProduct['Product']['seller_id'] != $data['partner_id']){
                    $this->error(1009);
                    return;
                }

                $cConversation = $this->Conversation->find("first", array(
                    "conditions" => array(
                        "OR" => array(
                            array("user_id1" => $check['UserSession']['login_id'], "user_id2" => $data['partner_id']),
                            array("user_id1" => $data['partner_id'], "user_id2" => $check['UserSession']['login_id'])
                            ),
                        "product_id" => $data['product_id']
                        )));
                if(!$cConversation){
                    $this->error(9994);
                    return;
                }
                $data['conversation_id'] = $cConversation['Conversation']['id'];
            }
            else{
                $cConversation = $this->Conversation->find("first", array(
                    "conditions" => array(
                        "id" => $data['conversation_id'],
                        "OR" => array(
                            "user_id1" => $check['UserSession']['login_id'],
                            "user_id2" => $check['UserSession']['login_id'],
                            ),
                        )));
                if(!$cConversation){
                    $this->error(1004);
                    return;
                }
                $data['product_id'] = $cConversation['Conversation']['product_id'];
            }
            $this->loadModel("ConversationDetail");
            $Conversations = $this->ConversationDetail->find("all",array(
                "conditions" => array("conversation_id" => $data['conversation_id']),
                "order" => "ConversationDetail.created desc",
                "offset" => $data['index'],
                "limit" => $data['count'],
                "recursive" => 0
                ));
            if(!$Conversations){
                $this->error(9994);
                return;
            }
            //danh dau la da doc cho tat ca cac tin nhan cua cuoc hoi thoai
            $this->ConversationDetail->updateAll(array("unread" => "0"),array("conversation_id" => $data['conversation_id'],"unread" => "1"));
            ######################
            $ret = array();
            foreach ($Conversations as $key => $message) {
                $ret["conversation"][$key]['message'] = $message['ConversationDetail']['messages'];
                $ret["conversation"][$key]['unread'] = $message['ConversationDetail']['unread'];
                $ret["conversation"][$key]['created'] = $message['ConversationDetail']['created'];
                $ret["conversation"][$key]['sender'] = array(
                    "id" => $message['ConversationDetail']['sender_id'],
                    "username" => $message['User']['username'],
                    );
            }
            //thong tin product
            /*
            $this->loadModel("Product");
            $cProduct = $this->Product->find("first", array(
                "conditions" => array(
                    "Product.id" => $data['product_id']),
                "recursive" => 1));
            if(!$cProduct){
                $ret['Product']['name'] = "";
                $ret['Product']['price'] = "0";
                $ret['Product']['images'] = "";
                $ret['Product']['seller_id'] = "0";
            }
            else{
                $ret['Product']['seller_id'] = $cProduct['Product']['seller_id'];
                $ret['Product']['name'] = $cProduct['Product']['name'];
                $ret['Product']['price'] = $cProduct['Product']['price'];
                if(isset($cProduct['ProductOtherImage'][0]['image']))
                    $ret['Product']['image'] = $cProduct['ProductOtherImage'][0]['image'];
                else
                    $ret['Product']['image'] = "";
            }
            $this->loadModel("Purchase");
            $product_state = $this->Purchase->find("all",array(
                        "conditions" => array("product_id" => $data['product_id'],
                                                "state >=" => 0,
                                                "state <=" => 4),
                        "fields" => array("Max(state) as pState")));
            if($product_state[0][0]['pState'] > 1){
                $ret['Product']['state'] = 2;
            }
            elseif($product_state[0][0]['pState'] == 1){
                $ret['Product']['state'] = 1;
            }
            else{
                $this->loadModel("PurchaseAcceptOffer");
                $ExistOffers = $this->PurchaseAcceptOffer->find("first", array(
                    "conditions" => array(
                        "product_id" => $data['product_id'])));
                if($ExistOffers){
                    $ret['Product']['state'] = 1;
                }
                else{
                    $ret['Product']['state'] = 0;
                }
            }*/
            $this->body['data'] = $ret;
            $this->output($this->body);
        } else {
            $this->error(9997);
            return;
        }
    }

    public function get_conversation_detail(){
        if($this->request->is('POST')) {
            $check_items = array("token","partner_id","product_id");
            
            $allow_items = array(
                "string" => array("token"),
                'numberic' => array(
                    ">0" => array("partner_id","product_id"),
                    ),
            );
           
            $data = $this->request->data;
            if ($this->validate_param($check_items) == false) {
                return;
            }
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $check = $this->UserSession->find("first", array("conditions" => array(
                "token" => $data['token'])));
            if(!$check){
                $this->error(9994);
                return;
            }
            $this->loadModel("Conversation");
            $cConversation = $this->Conversation->find("first", array(
                "conditions"=> array(
                    "product_id" => $data['product_id'],
                    "OR" => array(
                        array("user_id1" => $data['partner_id'], "user_id2" => $check['UserSession']['login_id']),
                        array("user_id2" => $data['partner_id'], "user_id1" => $check['UserSession']['login_id']),
                        ),
                    ),
                ));
            if(!$cConversation){
                $this->error(1004);
                return;
            }
            $this->loadModel("Product");
            $cPartner = $this->User->find("first",array(
                "conditions" => array(
                    "User.id" => $data['partner_id']),
                "fields" => array("id","username","avatar")));

            $cProduct = $this->Product->find("first",array(
                "conditions" => array(
                    "Product.id" => $data['product_id']),
                "contain" => array("ProductOtherImage"),
                
                ));
            if(!$cPartner){
                $this->error(1004);
                return;
            }
            if(!$cProduct){
                $this->error(1004);
                return;
            }

            

            $ret["Partner"] = $cPartner['User'];
            $ret["Product"] = array(
                "id" => $cProduct['Product']['id'],
                "name" => $cProduct['Product']['name'],
                "price" => $cProduct['Product']['price'],
                "image" => $cProduct['ProductOtherImage'][0]['image'],
            );
            //check accept offer
            $buyer_id = $check['UserSession']['login_id'];
            if($data['partner_id'] != $cProduct['Product']['seller_id']){
                $buyer_id = $data['partner_id'];
            }
            $this->loadModel("PurchaseAcceptOffer");
            $cAcceptOffer = $this->PurchaseAcceptOffer->find("first", array(
                "conditions" => array(
                    "product_id" => $data['product_id'],
                    "buyer_id" => $buyer_id),
                "order" => array("modified DESC"),
                ));
            if($cAcceptOffer){
                $ret['LastOffers'] = array(
                    "offers" => $cAcceptOffer['PurchaseAcceptOffer']['offers'],
                    "state" => $cAcceptOffer['PurchaseAcceptOffer']['approve']
                );
            }
            else{
                $ret['LastOffers'] = array(
                    "offers" => "",
                    "state" => ""
                );
            }
            
            $this->body['data'] = $ret;
            $this->output($this->body);
        } else {
            $this->error(9997);
            return;
        }
    }

    public function get_list_order_address() {
        if($this->request->is('POST')) {
            $check_items = array('token');
            $allow_items = array(
                'string' => array('token'),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserOrderAddress");
            $listAddr = $this->UserOrderAddress->find("all", array(
                "conditions" => array(
                    "user_id" => $user_id),
                "fields" => array("id","address","address_id","default")));
            if(!$listAddr){
                $this->error(9994);
                return;
            }
            $listAddr = Set::extract("/UserOrderAddress/.",$listAddr);
            foreach ($listAddr as $key => $Addr) {
                $listAddr[$key]['address_id'] = json_decode($listAddr[$key]['address_id']);
            }
            
            $this->body['data'] = $listAddr;
            $this->output($this->body);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    public function add_order_address() {
        if($this->request->is('POST')) {
            $check_items = array('token','address','address_id');
            $allow_items = array(
                'string' => array('token','address'),
                'numberic' => array(
                    '>=0' => array('default')
                ),
                'array' => array('address_id')
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserOrderAddress");
            $listAddr = $this->UserOrderAddress->find("first", array(
                "conditions" => array(
                    "user_id" => $user_id,
                    "address" => $data['address']),
            ));
            if($listAddr){
                $this->error(1010);
                return;
            }
            if(count($data['address_id']) != 3){
                $this->error(1004);
                return;
            }
            $data['address_id'] = json_encode($data['address_id']);
            if(isset($data['default']) && $data['default'] == 1){
                $this->UserOrderAddress->updateAll(array('default' => 0), array('user_id' => $user_id));
            }
            $this->UserOrderAddress->Create(false);
            unset($data['token']);
            $data['user_id'] = $user_id;
            if($this->UserOrderAddress->save($data)){
                $this->body['data']['id'] = $this->UserOrderAddress->id;
                $this->output($this->body);
                return;
            }
            $this->error(1005);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    public function edit_order_address() {
        if($this->request->is('POST')) {
            $check_items = array('token','id');
            $allow_items = array(
                'string' => array('token','address'),
                'numberic' => array(
                    '>=0' => array('default'),
                    '>0' => array('id'),
                ),
                'array' => array('address_id')
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserOrderAddress");
            $cAddr = $this->UserOrderAddress->find("first", array(
                "conditions" => array(
                    "id" => $data['id'],
                    "user_id" => $user_id),
            ));
            if(!$cAddr){
                $this->error(1004);
                return;
            }
            if(isset($data['address'])){
                if(!isset($data['address_id'])){
                    $this->error(1002);
                    return;
                }
                $listAddr = $this->UserOrderAddress->find("first", array(
                "conditions" => array(
                    "user_id" => $user_id,
                    "address" => $data['address'],
                    "id !=" => $data['id']),
                ));
                if($listAddr){
                    $this->error(1010);
                    return;
                }
            }
            
            if(isset($data['address_id'])){
                if(count($data['address_id']) != 3){
                    $this->error(1004);
                    return;
                }
                $data['address_id'] = json_encode($data['address_id']);
            }
            
            if(isset($data['default']) && $data['default'] == 1){
                $this->UserOrderAddress->updateAll(array('default' => 0), array('user_id' => $user_id));
            }
            $this->UserOrderAddress->Create(false);
            unset($data['token']);
            $data['user_id'] = $user_id;
            if($this->UserOrderAddress->save($data)){
                $this->output($this->body);
                return;
            }
            $this->error(1005);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    public function check_promotion_code() {
        if($this->request->is('POST')) {
           $check_items = array('product_id','promotion_code');
            $allow_items = array(
                'string' => array('promotion_code'),
                "numberic" => array(
                    "> 0" => array("product_id"),
                    ),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }
            $this->loadModel("PromotionCategory");
            $cProduct = $this->Product->read(null,$data['product_id']);
            $cPromotion = $this->PromotionCategory->find("first", array(
                "conditions" => array(
                    "code" => $data['promotion_code'],
                    "approve" => 1,
                    "PromotionCategory.category_id" => $cProduct['Product']['category_id']),
                "contain" => array("Promotion")));
            if(!$cPromotion){
                $this->error(1004);
                return;
            }
            if($cPromotion['Promotion']['used'] == $cPromotion['Promotion']['quantity'] || $cPromotion['Promotion']['endtime'] < date("Y-m-d H:i:s")){
                $this->error(1014);
                return;
            }

            $this->body['data']['discount'] = $cPromotion['Promotion']['discount'];
            $this->output($this->body);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    public function delete_order_address() {
        if($this->request->is('POST')) {
            $check_items = array('token','id');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>0' => array('id'),
                ),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserOrderAddress");
            $cAddr = $this->UserOrderAddress->find("first", array(
                "conditions" => array(
                    "id" => $data['id'],
                    "user_id" => $user_id),
            ));
            if(!$cAddr){
                $this->error(1004);
                return;
            }
            $this->UserOrderAddress->Create(false);
            if($this->UserOrderAddress->delete($data['id'])){
                $this->output($this->body);
                return;
            }
            $this->error(1005);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    ################### user bank ######################
    public function get_list_user_bank() {
        if($this->request->is('POST')) {
            $check_items = array('token');
            $allow_items = array(
                'string' => array('token'),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserBank");
            $listBank = $this->UserBank->find("all", array(
                "conditions" => array(
                    "user_id" => $user_id),
                "fields" => array("id","holder","card_number","bank_name","bank_address")));
            if(!$listBank){
                $this->error(9994);
                return;
            }
            $listBank = Set::extract("/UserBank/.",$listBank);
           
            $this->body['data'] = $listBank;
            $this->output($this->body);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    public function add_user_bank() {
        if($this->request->is('POST')) {
            $check_items = array('token',"holder","card_number","bank_name","bank_address");
            $allow_items = array(
                'string' => array('token',"holder","card_number","bank_name","bank_address"),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserBank");
            $cExist = $this->UserBank->find("first", array(
                "conditions" => array(
                    //"user_id" => $user_id,
                    "card_number" => $data['card_number'],
                    "bank_name" => $data['bank_name']),
            ));
            if($cExist){
                $this->error(1010);
                return;
            }

            $this->UserBank->Create(false);
            unset($data['token']);
            $data['user_id'] = $user_id;
            if($this->UserBank->save($data)){
                $this->body['data']['id'] = $this->UserBank->id;
                $this->output($this->body);
                return;
            }
            $this->error(1005);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    public function edit_user_bank() {
        if($this->request->is('POST')) {
            $check_items = array('token',"id", "holder","card_number","bank_name","bank_address");
            $allow_items = array(
                'string' => array('token',"id","holder","card_number","bank_name","bank_address"),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserBank");
            $cExist = $this->UserBank->find("first", array(
                "conditions" => array(
                    "id" => $data['id'],
                    "user_id" => $user_id),
            ));
            if(!$cExist){
                $this->error(1009);
                return;
            }
            $cExist = $this->UserBank->find("first", array(
                "conditions" => array(
                    "id !=" => $data['id'],
                    "user_id" => $user_id,
                    "card_number" => $data['card_number'],
                    "bank_name" => $data['bank_name']),
            ));
            if($cExist){
                $this->error(1010);
                return;
            }
            
            $this->UserBank->Create(false);
            unset($data['token']);
            $data['user_id'] = $user_id;
            if($this->UserBank->save($data)){
                $this->output($this->body);
                return;
            }
            $this->error(1005);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }

    public function delete_user_bank() {
        if($this->request->is('POST')) {
            $check_items = array('token','id');
            $allow_items = array(
                'string' => array('token'),
                'numberic' => array(
                    '>0' => array('id'),
                ),
            );
            if ($this->validate_param($check_items) == false) {
                return;
            }
            $data = $this->request->data;
            if (!$this->check_param($allow_items, $data, false)) {
                return;
            }

            $logged = $this->UserSession->find('first',
                array(
                    'recursive' => -1,
                    'conditions' => array(
                        'UserSession.token' => $data['token']
                    )
                )
            );
            if(!$logged){
                $this->error(9998);
                return;
            }
            $user_id = $logged['UserSession']['login_id'];
            $this->loadModel("UserBank");
            $cExist = $this->UserBank->find("first", array(
                "conditions" => array(
                    "id" => $data['id'],
                    "user_id" => $user_id),
            ));
            if(!$cExist){
                $this->error(1004);
                return;
            }
            $this->UserBank->Create(false);
            if($this->UserBank->delete($data['id'])){
                $this->output($this->body);
                return;
            }
            $this->error(1005);
            return;
        } else {
            $this->error(9997);
            return;
        }
    }
    public function test_push($id){
        
        $push_info = array(
            "action" => 'buy_products',
            "product_id" => "1"
        );
        $result = $this->send_notifications($id, "test fush", 0, '', $push_info);
        $this->body['data'] = json_decode($result);
        $this->output($this->body);
        return;
    }
    public function test_sms($phonenumber){
       // $balance = $this->Esms->getSMSstatus("10184838");
        // $balance = $this->Esms->getBalance();
        //$balance = $this->Esms->sentSMS("ngoc hip test", $phonenumber);
        $balance = $this->SMSNhanh->sentSMS("test sms nhanh",$phonenumber);
        print_r($balance);
        $this->output($this->body);
        return;
    }
    public function test_shipchung(){
       
        pr($this->ShipChung->getProvince(18,true));
       
        $this->output($this->body);
        return;
    }
    public function test_cache(){
        $x = Cache::clear(true);
        var_dump($x);
        $this->output($this->body);
        return;
    }

    public function log_error(){
        CakeLog::write('error_log_api-'.date("d-m-y"),"#################################################");
        $data = $this->request->data;
        $log = print_r($data,true);
        CakeLog::write('error_log_api-'.date("d-m-y"),$log);
        $this->output($this->body);
        return;
    }






    ############ PRIVATE FUNCTION ###############
    /*
    
    */
    /*private function getDiscount() {
        $this->loadModel("AppSetting");
        $discount = $this->AppSetting->find("first", array(
            "conditions" => array(
                "code" => "discount")
        ));
        if(!$discount) return 0;
        return $discount['AppSetting']['value'];
    }*/
    private function sentMessageToConversation($params = array()){
        /* Param: 
            product_id, user_id, message, sender_id, sender_name
        */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            "http://moki.vn:2015/cancelorder" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $params); 
        //curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
        $result=curl_exec ($ch);
        $result = json_encode($result);
        if($result->code == 200){
            return true;
        }
        return false;
    }
    private function check_param($params,&$data = null,$removeNumEmpty = 1,$removeNumZero=0,$autoUnset = 1){
        $__data = array();
        $ret = array();
        if($data!==null) $__data = $data;
        else $__data = $_POST;
        if(isset($params['string']))
        foreach ($params['string'] as $param) {
            if(isset($__data[$param])){
                if ($__data[$param] == ''){
                    if($data==null){
                       $this->error(1004);
                        return false;
                    }
                    else{
                        if($param != "status")
                            continue;
                    }
                }
                $ret[$param] = $__data[$param];
            }
        }

        if(isset($params['numberic']))
        foreach ($params['numberic'] as $condition => $child_params) {
            foreach ($child_params as $param) {
                if(isset($__data[$param])){
                    if ($__data[$param] == ''){
                        if($data===null){
                            $this->error(1004);
                            return false;
                        }
                        else{
                            if($removeNumEmpty)
                                continue;
                            else
                            $__data[$param] = 0;
                        }
                    }
                    if(!is_numeric($__data[$param])){
                        $this->error(1003);
                        return false;
                    }
                    if($removeNumZero && $__data[$param]==0){
                        continue;
                    }
                    $kt=true;
                    eval("\$kt = (".$__data[$param].$condition.");");
                    if(!$kt){
                        
                        $this->error(1004);
                        return false;
                    }
                    $ret[$param] = $__data[$param];
                }
            }
        }

        if(isset($params['array']))
        foreach ($params['array'] as $param) {
            if(isset($__data[$param])){
                if (!is_array($__data[$param]) ){
                       $this->error(1004);
                        return false;
                }
                $ret[$param] = $__data[$param];
            }
        }

        if($data!==null && $autoUnset) $data = $ret;
        return true;
    }
    private function output($body = array()) {
        //sleep(3);
        $this->viewClass = 'Webservice.Webservice';
        $this->validation($body['data']);
       //
        $log = print_r($body['data'], true);
       /* CakeLog::write('response',"----------------------------------------------------------");
        CakeLog::write('response',$log);*/
        $this->set(compact('body'));
    }

    private function validation(&$data){
        //hợp lệ hóa quy chuẩn trước  khi trả cho client
        if(is_array($data) && count($data)>0){
            foreach ($data as $key => $subdata){
               if(is_array($subdata)){
                    $this->validation($data[$key]);
               }
               else{

                     //chuyển null thành rỗng
                    if($subdata===null) $data[$key] ="";
                    
                    //chuyển date -> timestamp
                    elseif($key === "created" || $key === "modified") $data[$key] = strtotime($data[$key]);
                     //chuyển bool về string
                    elseif($subdata=== false) $data[$key] ="0";
                    elseif($subdata=== true) $data[$key] ="1";
                    elseif($this->get_file_ext($data[$key])!=""
                     && in_array(strtoupper($this->get_file_ext($data[$key])), array(".JPG",".PNG")))
                        $data[$key] = BASE_URL.$data[$key];
                    //chuyển tất cả về string
                    $data[$key].="";
               }
            }
        }

    }

    private function error($code = 1005) {
        $this->viewClass = 'Webservice.Webservice';
        $this->body['code'] = $code."";
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array();
        $this->validation($this->body);
        $this->output($this->body);
    }

    private function error_detail($code = 1005, $detail) {
        $this->viewClass = 'Webservice.Webservice';
        $this->body['code'] = $code."";
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array('detail' => $detail);
        $this->validation($this->body);
        $this->output($this->body);
    }

    public function index() {
       
            // $link = Router::url('/', true).'api/verify?hash=';
            // $this->set(compact('link'));
            // $email = 'mqsolutionstest@gmail.com';
            // $username = 'mqsolutionstest@gmail.com';
            // $password = 'mqsolutions123';
            // if (Configure::read('CFG.email'))
            //     $email = Configure::read('CFG.email');
            // if (Configure::read('CFG.username'))
            //     $username = Configure::read('CFG.username');
            // if (Configure::read('CFG.password'))
            //     $password = Configure::read('CFG.password');
            // $this->Email->from = $email;
            // $this->Email->to= 'quanbeodt1@gmail.com';
            // $this->Email->subject = 'Akibaアカウントにご登録ありがとうございます';
            // $this->Email->smtpOptions = array(
            //     'port'=>'465',
            //     'timeout'=>'30',
            //     'host' => 'ssl://smtp.gmail.com',
            //     'username'=> $username,
            //     'password'=> $password,
            // );
            // $this->Email->template = 'resetpassword';
            // $this->Email->sendAs = 'html';
            // $this->Email->delivery = 'smtp';
            // if ($this->Email->send()) {
            //     $this->output($this->body);
            // } else {
            //     $this->error(1004);
            // }      

    }
    private function save_history_purchase($purchase_id, $state){
        //save history state
        $this->loadModel("PurchaseStatusHistory");
         $saveHistory = array(
            "purchase_id" => $purchase_id,
            "status_code" => $state,
            );
         $cHistory = $this->PurchaseStatusHistory->find("first", array("conditions" => $saveHistory,
            "order" => "created DESC"));
        if(!$cHistory){
            $this->PurchaseStatusHistory->Create();
            return $this->PurchaseStatusHistory->save($saveHistory);
        }
        return true;
    }

    private function validate_param($params){
        foreach ($params as $param) {
            if (!isset($_POST[$param])) {
                $this->error(1002);
                return false;
            }
            
            //not null.
            if ($_POST[$param] == '') {
                $this->error(1004);
                return false;
            }
        }
        return true;
    }
    
    private function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      //  $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[rand(0,strlen($codeAlphabet)-1)];
        }
        return $token;
    }
    private function get_file_ext($name){
        // Get file extension
        $path_part = explode(".", $name);
        $file_ext = count($path_part) > 1 ? ('.' . end($path_part)) : '';
        return $file_ext;
    }

    public function set_notification($type,$object_id,$user_id){
        $Notification = new NotificationController;
        $notification_id = $Notification->setNotification(array('type' => $type, 'object_id' => $object_id,'user_id' => $user_id));
        return $notification_id;
    } 
}
?>