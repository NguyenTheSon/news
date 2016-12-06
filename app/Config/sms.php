<?php
/*
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
|| Sent SMS
|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
*/

$config['Service_Default'] = "1"; //0:Off, 1: ESMS, 2: SMSNhanh
################## ESMS CONFIG ############################
/*
    SMS TYPE (ngau nhien):
      1: Brandname Quảng cáo, 2: Brandname CSKH
      3: Đầu số ngẫu nhiên dạng (09xxxxx), giá rẻ
      6: Đầu số cố định dạng (8755) - giá trung bình
      4: Đầu số cố định dạng (19001534) - giá cao nhất
      8: tốc độ cao

*/
$config['ESMS_APIKey'] = "AB484843096497FE5196C0338CA45C";
$config['ESMS_SecretKey'] = "614F8AC02989F1668145C18DC3191D";
$config['ESMS_BrandName'] ="ThanhHuyen";
$config['ESMS_Type'] ="2";

################## SMS NHANH CONFIG ############################

$config['SMSNHANH_Phonenum'] = "01687773333";
$config['SMSNHANH_Password'] = "696188";
?>