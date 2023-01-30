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
$dt1 = date('Y-m-d H:i:s');
$user_id = $db->escapeString($_POST['user_id']);
$delete_query = "DELETE FROM users_url WHERE user_id = $user_id AND datetime <= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
$result = $db->sql($delete_query);


$sql = "SELECT ad_show_time FROM settings";
$db->sql($sql);
$set = $db->getResult();
$ad_show_time = $set[0]['ad_show_time'];

$sql = "SELECT datetime FROM users_url WHERE user_id = '$user_id' ORDER BY id DESC";
$db->sql($sql);
$ures = $db->getResult();
$num = $db->numRows($ures);
if ($num >= 1) {
    $dt2 = $ures[0]['datetime'];
    $datetime1 = new DateTime($dt1);
    $datetime2 = new DateTime($dt2);
    $interval = $datetime1->diff($datetime2);
    $minutes = ($interval->h * 60) + $interval->i;
    
}else{
    $minutes = 0;

}
$ad_time_user = false;
$ad_show_time = intval($ad_show_time);
if($minutes == 0 || $minutes >= $ad_show_time){
    $ad_time_user = true;
    
}

$sql = "SELECT id,url,destination_url,codes FROM urls WHERE id NOT IN (SELECT url_id FROM users_url WHERE user_id = '$user_id') LIMIT 1";
$db->sql($sql);
$result = $db->getResult();

$sql = "SELECT ad_status,ad_type FROM settings";
$db->sql($sql);
$set = $db->getResult();
$ad_status = $set[0]['ad_status'];
$ad_type = $set[0]['ad_type'];
if(!empty($result) && $ad_type == 2 && $ad_status == 1 && $ad_time_user == true){
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
