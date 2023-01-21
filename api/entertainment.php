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
if (empty($_POST['start_timestamp'])) {
    $response['success'] = false;
    $response['message'] = "Start Timestamp is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['end_timestamp'])) {
    $response['success'] = false;
    $response['message'] = "End Timestamp is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$type = $db->escapeString($_POST['type']);
$start_timestamp = $db->escapeString($_POST['start_timestamp']);
$end_timestamp = $db->escapeString($_POST['end_timestamp']);
$time1 = new DateTime($start_timestamp);
$time2 = new DateTime($end_timestamp);
$interval = $time1->diff($time2);
$time = $interval->format('%i');
$sql = "INSERT INTO entertainments(`user_id`,`type`,`time`) VALUES ('$user_id','$type','$time')";
$db->sql($sql);
$result = $db->getResult();
print_r(json_encode($response));
?>
