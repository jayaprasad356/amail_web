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
$currentdate = date('Y-m-d');


$sql = "SELECT *,DATEDIFF( '$currentdate',joined_date) AS history FROM users";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
     foreach($res as $row){
        if($row['task_type']=='champion'){
            $sql = "UPDATE users SET mcg_timer=40 WHERE id=".$row['id'];
            $db->sql($sql);
        }
        if($row['task_type']=='champion'  && $row['history']>=30 ){
            $sql = "UPDATE users SET mcg_timer=45 WHERE id=".$row['id'];
            $db->sql($sql);
        }
        if($row['task_type']=='regular'){
            $sql = "UPDATE users SET mcg_timer=15 WHERE id=".$row['id'];
            $db->sql($sql);
        }
        if($row['task_type']=='regular'  && $row['history']>=30 ){
            $sql = "UPDATE users SET mcg_timer=20 WHERE id=".$row['id'];
            $db->sql($sql);
        }
        if($row['task_type']=='regular' && $row['history']>=15 && $row['total_referrals']==0){
            $sql = "UPDATE users SET mcg_timer=20 WHERE id=".$row['id'];
            $db->sql($sql);
        }
        if($row['task_type']=='champion' && $row['history']>=15 && $row['total_referrals']==0){
            $sql = "UPDATE users SET mcg_timer=45 WHERE id=".$row['id'];
            $db->sql($sql);
        }
        if($row['total_codes']>=60000){
            $sql = "UPDATE users SET code_generate=0 WHERE id=".$row['id'];
            $db->sql($sql);
        }
        $result = $db->getResult();
     }
   
    $response['success'] = true;
    $response['message'] = "Successfully Updated";
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "No Users Found";
    print_r(json_encode($response));
}

?>