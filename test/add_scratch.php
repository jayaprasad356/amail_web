<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('Asia/Kolkata');

include_once('../includes/crud.php');

$db = new Database();
$db->connect();
$currentdate = date('Y-m-d');
$sql = "SELECT id FROM `users` WHERE DATEDIFF( '$currentdate',registered_date) >= 7 AND status = 0";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $total = 0 ;
    foreach ($res as $row) {
        
        $ID = $row['id'];
        $discount = 300;
        $expiry_date = '2023-06-19';
        $sql_query = "INSERT INTO scratch_cards (user_id,discount,expiry_date,status)VALUES('$ID','$discount','$expiry_date',1)";
        $db->sql($sql_query);
 
    }
    $response['success'] = true;
    $response['message'] = "Scratch Card Inserted Successfully";
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Results Found";
    print_r(json_encode($response));

}




?>