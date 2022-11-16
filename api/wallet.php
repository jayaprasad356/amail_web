<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');

$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');


if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}


$user_id = $db->escapeString($_POST['user_id']);
$codes = $db->escapeString($_POST['codes']);
if($codes != 0){
    $datetime = date('Y-m-d H:i:s');
    $type = 'generate';
    $amount = $codes * 0.17;
    $sql = "INSERT INTO transactions (`user_id`,`codes`,`amount`,`datetime`,`type`)VALUES('$user_id','$codes','$amount','$datetime','$type')";
    $db->sql($sql);
    $res = $db->getResult();

    $sql = "UPDATE `users` SET `earn` = earn + $amount,`balance` = balance + $amount WHERE `id` = $user_id";
    $db->sql($sql);
}

$sql = "SELECT * FROM users WHERE id = $user_id ";
$db->sql($sql);
$res = $db->getResult();
$balance = $res[0]['balance'];
$sql = "SELECT * FROM transactions WHERE user_id = $user_id ORDER BY ID DESC";
$db->sql($sql);
$res = $db->getResult();

$sql = "SELECT * FROM bank_details WHERE user_id = $user_id";
$db->sql($sql);
$bank_details_res = $db->getResult();

$response['success'] = true;
$response['balance'] = $balance;
$response['message'] = "Wallet Retrived Successfully";
$response['bank_details'] = $bank_details_res;
$response['data'] = $res;
print_r(json_encode($response));


?>