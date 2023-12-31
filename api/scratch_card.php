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
$fn = new functions;
$fn->monitorApi('scractch_card');



if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "user_id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['scratch_id'])) {
    $response['success'] = false;
    $response['message'] = "scratch_id is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$scratch_id = $db->escapeString($_POST['scratch_id']);

$sql = "UPDATE scratch_cards SET is_scratched = 1  WHERE id = $scratch_id";
$db->sql($sql);
$response['success'] = true;
$response['message'] = "Scratch Cards Updated";
print_r(json_encode($response));
?>
