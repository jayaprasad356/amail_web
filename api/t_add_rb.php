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
$datetime = date('Y-m-d H:i:s');
$sql = "SELECT id,refer_balance,balance FROM users WHERE refer_balance != 0";
$db->sql($sql);
$res = $db->getResult();
$refer = array();
foreach ($res as $row) {
    $refer_balance = $row['refer_balance'];
    $balance = $row['balance'];
    $id = $row['id'];

    $type = 'admin_credit_balance';
    $sql = "INSERT INTO transactions (`user_id`,`amount`,`datetime`,`type`,`remarks`)VALUES('$id','$refer_balance','$datetime','$type','refer_balance added')";
    $db->sql($sql);

    $sql_query = "UPDATE users SET balance=balance + refer_balance WHERE id=$id";
    $db->sql($sql_query);


    
}

$response['success'] = true;
$response['message'] = "Refer Balance Added Successfully";
print_r(json_encode($response));








?>