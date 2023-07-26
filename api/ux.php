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
include_once('../includes/functions.php');
$fn = new functions;
$fn->monitorApi('withdrawal');


$user_id = '41780';
$enable = 0;
$amount = rand(190,200);
// $w_user_id = rand(11,100);
// $sql = "UPDATE `withdrawals` SET `user_id` = '$w_user_id' WHERE `user_id` = $user_id AND status = 1";
// $db->sql($sql);

$sql = "SELECT * FROM settings";
$db->sql($sql);
$mres = $db->getResult();

$sql = "SELECT SUM(amount) AS amount FROM withdrawals WHERE DATE(datetime) AND status = 0";
$db->sql($sql);
$wsres = $db->getResult();
$sum_with = $wsres[0]['amount'];
$main_ws = $mres[0]['withdrawal_status'];

$sql = "SELECT id FROM withdrawals WHERE DATE(datetime) AND status = 0 AND user_id = $user_id";
$db->sql($sql);
$wcount = $db->getResult();
$wcountnum = $db->numRows($wcount);

$sql = "SELECT withdrawal_status FROM users WHERE id = $user_id ";
$db->sql($sql);
$res = $db->getResult();
$withdrawal_status = $res[0]['withdrawal_status'];
if(!empty($branch_id)){
    $sql = "SELECT min_withdrawal FROM branches WHERE id = $branch_id";
    $db->sql($sql);
    $result = $db->getResult();
    $min_withdrawal = $result[0]['min_withdrawal'];
}
else{
    $min_withdrawal = $mres[0]['min_withdrawal'];
}

$datetime = date('Y-m-d H:i:s');
$sql = "SELECT id FROM bank_details WHERE user_id = $user_id ";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if($withdrawal_status == 1 &&  $main_ws == 1 && $sum_with > 100000 && $wcountnum == 0 && $enable = 1){
    if ($num >= 1) {
        if($amount >= $min_withdrawal){
                $sql = "INSERT INTO withdrawals (`user_id`,`amount`,`datetime`,`withdrawal_type`)VALUES('$user_id','$amount','$datetime','code_withdrawal')";
                $db->sql($sql);

                $response['success'] = true;
                $response['message'] = "Withdrawal Requested Successfully";
                print_r(json_encode($response));
        
            }        else{
                $response['success'] = false;
                $response['message'] = "Required Minimum Amount to Withdrawal is ".$min_withdrawal;
                print_r(json_encode($response)); 
            }
        }

    else{
        $response['success'] = false;
        $response['message'] = "Update Bank Details first";
        print_r(json_encode($response)); 
    
    }
}else{
    $response['success'] = false;
    $response['message'] = "Withdrawal Disabled Right Now,Please Try Again";
    print_r(json_encode($response));    
}






?>