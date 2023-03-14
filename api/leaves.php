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
include_once('../includes/functions.php');
$fn = new functions;

$date = date('Y-m-d');

$sql = "SELECT * FROM settings";
$db->sql($sql);
$set = $db->getResult();
$code_generate = $set[0]['code_generate'];

$sql = "SELECT * FROM leaves WHERE date='$date' AND status=1";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $type = $res[0]['type'];

    if ($type == "User_leave") {
        $user_ids = [];
        foreach ($res as $row) {
            $user_ids[] = $row['user_id'];
        }
        $user_ids_str = implode(',', $user_ids);

        $sql = "UPDATE `users` SET `code_generate` = 0 WHERE  `id` IN ($user_ids_str)";
        $db->sql($sql);

        $sql = "UPDATE `users` SET `worked_days` = worked_days + 1 WHERE `id` NOT IN ($user_ids_str)";
        $db->sql($sql);
    } else if ($type == "Common_leave") {
        $sql = "UPDATE `users` SET `worked_days` = worked_days + 0";
        $db->sql($sql);
        $sql = "UPDATE `settings` SET `code_generate` = 0 WHERE `id` = 1";
        $db->sql($sql);
    }

    $response['success'] = true;
    $response['message'] = "Leave Updated Successfully";
} else {
    $sql = "UPDATE `users` SET `worked_days` = worked_days + 1";
    $db->sql($sql);

    $response['success'] = true;
    $response['message'] = "Worked Days Added Successfully";
}

print_r(json_encode($response));
