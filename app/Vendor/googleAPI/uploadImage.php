<?php
session_start();
require_once(realpath(dirname(__FILE__)."/googleDrive.php"));
/**
* 
*/
define ("FOLDER_REMOTE", "/images-thanhhuyen.dev");
class GoogleDriveImage{
	
	protected $folderID;
	protected $GoogleDrive;
	function __construct()
	{
		$this->GoogleDrive = new GoogleDrive();
		$list_folder_remote = explode("/",FOLDER_REMOTE);
		$parentId = 'root';
		
		foreach ($list_folder_remote as $key => $folder) {
			if($folder == '') continue;
			$folderID = $this->GoogleDrive->findFileID($folder,$parentId);
			if(!$folderID){
				$parentId = $this->GoogleDrive->createFolder($folder,$parentId);
			}
			else
			{
				$parentId = $folderID;
			}
		}
		$this->folderID = $folderID;
	}

	public function uploadimage($pathfile){
		
	    $resuit = $this->GoogleDrive->uploadFile(realpath($pathfile),$this->folderID);
	    if($resuit['code'] =='1000'){
	    	$this->GoogleDrive->publicFile($resuit['ID']);
	    	return "http://drive.google.com/uc?export=view&id=".$resuit['ID'];
	    }
	    return false;
	}
}
?>