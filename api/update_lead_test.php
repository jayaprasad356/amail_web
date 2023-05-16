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
include_once('../includes/functions.php');
$fn = new functions;

$sql = "SELECT id FROM users WHERE referred_by = 'YMS' AND status = 0";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
$lead_ids = [4, 5, 9, 7];
$random_id = 0;
foreach ($res as $row) {
    $id = $row['id'];
    $lead_id = $lead_ids[$random_id];
    if($random_id == 3){
        $random_id = 0;

    }else{
        $random_id = $random_id + 1;
    }
    
    $sql = "UPDATE `users` SET  `lead_id` = $lead_id WHERE `id` = $id";
    $db->sql($sql);
    
}
$response['success'] = true;
$response['message'] = "Updated Successfully";
print_r(json_encode($response));

?>