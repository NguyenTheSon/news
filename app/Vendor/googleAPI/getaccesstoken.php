<?php
session_start();


#### Tao file google-api.key#########
require_once realpath(dirname(__FILE__) . '/google-api/src/Google/autoload.php');

$client_id = '1016845902505-mu14dlnr88rvoted5n8vncq7tquc7gnt.apps.googleusercontent.com';
$client_secret = 'kPJpSCrD7L5p9_SwfKm8P4Ss';
$redirect_uri = 'urn:ietf:wg:oauth:2.0:oob';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setAccessType('offline');
$client->addScope("https://www.googleapis.com/auth/drive");


if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $google_token= json_decode($_SESSION['access_token']);
  $client->refreshToken($google_token->refresh_token);
  file_put_contents("./google-api.key", $client->getAccessToken());
  echo "DONE! created file ./google-api.key";
  echo "<textarea>".$client->getAccessToken()."</textarea>";
exit;
}



if (strpos($client_id, "googleusercontent") == false) {
  echo "chua dien google api key";
  exit;
}
?>
<h2>Code tao google-api.key khi tao 1 tai khoan moi.</h2><br>
Khi chạy file này hệ thống sẽ tạo ra file google-api.key. và lần sau sẽ tự đọng refesh access token.<br>
Cách thự hiện:<br>
1. Chạy file này, click vào "Lấy access token".<br>
2. Sẽ chuyển sang google hỏi quyền. Cứ ok hết<br>
3. Lấy được Access token, quay lại trang này và thêm vào url: ?code=< accesstoken ><br>
4. hệ thống tạo file google-api.key. kiểm tra xem file đã tồn tại và có nội dung hay chưa.
5. Done.<br><br>
<?php
$authUrl = $client->createAuthUrl();
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Lấy Access Token</a>";
}
?>
  </div>

</div>