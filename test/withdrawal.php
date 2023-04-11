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

$sql = "SELECT * FROM `withdrawals` WHERE DATE(datetime) = '2023-04-10' AND status = 2";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach($res as $row){
        $id = $row['id'];
        $user_id = $row['user_id'];
        $amount = $row['amount'];
        $withdrawal_type = $row['withdrawal_type'];
        if($withdrawal_type == 'code_withdrawal'){
            $sql = "UPDATE `users` SET `balance` = balance - $amount,`withdrawal` = withdrawal + $amount WHERE `id` = $user_id";
            $db->sql($sql);
            $sql = "UPDATE `withdrawals` SET `status` = 1 WHERE `id` = $id";
            $db->sql($sql);

        }
        if($withdrawal_type == 'refer_withdrawal'){
            $sql = "UPDATE `users` SET `refer_balance` = refer_balance - $amount,`withdrawal` = withdrawal + $amount WHERE `id` = $user_id";
            $db->sql($sql);
            $sql = "UPDATE `withdrawals` SET `status` = 1 WHERE `id` = $id";
            $db->sql($sql);

        }

  
    }
}
$response['success'] = true;
$response['message'] = "Withdrawals Updated Successfully";
print_r(json_encode($response));

?>