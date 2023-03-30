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
include_once('../includes/functions.php');
$fn = new functions;

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['amount'])) {
    $response['success'] = false;
    $response['message'] = "Amount is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$amount = $db->escapeString($_POST['amount']);

$sql = "SELECT * FROM users WHERE id = '$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    if($amount >= 50){
        $sql = "UPDATE `users` SET  `refund_wallet` = refund_wallet - $amount,`balance`=balance + $amount,`earn`=earn + $amount WHERE `id` = $user_id";
        $db->sql($sql);
        $sql = "SELECT refund_wallet,balance,earn FROM users WHERE id = '$user_id'";
        $db->sql($sql);
        $result = $db->getResult();
        $response['success'] = true;
        $response['message'] = "Amount Added to Wallet Successfully";
        $response['data'] = $result;
        print_r(json_encode($response));

    }
    else{
        $response['success'] = false;
        $response['message'] = "Minimum Amount is Rs.50";
        print_r(json_encode($response));
    }
}else{
    $response['success'] = false;
    $response['message'] = "No Users Found";
    print_r(json_encode($response));

}

?>