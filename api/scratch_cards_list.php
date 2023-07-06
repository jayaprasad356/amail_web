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
include_once('../includes/custom-functions.php');
include_once('../includes/functions.php');
$fn = new custom_functions;

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "user_id is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);

$currentdate = date('Y-m-d');
$sql = "SELECT * FROM scratch_cards sc,users u WHERE sc.user_id = u.id AND sc.user_id = '$user_id' AND sc.expiry_date > '$currentdate' AND sc.status = 1 AND u.status = 0";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['user_id'] = $row['user_id'];
        $temp['discount'] = $row['discount'];
        $temp['expiry_date'] = $row['expiry_date'];
        $temp['is_scratched'] = $row['is_scratched'];
        $temp['status'] = $row['status'];
        $rows[] = $temp;
    }
    $response['success'] = true;
    $response['message'] = "Scratch cards listed successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));
} else {
    $response['success'] = true;
    $response['message'] = "No Scratch cards";
    print_r(json_encode($response));
}
?>
