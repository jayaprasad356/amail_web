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
if (empty($_POST['ty'])) {
    $response['success'] = false;
    $response['message'] = "Device Id is Empty";
    print_r(json_encode($response));
    return false;
}

$sql = "SELECT * FROM users WHERE mobile ='$mobile' AND password ='$password' AND device_id ='$device_id'";
$db->sql($sql);
$res = $db->getResult();
$push = new Push(
    $db_con->escapeString($fn->xss_clean($_POST['title'])),
    $db_con->escapeString($fn->xss_clean($_POST['description'])),
    null,
    $type,
    $id
);
$mPushNotification = $push->getPush();


//creating firebase class object 
$firebase = new Firebase(); 

//sending push notification and displaying result 
$firebase->send($devicetokens, $mPushNotification);
$response['success'] = true;
$response['message'] = "Notification Send Successfully";
print_r(json_encode($response));

?>