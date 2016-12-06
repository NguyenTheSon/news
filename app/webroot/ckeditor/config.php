<?php
$baselink="http://hairfashiontv.vn"; 
$base_popup = "http://sv1.hairfashiontv.vn/ckfinderhaihipngochip/popup.php?hash=fd3f1c37bed485936f8b585da01dd73052528480faa8814bc30ea2e6360fa246eef995fcc7aa80f941f7d41bf3c29ddc7bfad6b57b63e376afeb1cecc4941720f0c855f66a689e6d166cc1353b034d72";
if($_GET['getconfig']=="js")
{
	header('Content-Type: application/javascript');
	echo 'CKEDITOR.config.baselink = "'.$baselink.'";';
	echo 'filebrowserBrowseUrl = "'.$base_popup.'"';
}
?>