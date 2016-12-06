<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::import('Controller', 'Notification');


    class CronjobController extends AppController {
    protected $state_purchase = array("request","accept","shipping","waiting rate","completed","failed","reject");
    public $uses = array('UserSession','Product','Tracking','Purchase','QueuePushNotification','AppSetting');
    public $components = array('RequestHandler', 'Webservice.Webservice', 'Email','BalanceHis','Apns');
    public $helpers = array('Form', 'Html');
    private $NotificationController;
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
    );
    private $statusCode = array(
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
    
    protected $body = array(
        'code' => '1000',
        'message' => 'OK',
        'data' => array()
    );
    protected $typePushIgroneLastID = array("like_products", "comment_products");

    public function run_notification($notification_id="", $list_userid=""){
        $NotificationController = new NotificationController;

            $list_userid = explode(",",$list_userid);
            $detail = $NotificationController->getDetailsNotification($notification_id);
             $push_info = array(
                "type" => ($detail['type'] ? $detail['type']: ""),
                "object_id" => ($detail['object_id'] ? $detail['object_id'] : ""),
                "avatar" => ($detail['avatar'] ? $detail['avatar'] : ""),
            );
            $this->UserSettingPush = $this->Components->load("UserSettingPush");
            $setting_key = $this->UserSettingPush->get_setting($detail['type']);
                if(!is_array($list_userid))
                {
                    $list_userid = array($list_userid);
                }
                foreach ($list_userid as $key => $uid) {
                    //check neu nguoi dung tat push
                    $user_push_setting = $this->_get_push_setting($uid);
                    if(!isset($user_push_setting[$setting_key]) || $user_push_setting[$setting_key] == 0) continue;

                    $title = $detail['title'];
                    $sound = $detail['sound'];
                    if(isset($detail['seller_id'])){
                        if($uid != $detail['seller_id']){
                            $seller_name = (isset($detail['seller_name']) ? $detail['seller_name']: "");
                        }
                        else{
                            $seller_name = (isset($detail['seller_name']) ? "bạn": "");
                            if(isset($detail['sound_extra'])) $sound = $detail['sound_extra'];
                        }
                        $title .= $seller_name;
                    }
                    $this->send_notifications($uid, $title, 0,$sound , $push_info);
                }

        $this->output($this->body);
        return;
    }
    public function run_notification_in_queue(){
        $this->NotificationController = new NotificationController;
        $this->Apns->payloadMethod = 'simple'; // you can turn on this method for debuggin purpose
        $this->Apns->connectToPush();
            echo "##########################################################\n";
            echo "PUSH NOTIFICATION FROM QUEUE.\n";
            echo "Check every 0.5 second\n";
            echo "Start Time:".date("H:i:s d-m-Y\n");
            echo "##########################################################\n";
            while(true){
                //call to another function to free memory after run;
                $cRunning = $this->process_notification_queue();
                if($cRunning !=1){
                    echo "\nSTOP Process\n";
                    break;
                }
                usleep(500000); //sleep 0.5s
            }
        $this->Apns->disconnectPush();
        $this->output($this->body);
        return;
    }
    //goi mot ham rieng de giai phong bo nho ram moi khi chay xong
    private function process_notification_queue(){
        $listNotification = $this->QueuePushNotification->find("all", array(
        "limit" => 10));
        foreach ($listNotification as $key => $Noti) {
            $this->QueuePushNotification->delete($Noti['QueuePushNotification']['id']);
        }

        foreach ($listNotification as $key => $Noti) {
            echo "\nNotification id: ".$Noti['QueuePushNotification']['notification_id']."\n";
            $list_userid = $Noti['QueuePushNotification']['list_userid'];
            $notification_id = $Noti['QueuePushNotification']['notification_id'];
            $list_userid = explode(",",$list_userid);
            $detail = $this->NotificationController->getDetailsNotification($notification_id);
            $push_info = array(
                "type" => ($detail['type'] ? $detail['type']: ""),
                "object_id" => ($detail['object_id'] ? $detail['object_id'] : ""),
                "avatar" => ($detail['avatar'] ? $detail['avatar'] : ""),
            );
            $this->loadModel("Notification");
            $Noti = $this->Notification->find("first", array("conditions" => array("id" => $notification_id)));
            $last_userid = $Noti['Notification']['last_userid'];
            $this->UserSettingPush = $this->Components->load("UserSettingPush");
            $setting_key = $this->UserSettingPush->get_setting($detail['type']);
                if(!is_array($list_userid))
                {
                    $list_userid = array($list_userid);
                }
                echo "      Push to userid: ";
                foreach ($list_userid as $key => $uid) {
                    if(!intval($uid)) continue;

                    if($uid == $last_userid && in_array($detail['type'],$this->typePushIgroneLastID)) continue;
                    //check neu nguoi dung tat push
                    $user_push_setting = $this->_get_push_setting($uid);
                    if(!isset($user_push_setting[$setting_key]) || $user_push_setting[$setting_key] == 0) continue;
                    $title = $detail['title'];
                    $sound = $detail['sound'];
                    if(isset($detail['seller_id'])){
                        if($uid != $detail['seller_id']){
                            $seller_name = (isset($detail['seller_name']) ? $detail['seller_name']: "");
                        }
                        else{
                            $seller_name = (isset($detail['seller_name']) ? "bạn": "");
                            if(isset($detail['sound_extra'])) $sound = $detail['sound_extra'];
                        }
                        $title .= $seller_name;
                    }
                    echo "$uid, ";
                    $this->send_notifications_queue($uid, $title, 0,$sound , $push_info);
                }
        }
        $cRunning = $this->AppSetting->find("first", array("conditions" => array("code" => "run_push_queue"),
            "fields" => array("value"),));
        return $cRunning['AppSetting']['value'];
    }
    public function run_tracking(){
        $Trackings = $this->Tracking->find("all", array(
            "conditions" => array(
                "running" => 1
                ),
            "recursive" => 0
            ));
        foreach ($Trackings as $key => $Tracking) {
         
            $state_ship = $this->ShipChung->status($Tracking['Tracking']['tracking_code']);
            if(isset($state_ship[$Tracking['Tracking']['tracking_code']])){
                            $state_ship = $state_ship[$Tracking['Tracking']['tracking_code']]->StatusCode;
            }
            //$state_ship = 14;
            if($state_ship != $Tracking['Tracking']['statusCode']){
                //save state history
                $this->loadModel("PurchaseStatusHistory");
                $saveHistory = array(
                        "purchase_id" => $Tracking['Purchase']['id'],
                        "status_code" => $state_ship,
                        );
                $cHistory = $this->PurchaseStatusHistory->find("first", array("conditions" => $saveHistory,
                    "order" => "created DESC"));
                if(!$cHistory){
                    $this->PurchaseStatusHistory->Create();
                    $this->PurchaseStatusHistory->save($saveHistory);
                }
                switch ($state_ship) {
                    case 14:
                        //đang lấy hàng
                        $this->Tracking->create(false);
                        $this->Tracking->updateAll(array("statusCode" => $state_ship),array("purchase_id" => $Tracking['Purchase']['id']));
              
                        $cProduct = $this->Product->find("first", array("conditions" => array("id" => $Tracking['Purchase']['product_id'])));
                        $notification_id = $this->set_notification("shipping_danglayhang",$Tracking['Purchase']['id'], $Tracking['Purchase']['buyer_id']);
                        $notification_id = $this->set_notification("shipping_danglayhang",$Tracking['Purchase']['id'], $cProduct['Product']['seller_id']);
                        $this->push_notification($notification_id,array($Tracking['Purchase']['buyer_id'],$cProduct['Product']['seller_id']));
                        break;
                    case 15:
                        //lay hang khong thanh cong
                        $this->Purchase->create(false);
                        $this->Purchase->id = $Tracking['Purchase']['id'];
                        $this->Purchase->saveField("state","6");
                        $this->Tracking->create(false);
                        $this->Tracking->updateAll(array("statusCode" => $state_ship, "running" => "0"),array("purchase_id" => $Tracking['Purchase']['id']));
              
                        if($Tracking['Purchase']['pay_type'] == 2){
                                $this->set_balance($Tracking['Purchase']['buyer_id'], $Tracking['Purchase']['offers'] + $Tracking['Purchase']['ship_fee'], "buy_product_failed", $Tracking['Purchase']['id']);
                            }
                        $cProduct = $this->Product->find("first", array("conditions" => array("id" => $Tracking['Purchase']['product_id'])));
                        $notification_id = $this->set_notification("shipping_layhangthatbai",$Tracking['Purchase']['id'], $Tracking['Purchase']['buyer_id']);
                        $notification_id = $this->set_notification("shipping_layhangthatbai",$Tracking['Purchase']['id'], $cProduct['Product']['seller_id']);
                        $this->push_notification($notification_id,array($Tracking['Purchase']['buyer_id'],$cProduct['Product']['seller_id']));
                        break;
                    case 16:
                        //đã lấy hàng
                        $this->Tracking->create(false);
                        $this->Tracking->updateAll(array("statusCode" => $state_ship),array("purchase_id" => $Tracking['Purchase']['id']));
              
                        $cProduct = $this->Product->find("first", array("conditions" => array("id" => $Tracking['Purchase']['product_id'])));
                        $notification_id = $this->set_notification("shipping_dalayhang",$Tracking['Purchase']['id'], $Tracking['Purchase']['buyer_id']);
                        $notification_id = $this->set_notification("shipping_dalayhang",$Tracking['Purchase']['id'], $cProduct['Product']['seller_id']);
                        $this->push_notification($notification_id,array($Tracking['Purchase']['buyer_id'],$cProduct['Product']['seller_id']));
                        break;
                    case 17:
                        //dang phat hang
                        $this->Tracking->create(false);
                        $this->Tracking->updateAll(array("statusCode" => $state_ship),array("purchase_id" => $Tracking['Purchase']['id']));
              
                        $cProduct = $this->Product->find("first", array("conditions" => array("id" => $Tracking['Purchase']['product_id'])));
                        $notification_id = $this->set_notification("shipping_dangphathang",$Tracking['Purchase']['id'], $Tracking['Purchase']['buyer_id']);
                        $notification_id = $this->set_notification("shipping_dangphathang",$Tracking['Purchase']['id'], $cProduct['Product']['seller_id']);
                        $this->push_notification($notification_id,array($Tracking['Purchase']['buyer_id'],$cProduct['Product']['seller_id']));
                        break;
                    case 18:
                        //giao hang khong thanh cong
                        $this->Purchase->create(false);
                        $this->Purchase->id = $Tracking['Purchase']['id'];
                        $this->Purchase->saveField("state","5");
                        $this->Tracking->create(false);
                        $this->Tracking->updateAll(array("statusCode" => $state_ship,"running" => "0"),array("purchase_id" => $Tracking['Purchase']['id']));
              
                        if($Tracking['Purchase']['pay_type'] == 2){
                                $this->set_balance($Tracking['Purchase']['buyer_id'], $Tracking['Purchase']['offers'] + $Tracking['Purchase']['ship_fee'], "cancel_buy_products", $Tracking['Purchase']['id']);
                        }
                        $this->loadModel("Product");
                        $cProduct = $this->Product->find("first", array("conditions" => array("id" => $Tracking['Purchase']['product_id'])));
                        $notification_id = $this->set_notification("shipping_phathangthatbai",$Tracking['Purchase']['id'], $cProduct['Product']['seller_id']);
                        $notification_id = $this->set_notification("shipping_phathangthatbai",$Tracking['Purchase']['id'], $Tracking['Purchase']['buyer_id']);
                             //push
                        $this->push_notification($notification_id,array($cProduct['Product']['seller_id'],$Tracking['Purchase']['buyer_id']));
                        break;
                    case 19:
                        //giao hang thanh cong
                        $this->Purchase->create(false);
                        $this->Purchase->id = $Tracking['Purchase']['id'];
                        $this->Purchase->saveField("state","3");
                        $this->Tracking->create(false);
                        $this->Tracking->updateAll(array("statusCode" => $state_ship,"running" => "0"),array("purchase_id" => $Tracking['Purchase']['id']));
              
                        
                        $this->loadModel("Product");
                        $Purchase = $this->Purchase->find("first", array("conditions" => array(
                            "Purchase.id" => $Tracking['Purchase']['id']),
                        "recursive" => 0));
                    
                        //set notification cho nguoi mua yeu cau rate
                        $notification_id = $this->set_notification("state_rate_seller",$Purchase['Product']['id'],$Purchase['Purchase']['buyer_id']);
                        $this->push_notification($notification_id,$Purchase['Purchase']['buyer_id']);

                        //set notification cho nguoi bán yeu cau rate
                        $notification_id = $this->set_notification("state_rate_buyer",$Purchase['Product']['id'],$Purchase['Product']['seller_id']);
                        $this->push_notification($notification_id,$Purchase['Product']['seller_id']);

                        $PurchaseFailed = $this->Purchase->find("all",array(
                            "conditions" => array("Purchase.id !=" => $Purchase['Purchase']['id'],
                                                "product_id" => $Purchase['Purchase']['product_id'],
                                                "Purchase.state" => "0"),
                            ));
                        //thong bao cho nhung nguoi dang ky nhung khong mua duoc
                        $list_user_push = "";
                        if($PurchaseFailed)
                        foreach ($PurchaseFailed as $key => $purchase) {
                            $this->Purchase->Create(false);
                            $this->Purchase->id = $purchase['Purchase']['id'];
                            $this->Purchase->saveField("state",6);
                            if($purchase['Purchase']['pay_type'] == 2){
                                $this->set_balance($purchase['Purchase']['buyer_id'],$purchase['Purchase']['offers'], "buy_product_failed", $purchase['Purchase']['id']);
                            }
                            $notification_id = $this->set_notification("reject_buyer",$purchase['Purchase']['id'],$purchase['Purchase']['buyer_id']);
                            $list_user_push[] = $purchase['Purchase']['buyer_id'];
                        }
                        if($list_user_push)
                        $this->push_notification($notification_id,$list_user_push);
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        $this->output($this->body);
        return;
    }
    public function run_RequestACH(){

    }
    public function run_AutoShip(){
        echo date("H:i:s\n");
    }
    public function run_processOnline(){
        $this->autoRender = false;
        $this->loadModel("UserOnline");
        $this->UserOnline->Create();
        $listOff = $this->UserOnline->find("all", array("conditions" => array(
            "modified <" => time()-10*3600)));
        $this->loadModel("User");
        foreach ($listOff as $key => $User) {
            $this->User->Create(false);
            $this->User->id = $User['UserOnline']['user_id'];
            $last_login = date("Y-m-d H:i:s", $User['UserOnline']['modified']);
            $this->User->saveField("last_login", $last_login);
            $this->UserOnline->delete($User['UserOnline']['user_id']);
        }
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
    
    private function output($body = array()) {
        $this->viewClass = 'Webservice.Webservice';
        $this->validation($body['data']);
        $log = print_r($body['data'], true);
     
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
        $this->body['code'] = $code;
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array();
        $this->output($this->body);
    }

    private function error_detail($code = 1005, $detail) {
        $this->viewClass = 'Webservice.Webservice';
        $this->body['code'] = $code;
        $this->body['message'] = $this->message[$code];
        $this->body['data'] = array('detail' => $detail);
        $this->output($this->body);
    }

    public function index() {
        echo "fsdfsđfs";
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
        $NotificationController = new NotificationController;
        $notification_id = $NotificationController->setNotification(array('type' => $type, 'object_id' => $object_id,'user_id' => $user_id));
        return $notification_id;
    }
    protected function send_notifications_queue($user_id, $message, $badge, $sound, $add_data_array)
    {
     $this->loadModel('User');
        $user = $this->User->find('first',
                    array(
                        'conditions' => array(
                            'User.id' => $user_id,
                        ),
                        'fields' => array('User.devtoken', 'User.android_token')
                    )
                );
        if(!$user){
            return;
        }
        if (!$badge)
         $badge = 1;
            if ($sound == "") $sound = "default";
            if ($user['User']['devtoken'] != null)
            {
                // adding custom variables to the notification
                if (is_array($add_data_array))
                    $this->Apns->setData($add_data_array);

                    $send_result = $this->Apns->sendMessage($user['User']['devtoken'], $message, $badge, $sound);
            }
            if ($user['User']['android_token'] != null)
            {
                $add_data_array['message'] = $message;
                $add_data_array['sound'] = $sound;
                $this->C2DM->sendMessage(GOOGLE_API_KEY,array($user['User']['android_token']),$add_data_array);

            }
        
        
    }
}
?>