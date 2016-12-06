<?php
/**
* 
*/
class test{
	
		public $CLIENT_ID = '1016845902505-mu14dlnr88rvoted5n8vncq7tquc7gnt.apps.googleusercontent.com';
      public $CLIENT_SECRET = 'kPJpSCrD7L5p9_SwfKm8P4Ss';
      public $REDIRECT_URI = 'urn:ietf:wg:oauth:2.0:oob';
      public $KEY_FILE = "";
      private $client;
      private $service;
      function __construct(){
              require_once realpath(dirname(__FILE__) . '/google-api/src/Google/autoload.php');
              $this->KEY_FILE = realpath(dirname(__FILE__)).'/google-api.key';
              $this->client = new Google_Client();
              $this->client->setClientId($this->CLIENT_ID);
              $this->client->setClientSecret($this->CLIENT_SECRET);
              $this->client->setRedirectUri($this->REDIRECT_URI);
              $this->client->setAccessType('offline');
              //$this->client->setAccessToken(file_get_contents($this->KEY_FILE));
              $this->client->addScope("https://www.googleapis.com/auth/drive");
              $this->service = new Google_Service_Drive($this->client);
             $xx =  $this->client->getAccessToken();
             echo "fdsfs";
             print_r($xx);
      }
}
	$t = new test();

?>