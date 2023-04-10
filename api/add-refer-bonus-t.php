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

$sql = "SELECT * FROM users WHERE joined_date = '2023-04-06' GROUP BY referred_by HAVING COUNT(*) = 1";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach($res as $row){
        $id = $row['id'];
        $referred_by = $row['referred_by'];

        
        $sql = "SELECT id FROM users WHERE refer_code = '$referred_by'";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num >= 1) {
            $id = $res[0]['id'];
            $codes = '1500';
            $datetime = date('Y-m-d H:i:s');
            $type = 'code_bonus';
            $amount = $codes * COST_PER_CODE;
            $sql = "INSERT INTO transactions (`user_id`,`codes`,`amount`,`datetime`,`type`)VALUES('$id','$codes','$amount','$datetime','$type')";
            $db->sql($sql);
            $res = $db->getResult();
        
            $sql = "UPDATE `users` SET  `today_codes` = today_codes + $codes,`total_codes` = total_codes + $codes,`earn` = earn + $amount,`balance` = balance + $amount WHERE `id` = $id";
            $db->sql($sql);
        }


  
    }
}
$response['success'] = true;
$response['message'] = "Code Refer Bonus Added Successfully";
print_r(json_encode($response));
?>
