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
$sql = "SELECT id,refund_wallet,balance FROM users WHERE refund_wallet != 0";
$db->sql($sql);
$res = $db->getResult();
$refer = array();
foreach ($res as $row) {
    $refund_wallet = $row['refund_wallet'];
    $balance = $row['balance'];
    $id = $row['id'];

    $type = 'admin_credit_balance';

    $sql = "INSERT INTO transactions (`user_id`,`amount`,`datetime`,`type`,`remarks`)VALUES('$id','$refund_wallet','$datetime','$type','refund_wallet added')";
    $db->sql($sql);

    $sql = "UPDATE `users` SET  `refund_wallet` = refund_wallet - $refund_wallet,`balance`=balance + $refund_wallet,`earn`=earn + $refund_wallet WHERE `id` = $id";
    $db->sql($sql);


    
}

$response['success'] = true;
$response['message'] = "Refund Wallet Added Successfully";
print_r(json_encode($response));








?>