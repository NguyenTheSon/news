<?php
class GoogleDrive{
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
              $this->client->setAccessToken(file_get_contents($this->KEY_FILE));
              $this->client->addScope("https://www.googleapis.com/auth/drive");
              $this->service = new Google_Service_Drive($this->client);
      }
      public function uploadFile($urlFile, $folderId=''){
              if(!file_exists($urlFile)){
                echo "files does not exists!\n";
                return array("code" => "1004");
              }
              $client = $this->client;
              $service = $this->service;
              if ($client->getAccessToken()) {
                 if($client->isAccessTokenExpired()) {
                          $newToken = json_decode($client->getAccessToken());
                          $client->refreshToken($newToken->refresh_token);
                          file_put_contents($this->KEY_FILE, $client->getAccessToken());
                      }
                $file = new Google_Service_Drive_DriveFile();
                $file->title = basename($urlFile);
                $chunkSizeBytes = 1 * 1024 * 1024;

                if($folderId!='')
                {
                  $newparent = new  Google_Service_Drive_ParentReference();
                  $newparent->setId($folderId);
                  $file->setParents(array($newparent));         
                }
                // Call the API with the media upload, defer so it doesn't immediately return.
                $client->setDefer(true);
                $request = $service->files->insert($file);

                // Create a media file upload to represent our upload process.
                $media = new Google_Http_MediaFileUpload(
                    $client,
                    $request,
                    $this->getMimeType($urlFile),
                    null,
                    true,
                    $chunkSizeBytes
                );
                $media->setFileSize(filesize($urlFile));

                // Upload the various chunks. $status will be false until the process is
                // complete.
                $status = false;
                $handle = fopen($urlFile, "rb");
                while (!$status && !feof($handle)) {
                  // read until you get $chunkSizeBytes from TESTFILE
                  // fread will never return more than 8192 bytes if the stream is read buffered and it does not represent a plain file
                  // An example of a read buffered file is when reading from a URL
                  $chunk = $this->readVideoChunk($handle, $chunkSizeBytes);
                  $status = $media->nextChunk($chunk);
                }

                // The final value of $status will be the data from the API for the object
                // that has been uploaded.
                $result = false;
                if ($status != false) {
                  $result = $status;
                  
                }

                fclose($handle);
              }
              $client->setDefer(false);
              if (strpos($this->CLIENT_ID, "googleusercontent") == false) {
                return array("code" => "1004", "message" => missingClientSecretsWarning());
              }
              return array("code" => "1000", "ID" => $result->id, "urlDownload" => $result->downloadUrl);

      }
       private function readVideoChunk ($handle, $chunkSize)
      {
          $byteCount = 0;
          $giantChunk = "";
          while (!feof($handle)) {
              // fread will never return more than 8192 bytes if the stream is read buffered and it does not represent a plain file
              $chunk = fread($handle, 8192);
              $byteCount += strlen($chunk);
              $giantChunk .= $chunk;
              if ($byteCount >= $chunkSize)
              {
                  return $giantChunk;
              }
          }
          return $giantChunk;
      }
      public function createFolder($name,$folderId=''){
              $client = $this->client;
              $service = $this->service;

              if ($client->getAccessToken()) {
                 if($client->isAccessTokenExpired()) {
                          $newToken = json_decode($client->getAccessToken());
                          $client->refreshToken($newToken->refresh_token);
                          file_put_contents($this->KEY_FILE, $client->getAccessToken());
                      }
                $file = new Google_Service_Drive_DriveFile();
                $file->title = $name;
                $files = $service->files->listFiles();
                if($folderId!='')
                {
                  $newparent = new  Google_Service_Drive_ParentReference();
                  $newparent->setId($folderId);
                  $file->setParents(array($newparent));         
                }
                $file->setMimeType('application/vnd.google-apps.folder');
                $createdFile = $service->files->insert($file, array(
                    'mimeType' => 'application/vnd.google-apps.folder',
                ));
                return $createdFile->id;
              }
      }
      public function deleteFile($fileId) {
        $client = $this->client;
        $service = $this->service;
        try {
          $service->files->delete($fileId);
        } catch (Exception $e) {
          print "An error occurred: " . $e->getMessage();
        }
      }

      public function findFileID($fileName,$folderId='root'){
          $files = $this->service->files->listFiles(array("q" => "'".$folderId."' in parents"));
          if($files){
            foreach ($files['items'] as $item) {
                        if ($item['title'] == $fileName && $item['explicitlyTrashed']!='1') {
                            $folderId = $item['id'];
                            return $folderId;
                        }
                    }
          }
          return false;
      }
      public function publicFile($fileID){
          $permission = new Google_Service_Drive_Permission();
          $permission->setRole( 'reader' );
          $permission->setType( 'anyone' );
          $permission->setWithLink(true);
          $result = $this->service->permissions->insert( $fileID, $permission );
          return $result;
      }
      private function getMimeType( $filename ) {
        $realpath = realpath( $filename );
        if ( $realpath
                && function_exists( 'finfo_file' )
                && function_exists( 'finfo_open' )
                && defined( 'FILEINFO_MIME_TYPE' )
        ) {
                // Use the Fileinfo PECL extension (PHP 5.3+)
                return finfo_file( finfo_open( FILEINFO_MIME_TYPE ), $realpath );
        }
        if ( function_exists( 'mime_content_type' ) ) {
                // Deprecated in PHP 5.3
                return mime_content_type( $realpath );
        }
        return false;
      }
}
?>