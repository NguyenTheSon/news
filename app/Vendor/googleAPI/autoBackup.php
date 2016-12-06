<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
	require_once(realpath(dirname(__FILE__)."/googleDrive.php"));
	$Folder_Backup = '/backup/';
	$Folder_remote = '/Backup-VPS-Salonzo';
	$Email_Admin = "it@salonzo.com";
	$GoogleDrive = new GoogleDrive();
	$list_folder_remote = explode("/",$Folder_remote);
	$parentId = 'root';
	$detailMessage = "";
	foreach ($list_folder_remote as $key => $folder) {
		if($folder == '') continue;
		$folderID = $GoogleDrive->findFileID($folder,$parentId);
		if(!$folderID){
			$parentId = $GoogleDrive->createFolder($folder,$parentId);
		}
		else
		{
			$parentId = $folderID;
		}
	}
	echo "\n###################AUTO BACKUP DATA SERVER####################\n";
	echo "###################".date("H:i:s d-m-Y")."####################\n";
	//check Folder Date.....
	echo "checking Folder Backup on Google Drive.....\n";
	$folder = date("Y-m-d");
	$folderID = $GoogleDrive->findFileID($folder,$parentId);
	if(!$folderID){
		echo "creating folder: $folder\n";
		$detailMessage .= "creating folder: $folder\n";
		$folderID = $GoogleDrive->createFolder($folder,$parentId);
	}
	else{
		echo "folder: $folder exists.\n";
		$detailMessage .= "folder: $folder exists.\n";
	}

	//scan file and transfer
	$startTime = time();
	echo "Start backup: ".date("H:i:s d-m-Y")."\n";
	$detailMessage .= "Start backup: ".date("H:i:s d-m-Y")."\n";
	$dh  = opendir($Folder_Backup);

	while (false !== ($filename = readdir($dh))) {
	    if(in_array($filename, array(".",".."))) continue;
	    echo "start transfer file: $filename.....\n";
	    $detailMessage .= "start transfer file: $filename.....\n";
	    $startTimesub = time();
	    if($GoogleDrive->findFileID(basename(realpath($Folder_Backup.$filename)),$folderID)){
	    	echo "SKIP file: $filename (".(filesize_formatted(realpath($Folder_Backup.$filename)))."): file exist.\n";
	    	$detailMessage .= "SKIP file: $filename (".(filesize_formatted(realpath($Folder_Backup.$filename)))."): file exist.\n";
	    	continue;
	    } 
	    //transfer file to google drive
	    $resuilt = $GoogleDrive->uploadFile(realpath($Folder_Backup.$filename),$folderID);
	    if($resuilt['code'] =='1000'){
	    		$endTimeSub = time();
	    	$detailMessage .= "UPLOADED file: $filename (".(filesize_formatted(realpath($Folder_Backup.$filename))).") to ".$Folder_remote."/".$folder.". Total time: ".gmdate("H:i:s",$endTimeSub - $startTimesub)."\n";
	    	echo "UPLOADED file: $filename (".(filesize_formatted(realpath($Folder_Backup.$filename))).") to ".$Folder_remote."/".$folder.". Total time: ".gmdate("H:i:s",$endTimeSub - $startTimesub)."\n";
	    }
	    else{
	    	$detailMessage .= "FAILED file: $filename (".(filesize_formatted(realpath($Folder_Backup.$filename))).") \n";
	    	echo "FAILED file: $filename (".(filesize_formatted(realpath($Folder_Backup.$filename))).") \n";
	    }
	}

	$endTime = time();
	$detailMessage .= "Finish backup: ".date("H:i:s d-m-Y")."; total time: ".gmdate("H:i:s",$endTime - $startTime)."\n";
	echo "Finish backup: ".date("H:i:s d-m-Y")."; total time: ".gmdate("H:i:s",$endTime - $startTime)."\n";
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=iso-8859-1";
	$headers[] = "From: Admin VPS <admin@salonzo.com>";
	$headers[] = "Subject: Transfer Backup to GoogleDrive Completed.";
	$headers[] = "X-Mailer: PHP/".phpversion();
	$contents = "Transfer Backup on Salonzo Server to GoogleDrive Completed.\n";
	$contents .= "All backup file in: ".$Folder_remote."/".$folder."\n";
	$contents .= "Time start: ".date("H:i:s d-m-Y",$startTime).". Time finish: ".date("H:i:s d-m-Y",$endTime).".\n";
	$contents .= "Total time running: ".gmdate("H:i:s",$endTime - $startTime)."\n";
	$contents .= "#########################################################\n";
	$contents .= $detailMessage;
	mail($Email_Admin, "Transfer Backup to GoogleDrive Completed.", $contents, implode("\r\n", $headers));
?>