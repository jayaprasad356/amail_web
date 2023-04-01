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
$fn->monitorApi('check_bank_details');

if (empty($_POST['staff_id'])) {
    $response['success'] = false;
    $response['message'] = "Staff ID is empty";
    echo json_encode($response);
    exit; 
}

if (empty($_POST['amount'])) {
    $response['success'] = false;
    $response['message'] = "Amount is empty";
    echo json_encode($response);
    exit; 
}

$staff_id = $db->escapeString($_POST['staff_id']);
$amount = $db->escapeString($_POST['amount']);

$sql = "SELECT * FROM staffs WHERE id = $staff_id";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if($num == 1){
    $staff = $res[0];
    $has_bank_details = (!empty($staff['bank_name']) && !empty($staff['bank_account_number']));
    if($has_bank_details){
        
        $sql = "INSERT INTO staff_withdrawal_request (staff_id, amount) VALUES ('$staff_id', '$amount')";
        $db->sql($sql);
        $response['success'] = true;
        $response['message'] = "Withdrawal request submitted successfully.";
        echo json_encode($response); 
    }else{
        $response['success'] = false;
        $response['message'] = "Staff does not have bank details. Please update your bank details.";
        echo json_encode($response); 
    }
}else{
    $response['success'] = false;
    $response['message'] = "Staff not found.";
    echo json_encode($response); 
}
