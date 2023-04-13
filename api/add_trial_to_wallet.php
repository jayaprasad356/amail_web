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
include_once('../includes/functions.php');
$fn = new functions;

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
$datetime = date('Y-m-d H:i:s');
$user_id = $db->escapeString($_POST['user_id']);
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$db->sql($sql);
$ures = $db->getResult();
$num = $db->numRows($ures);
if ($num >= 1) {
    $sql = "SELECT id FROM bank_details WHERE user_id = $user_id ";
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num >= 1) {
        $amount = $ures[0]['trial_wallet'];
        if($amount >= 100){
            $sql = "SELECT trial_wallet FROM users WHERE id = '$user_id'";
            $db->sql($sql);
            $result = $db->getResult();
            $trial_wallet = $result[0]['trial_wallet'];
            if($amount <= $trial_wallet){
                $sql = "UPDATE `users` SET `trial_wallet` = trial_wallet - $amount,`withdrawal` = withdrawal + $amount WHERE `id` = $user_id";
                $db->sql($sql);
                $sql = "INSERT INTO withdrawals (`user_id`,`amount`,`datetime`,`withdrawal_type`)VALUES('$user_id','$amount','$datetime','trial_withdrawal')";
                $db->sql($sql);
                $sql = "SELECT trial_wallet,balance,refer_balance FROM users WHERE id = $user_id ";
                $db->sql($sql);
                $res = $db->getResult();
                $balance = $res[0]['balance'];
                $refer_balance = $res[0]['refer_balance'];
                $response['success'] = true;
                $response['balance'] = $balance;
                $response['refer_balance'] = $refer_balance;
                $response['trial_wallet'] = $trial_wallet;
                $response['message'] = "Withdrawal Requested Successfully";
                print_r(json_encode($response));
    
            }
            else{
                $response['success'] = false;
                $response['message'] = "Trial Wallet is Low";
                print_r(json_encode($response));
            }
    
    
        }
        else{
            $response['success'] = false;
            $response['message'] = "Minimum Amount is Rs.100";
            print_r(json_encode($response));
        }

    }else{
        $response['success'] = false;
        $response['message'] = "Update Bank Details first";
        print_r(json_encode($response)); 
    
    }

}else{
    $response['success'] = false;
    $response['message'] = "No Users Found";
    print_r(json_encode($response));

}

?>