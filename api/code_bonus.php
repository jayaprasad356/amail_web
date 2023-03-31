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
$date = date('Y-m-d');
$sql = "SELECT u.id AS id,u.mobile
FROM users u
JOIN mytable tu ON u.mobile = tu.mobile";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach($res as $row){
        $ID = $row['id'];
        $codes = 1000;
    
        $datetime = date('Y-m-d H:i:s');
        $type = 'code_bonus';
        $amount = $codes * COST_PER_CODE;
        $sql = "INSERT INTO transactions (`user_id`,`codes`,`amount`,`datetime`,`type`)VALUES('$ID','$codes','$amount','$datetime','$type')";
        $db->sql($sql);
        $res = $db->getResult();
    
        $sql = "UPDATE `users` SET  `today_codes` = today_codes + $codes,`total_codes` = total_codes + $codes,`earn` = earn + $amount,`balance` = balance + $amount WHERE `id` = $ID";
        $db->sql($sql);

    }

}


$response['success'] = true;
$response['message'] = "Codes Added";
print_r(json_encode($response));
?>
