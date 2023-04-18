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

$sql = "SELECT name,city FROM `users` WHERE status = 1 ORDER BY id DESC LIMIT 1";
$db->sql($sql);
$res = $db->getResult();
$name = $res[0]['name'];
$city = $res[0]['city'];
$latest_joined = $name . ' joined from '.$city;


$sql = "SELECT user_id FROM `transactions` WHERE type = 'refer_bonus' ORDER BY id DESC LIMIT 1";
$db->sql($sql);
$res = $db->getResult();
$user_id = $res[0]['user_id'];

$sql = "SELECT name FROM `users` WHERE id = $user_id";
$db->sql($sql);
$res = $db->getResult();
$name = $res[0]['name'];
$latest_refer = $name.' received refer bonus';
$response['success'] = true;
$response['message'] = "Explore Info Retrived";
$response['latest_joined'] = $latest_joined;
$response['latest_refer'] =$latest_refer;
print_r(json_encode($response));

?>
