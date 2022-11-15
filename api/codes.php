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
if (empty($_POST['codes'])) {
    $response['success'] = false;
    $response['message'] = "Codes is Empty";
    print_r(json_encode($response));
    return false;
}


$user_id = $db->escapeString($_POST['user_id']);
$codes = $db->escapeString($_POST['codes']);
$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO codes (`user_id`,`codes`,`date`)VALUES('$user_id','$codes','$date')";
$db->sql($sql);
$res = $db->getResult();
$response['success'] = true;
$response['message'] = "Codes added Successfully";
$response['data'] = $res;
print_r(json_encode($response));


?>