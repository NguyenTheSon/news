<?php
App::uses('Component', 'Controller');

class EsmsComponent extends Component {
  protected $APIKey;
  protected $SecretKey;
  private $SmsStatus = array(
    "1" => "cho duyet",
    "2" => "cho gui",
    "3" => "dang gui",
    "4" => "bi tu choi",
    "5" => "da gui xong",
    "6" => "da xoa",
    );
  private $errorCode = array(
    "100" => "OK",
    "99" => "Khong xac dinh",
    "101" => "APIkey hoac SecretKey khong dung",
    "102" => "Account bi khoa",
    "103" => "So du khong du",
    "104" => "BrandName khong dung",
    );
  private $url = array(
    "BrandName" => "http://api.esms.vn/MainService.svc/xml/SendMultipleSMSBrandname/",
    "Random" => "http://api.esms.vn/MainService.svc/xml/SendMultipleMessage_V2/",
  );
  function __construct(ComponentCollection $collection, $settings = array()) {
    
    Configure::load('sms');
    $this->APIKey = Configure::read('ESMS_APIKey');
    $this->SecretKey = Configure::read('ESMS_SecretKey');
  }

/*
    SMS TYPE (ngau nhien):
      1: Brandname Quảng cáo, 2: Brandname CSKH
      3: Đầu số ngẫu nhiên dạng (09xxxxx), giá rẻ
      6: Đầu số cố định dạng (8755) - giá trung bình
      4: Đầu số cố định dạng (19001534) - giá cao nhất
      8: tốc độ cao

*/
  public function sentSMS($contents, $phonenumber, $smstype = 8,$brandName='', $isFlash = 0){
        $ch = curl_init();
//        CakeLog::write('debug',"Sent SMS, type: $smstype, brandname: $brandName");
        $SampleXml = "<RQST>"
                         . "<APIKEY>". $this->APIKey ."</APIKEY>"
                         . "<SECRETKEY>". $this->SecretKey ."</SECRETKEY>"
                         . "<CONTENT>". $contents ."</CONTENT>"
                         . "<SMSTYPE>".$smstype."</SMSTYPE>";
        //neu su dung brandname
        if($isFlash){
          $SampleXml .= "<ISFLASH>".$isFlash."</ISFLASH>";
        }                                   
        if($brandName !=''){
          $SampleXml .= "<BRANDNAME>".$brandName."</BRANDNAME>";
          $url = $this->url['BrandName'];
        }
        else{
          $url = $this->url['Random'];
        }
        //them so dien thoai
        $SampleXml .= "<CONTACTS>";
        if(is_array($phonenumber)){
          foreach ($phonenumber as $key => $phone) {
            $SampleXml .= "<CUSTOMER><PHONE>". $phone ."</PHONE></CUSTOMER>";
            CakeLog::write('debug',"phone number: $phone");
          }
        }
        else
        {
          $SampleXml .= "<CUSTOMER><PHONE>". $phonenumber ."</PHONE></CUSTOMER>";
          CakeLog::write('debug',"phone number: $phonenumber");
        }       
        $SampleXml .=  "</CONTACTS>"
                   . "</RQST>";
        curl_setopt($ch, CURLOPT_URL,            $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $SampleXml ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
        $result=curl_exec ($ch);    
        $xml = simplexml_load_string($result);

        if ($xml === false) {
          CakeLog::write('debug','Error parsing XML');
          $ret = array(
            "code" => "1004",
            "messages" => 'Error parsing XML',
            );
        }
        else{
            CakeLog::write('debug',"Resuilt:".$this->errorCode[intval($xml->CodeResult)]."(".$xml->CodeResult.")");
            //$xml->MessageResuilt = $this->errorCode[intval($xml->CodeResult)];
            $ret = array(
              "code" => (intval($xml->CodeResult) == 100 ? "1000" : "1004"),
              "messages" => $this->errorCode[intval($xml->CodeResult)],
              "data" => (array)$xml,
              );
        }
        return $ret; 

  }

  public function getSMSstatus($SMSID){
        $ch = curl_init();
        CakeLog::write('debug',"get SMS status, SMSID: $SMSID");
        $SampleXml = "<RQST>"
                         . "<APIKEY>". $this->APIKey ."</APIKEY>"
                         . "<SECRETKEY>". $this->SecretKey ."</SECRETKEY>"
                         . " <SMSID>". $SMSID ."</SMSID>"
                         . "</RQST>";
       
        curl_setopt($ch, CURLOPT_URL,            "http://api.esms.vn/MainService.svc/xml/GetSmsStatus/" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $SampleXml ); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
        $result=curl_exec ($ch);    
        $xml = simplexml_load_string($result);

        if ($xml === false) {
          CakeLog::write('debug','Error parsing XML');
          $ret = array(
            "code" => "1004",
            "messages" => 'Error parsing XML',
            );
        }
        else{
            CakeLog::write('debug',"Resuilt:".$this->errorCode[intval($xml->CodeResult)]."(".$xml->CodeResult.")");
            //$xml->MessageResuilt = $this->errorCode[intval($xml->CodeResult)];
            $ret = array(
              "code" => (intval($xml->CodeResult) == 100 ? "1000" : "1004"),
              "messages" => $this->errorCode[intval($xml->CodeResult)],
              "data" => (array)$xml,
              );
        }
        return $ret; 
  }

  public function getBalance(){
        CakeLog::write('debug',"get Balance SMS.");
        $result = file_get_contents("http://api.esms.vn/MainService.svc/xml/GetBalance/".$this->APIKey."/".$this->SecretKey);
        $xml = simplexml_load_string($result);
        if ($xml === false) {
          CakeLog::write('debug','Error parsing XML');
          $ret = array(
            "code" => "1004",
            "messages" => 'Error parsing XML',
            );
        }
        else{
            CakeLog::write('debug',"Resuilt:".$this->errorCode[intval($xml->CodeResponse)]."(".$xml->CodeResponse.")");
            //$xml->MessageResuilt = $this->errorCode[intval($xml->CodeResult)];
            $ret = array(
              "code" => (intval($xml->CodeResponse) == 100 ? "1000" : "1004"),
              "messages" => $this->errorCode[intval($xml->CodeResponse)],
              "data" => (array)$xml,
              );
        }
        return $ret; 
  }


}


?>