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

if (empty($_POST['staffs_id'])) {
    $response['success'] = false;
    $response['message'] = "staffs Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['Bank_Account_Number'])) {
    $response['success'] = false;
    $response['message'] = "Bank_Account_Number is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['IFSC_code'])) {
    $response['success'] = false;
    $response['message'] = "IFSC_code is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['Bank_name'])) {
    $response['success'] = false;
    $response['message'] = "Bank_name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['Branch'])) {
    $response['success'] = false;
    $response['message'] = "Branch is Empty";
    print_r(json_encode($response));
    return false;
}

$staffs_id = $db->escapeString($_POST['staffs_id']);
$Bank_Account_Number = $db->escapeString($_POST['Bank_Account_Number']);
$IFSC_code = $db->escapeString($_POST['IFSC_code']);
$Bank_name = $db->escapeString($_POST['Bank_name']);
$Branch = $db->escapeString($_POST['Branch']);


$sql = "SELECT * FROM staffs WHERE id=" . $staffs_id;
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $sql = "UPDATE staffs SET Bank_Account_Number='$Bank_Account_Number',IFSC_code='$IFSC_code',Bank_name='$Bank_name',Branch='$Branch' WHERE id=" . $staffs_id;
    $db->sql($sql);
    $sql = "SELECT * FROM staffs WHERE id=" . $staffs_id;
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Bank details Updated Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
    return false;
}
else{
    
    $response['success'] = false;
    $response['message'] ="Not Found";
    print_r(json_encode($response));
    return false;

}

?>