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

if (empty($_POST['staff_id'])) {
    $response['success'] = false;
    $response['message'] = "staff Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "user Id is Empty";
    print_r(json_encode($response));
    return false;
}
$staff_id = $db->escapeString($_POST['staff_id']);
$user_id = $db->escapeString($_POST['user_id']);




$sql = "SELECT id FROM users WHERE support_id = '' AND id = $user_id";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $sql = "UPDATE `users` SET `support_id` = $support_id WHERE `support_id` = '' AND id = $user_id";
    $db->sql($sql);
    $response['success'] = true;
    $response['message'] = " User Taken Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] =" Not Found";
    print_r(json_encode($response));
}
?>
