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
$db = new Database();
$db->connect();


if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['url_id'])) {
    $response['success'] = false;
    $response['message'] = "URL Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['secret_code'])) {
    $response['success'] = false;
    $response['message'] = "Secret Code is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$url_id = $db->escapeString($_POST['url_id']);
$secret_code = $db->escapeString($_POST['secret_code']);
$datetime = date('Y-m-d H:i:s');
$sql = "UPDATE `urls` SET `views` = views + 1 WHERE url_id = $user_id";
$db->sql($sql);
$sql = "INSERT INTO `users_url` (user_id,url_id,secret_codes,datetime) VALUES ('$user_id','$url_id','$secret_code','$datetime')";
$db->sql($sql);

$response['success'] = true;
$response['message'] = "Code Rewarded Successfully";
print_r(json_encode($response));
?>
