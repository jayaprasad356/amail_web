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

$user_id = $db->escapeString($_POST['user_id']);
$delete_query = "DELETE FROM users_url WHERE user_id = $user_id AND datetime <= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
$result = $db->sql($delete_query);
$sql = "SELECT id,url,destination_url,codes FROM urls WHERE id NOT IN (SELECT url_id FROM users_url WHERE user_id = '$user_id')";
$db->sql($sql);
$result = $db->getResult();

$sql = "SELECT ad_status,ad_type FROM settings)";
$db->sql($sql);
$set = $db->getResult();
$ad_status = $set[0]['ad_status'];
$ad_type = $set[0]['ad_type'];
if(!empty($result) && $ad_type == 2 && $ad_status == 1){
    $response['success'] = true;
    $response['message'] = "URL's Listed Successfully";
    $response['data'] = $result;
}
else{
    $response['success'] = false;
    $response['message'] = "No new URLs available for the user";
}
print_r(json_encode($response));
?>
