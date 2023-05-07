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
include_once('../includes/custom-functions.php');
$fn = new custom_functions;
$db = new Database();
$db->connect();
$currentdate = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
$sql = "SELECT referred_by FROM users WHERE joined_date = '2023-05-05' AND status = 1";
$db->sql($sql);
$res = $db->getResult();
foreach ($res as $row) {
    $referred_by = $row['referred_by'];
    $sql = "SELECT referred_by,id FROM users WHERE refer_code = '$referred_by'";
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num == 1) {
        $referred_by = $res[0]['referred_by'];
        $ID = $res[0]['id'];
        $datetime = date('Y-m-d H:i:s');
        $type = 'code_bonus';
        $codes = 1250;
        $per_code_cost = $fn->get_code_per_cost($ID);
        $amount = $codes * $per_code_cost;
        $sql = "INSERT INTO transactions (`user_id`,`codes`,`amount`,`datetime`,`type`)VALUES('$ID','$codes','$amount','$datetime','$type')";
        $db->sql($sql);
        $sql = "UPDATE `users` SET  `today_codes` = today_codes + $codes,`total_codes` = total_codes + $codes,`earn` = earn + $amount,`balance` = balance + $amount WHERE `id` = $ID";
        $db->sql($sql);

    }


    
}

$response['success'] = true;
$response['message'] = "Refer Added Successfully";
print_r(json_encode($response));








?>