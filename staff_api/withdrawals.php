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

if (empty($_POST['staff_id'])) {
    $response['success'] = false;
    $response['message'] = "Staff Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['amount'])) {
    $response['success'] = false;
    $response['message'] = "Amount is Empty";
    print_r(json_encode($response));
    return false;
}
$staff_id = $db->escapeString($_POST['staff_id']);
$amount = $db->escapeString($_POST['amount']);


$datetime = date('Y-m-d H:i:s');
$sql = "SELECT balance FROM staffs WHERE id = $staff_id ";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
$balance = $res[0]['balance'];
$min_withdrawal = 250;
if ($num >= 1) {
    if($amount >= $min_withdrawal){
        if($balance >= $amount){
            $sql = "UPDATE `staffs` SET `balance` = balance - $amount,`withdrawal` = withdrawal + $amount WHERE `id` = $staff_id";
            $db->sql($sql);
            $sql = "INSERT INTO staff_withdrawals (`staff_id`,`amount`,`datetime`)VALUES('$staff_id','$amount','$datetime')";
            $db->sql($sql);
            $sql = "SELECT * FROM staffs WHERE id = $staff_id ";
            $db->sql($sql);
            $res = $db->getResult();
            $response['success'] = true;
            $response['message'] = "Withdrawal Requested Successfully";
            $response['data'] = $res;
            print_r(json_encode($response));
    
        }
        else{
            $response['success'] = false;
            $response['message'] = "Insufficent Balance";
            print_r(json_encode($response)); 
        }
    
    }
    else{
        $response['success'] = false;
        $response['message'] = "Required Minimum Amount to Withdrawal is ".$min_withdrawal;
        print_r(json_encode($response)); 
    }
}else{
    $response['success'] = false;
    $response['message'] = "Staff Not Found";
    print_r(json_encode($response)); 

}






?>