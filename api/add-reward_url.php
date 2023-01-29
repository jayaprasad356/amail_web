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

$sql = "SELECT id,secret_codes FROM coupons WHERE secret_codes='$secret_code' AND status=1";
$db->sql($sql);
$result = $db->getResult();
if(!empty($result)){
    $code_id=$result[0]['id'];
    $sql = "UPDATE `coupons` SET status=2 WHERE id='$code_id'";
    $db->sql($sql);
    $sql = "UPDATE `users_url` SET coupon_code='$secret_code' WHERE url_id='$url_id' AND user_id='$user_id'";
    $db->sql($sql);
    $response['success'] = true;
    $response['message'] = "Code Rewarded Successfully";
}
else{
    $response['success'] = false;
    $response['message'] = "Invalid Secret Code";
}
print_r(json_encode($response));
?>
