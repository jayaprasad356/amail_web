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
$function = new functions;
include_once('../includes/custom-functions.php');
$fn = new custom_functions;
$function->monitorApi('wallet');

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}



$user_id = $db->escapeString($_POST['user_id']);
$task_type = (isset($_POST['task_type']) && $_POST['task_type'] != "") ? $db->escapeString($_POST['task_type']) : '';
$codes = (isset($_POST['codes']) && $_POST['codes'] != "") ? $db->escapeString($_POST['codes']) : 0;
$datetime = date('Y-m-d H:i:s');

$type = 'generate';
$sql = "SELECT code_generate,num_sync_times,level,total_codes FROM users WHERE id = $user_id";
$db->sql($sql);
$ures = $db->getResult();
$user_code_generate = $ures[0]['code_generate'];
$sql = "SELECT code_generate,num_sync_times,sync_codes FROM settings";
$db->sql($sql);
$set = $db->getResult();
$code_generate = $set[0]['code_generate'];
$sync_codes = $set[0]['sync_codes'];



$sql = "SELECT datetime FROM transactions WHERE user_id = $user_id AND type = 'generate' ORDER BY datetime DESC LIMIT 1 ";
$db->sql($sql);
$tres = $db->getResult();
$num = $db->numRows($tres);
$code_min_sync_time = $fn->get_sync_time($ures[0]['level']);
if ($num >= 1) {
    $dt1 = $tres[0]['datetime'];
    $date1 = new DateTime($dt1);
    $date2 = new DateTime($datetime);

    $diff = $date1->diff($date2);
    $totalMinutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
    $dfi = $code_min_sync_time - $totalMinutes;
    if($totalMinutes < $code_min_sync_time){
        $response['success'] = false;
        $response['message'] = "Cannot Sync Right Now, Try again after ".$dfi." mins";
        print_r(json_encode($response));
        return false;

    }


}

if($code_generate == 1 && $user_code_generate == 1){
    if($codes != 0){

            // if ($sync_codes != $codes) {
            //     $response['success'] = false;
            //     $response['message'] = "Please Sync Only ".$sync_codes." Codes";
            //     print_r(json_encode($response));
            //     return false;
            // }
            $currentdate = date('Y-m-d');
            $per_code_cost = $fn->get_code_per_cost($user_id);
            $amount = $codes  * $per_code_cost;
            $sql = "SELECT COUNT(id) AS count  FROM transactions WHERE user_id = $user_id AND DATE(datetime) = '$currentdate' AND type = 'generate'";
            $db->sql($sql);
            $tres = $db->getResult();
            $t_count = $tres[0]['count'];
            if ($t_count >= $ures[0]['num_sync_times']) {
                $response['success'] = false;
                $response['message'] = "You Reached Daily Sync Limit";
                print_r(json_encode($response));
                return false;
            }

            if ($ures[0]['total_codes'] >= 60000) {
                $sql = "UPDATE `users` SET  `code_generate` = 0 WHERE `id` = $user_id";
                $db->sql($sql);
                $response['success'] = false;
                $response['message'] = "You Reached Codes Limit";
                print_r(json_encode($response));
                return false;
            }
    
            $sql = "INSERT INTO transactions (`user_id`,`codes`,`amount`,`datetime`,`type`,`task_type`)VALUES('$user_id','$codes','$amount','$datetime','$type','$task_type')";
            $db->sql($sql);
            $res = $db->getResult();
        
            $sql = "UPDATE `users` SET  `today_codes` = today_codes + $codes,`total_codes` = total_codes + $codes,`earn` = earn + $amount,`balance` = balance + $amount,`last_updated` = '$datetime' WHERE `id` = $user_id";
            $db->sql($sql);
    
    
            $sql = "SELECT referred_by  FROM users WHERE id = $user_id AND status = 1";
            $db->sql($sql);
            $res = $db->getResult();
            $num = $db->numRows($res);
            
        
            if($num == 1){
                $referred_by = $res[0]['referred_by'];
            
                
                $referamtcode = $codes * REFER_COST_PER_CODE;
                
                $sql = "SELECT id,mobile FROM users WHERE `refer_code` = '$referred_by' ";
                $db->sql($sql);
                $rep= $db->getResult();
                $sql = "UPDATE `users` SET  `sync_refer_wallet` = sync_refer_wallet + $referamtcode WHERE `refer_code` = '$referred_by'";
                $db->sql($sql);
                $response['sync'] = "Code Sync Successfully";
        
            }
        }
     
    
    $sql = "SELECT level,per_code_val,today_codes,total_codes,balance,code_generate,status,referred_by,refund_wallet,total_refund,black_box  FROM users WHERE id = $user_id ";
    $db->sql($sql);
    $res = $db->getResult();
    
    $response['success'] = true;
    $response['message'] = "Code Added Successfully";
    $response['black_box'] = $res[0]['black_box'];
    $response['status'] = $res[0]['status'];
    $response['balance'] = $res[0]['balance'];
    $response['level'] = $res[0]['level'];
    $response['per_code_val'] = $res[0]['per_code_val'];
    $response['today_codes'] = $res[0]['today_codes'];
    $response['total_codes'] = $res[0]['total_codes'];
    $response['code_generate'] = $res[0]['code_generate'];
    $response['status'] = $res[0]['status'];
    $response['refund_wallet'] = $res[0]['refund_wallet'];
    $response['total_refund'] = $res[0]['total_refund'];
    print_r(json_encode($response));
}
else{
  
    $response['success'] = false;
    $response['message'] = "Cannot Sync Right Now, Code Generate is turned off";
    print_r(json_encode($response));
}



?>