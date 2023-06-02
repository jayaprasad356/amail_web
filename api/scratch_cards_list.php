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

$sql = "SELECT * FROM scratch_cards WHERE user_id = '$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $response['success'] = true;
    $response['message'] = "Scratch cards listed successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
} else {
    $sql = "INSERT INTO scratch_cards (user_id) VALUES ('$user_id')";
    $db->sql($sql);
    $sql = "SELECT * FROM scratch_cards WHERE user_id = '$user_id'";
    $db->sql($sql);
    $res = $db->getResult();
    
    $response['success'] = true;
    $response['message'] = "Scratch cards listed successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}
?>
