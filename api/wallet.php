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
$date = date('Y-m-d');
$sql = "SELECT *,datediff('$date', joined_date) AS history_days  FROM users WHERE id = $user_id ";
$db->sql($sql);
$res = $db->getResult();
$history_days = $res[0]['history_days'];

if($history_days > VALID_DAYS){
    $sql = "UPDATE `users` SET  `code_generate` = 0 WHERE `id` = $user_id";
    $db->sql($sql);

}
$datetime = date('Y-m-d H:i:s');
$last_updated = $res[0]['last_updated'];
$date1 = new DateTime($last_updated);
$date2 = new DateTime($datetime);
$interval = $date1->diff($date2);
$days = $interval->days;
if($days != 0){
    $sql = "UPDATE `users` SET  `today_codes` = 0,`last_updated` = '$datetime' WHERE `id` = $user_id";
    $db->sql($sql);

}
$type = 'generate';

if($codes != 0){
    $amount = $codes * COST_PER_CODE;
    $sql = "INSERT INTO transactions (`user_id`,`codes`,`amount`,`datetime`,`type`)VALUES('$user_id','$codes','$amount','$datetime','$type')";
    $db->sql($sql);
    $res = $db->getResult();

    $sql = "UPDATE `users` SET  `today_codes` = today_codes + $codes,`total_codes` = total_codes + $codes,`earn` = earn + $amount,`balance` = balance + $amount WHERE `id` = $user_id";
    $db->sql($sql);
}




$sql = "SELECT * FROM users WHERE id = $user_id ";
$db->sql($sql);
$ures = $db->getResult();
$balance = $ures[0]['balance'];
$today_codes = $ures[0]['today_codes'];
$total_codes = $ures[0]['total_codes'];

$sql = "SELECT * FROM transactions WHERE user_id = $user_id ORDER BY ID DESC";
$db->sql($sql);
$res = $db->getResult();

$sql = "SELECT * FROM bank_details WHERE user_id = $user_id";
$db->sql($sql);
$bank_details_res = $db->getResult();

$response['success'] = true;
$response['message'] = "Wallet Retrived Successfully";
$response['user_details'] = $ures;
$response['bank_details'] = $bank_details_res;
$response['data'] = $res;
print_r(json_encode($response));


?>