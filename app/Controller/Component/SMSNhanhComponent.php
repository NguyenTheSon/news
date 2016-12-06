<?php
App::uses('Component', 'Controller');

class SMSNhanhComponent extends Component {
  protected $username;
  protected $password;
  private $errorCode = array(
    "1" => "OK",
    "2" => "Loi, params khong dung",
    "0" => "wait",
    );
  function __construct(ComponentCollection $collection, $settings = array()) {
    
    Configure::load('sms');
    $this->taikhoan = Configure::read('SMSNHANH_Phonenum');
    $this->password = Configure::read('SMSNHANH_Password');
  }

  public function sentSMS($contents, $phonenumber){
        $Resuilt = file_get_contents("http://api.smsnhanh.com/?taikhoan=". $this->taikhoan."&matkhau=". $this->password."&sodienthoai=".$phonenumber."&noidung=".urlencode($contents)."&STT=VIP");
        if(strpos($Resuilt,"1") !== false){
          $ret = array(
            "code" => "1000",
            "messages" => "OK",
            "data" => array("Resuilt" => $Resuilt)
            );
        }
        else {
          $ret = array(
            "code" => "1004",
            "messages" => (isset($errorCode[$Resuilt]) ? $errorCode[$Resuilt] : "Loi:".$Resuilt),
            );
        }
        return $ret;
  }
  public function getBalance(){
      $Resuilt = file_get_contents("http://api.smsnhanh.com/Response/?User=".$this->taikhoan."&Pass=".$this->password);
      if($Resuilt > 2){
      $ret = array(
            "code" => "1000",
            "messages" => "OK",
            "data" => array("balance" => $Resuilt)
            );
        }
        else {
          $ret = array(
            "code" => "1004",
            "messages" => (isset($errorCode[$Resuilt]) ? $errorCode[$Resuilt] : "Loi:".$Resuilt),
            );
        }
        return $ret;
  }


}


?>