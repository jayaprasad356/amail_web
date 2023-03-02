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
$fn->monitorApi('withdrawal');

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['amount'])) {
    $response['success'] = false;
    $response['message'] = "Amount is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$amount = $db->escapeString($_POST['amount']);
$datetime = date('Y-m-d H:i:s');

$sql = "SELECT * FROM settings";
$db->sql($sql);
$mres = $db->getResult();
$main_ws = $mres[0]['withdrawal_status'];
$sql = "SELECT salary_advance_balance,ongoing_sa_balance,refer_balance,sa_refer_count,withdrawal_status FROM users WHERE id = $user_id ";
$db->sql($sql);
$res = $db->getResult();
$user_num=$db->numRows($res);
$sql = "SELECT id FROM bank_details WHERE user_id = $user_id ";
$db->sql($sql);
$bankres = $db->getResult();
$bank_num=$db->numRows($bankres);

$salary_advance_balance = $res[0]['salary_advance_balance'];
$sa_refer_count = $res[0]['sa_refer_count'];
$ongoing_sa_balance = $res[0]['ongoing_sa_balance'];
$withdrawal_status = $res[0]['withdrawal_status'];
if($user_num >= 1 ){
    if($withdrawal_status == 1 && $main_ws == 1 ){
        if($bank_num >= 1){
            if($amount <= $salary_advance_balance){
                if($ongoing_sa_balance == 0){
                      if($amount==2000){
                          $sql="UPDATE `users` SET `sa_refer_count` = sa_refer_count - 10 WHERE `id` = $user_id";
                          $db->sql($sql);
                      }
                      elseif($amount==3000){
                          $sql="UPDATE `users` SET `sa_refer_count` = sa_refer_count - 15 WHERE `id` = $user_id";
                          $db->sql($sql);
                      }
                      else{
                          $sql="UPDATE `users` SET `sa_refer_count` = sa_refer_count - 20 WHERE `id` = $user_id";
                          $db->sql($sql);
                      }
                      $sql = "UPDATE `users` SET `salary_advance_balance` = salary_advance_balance - $amount,`ongoing_sa_balance` = ongoing_sa_balance + $amount,`withdrawal` = withdrawal + $amount,`refer_balance`=refer_balance + $amount WHERE `id` = $user_id";
                      $db->sql($sql);
                      $sql = "INSERT INTO withdrawals (`user_id`,`amount`,`datetime`,`withdrawal_type`)VALUES('$user_id','$amount','$datetime','sa_withdrawal')";
                      $db->sql($sql);
                      $sql = "INSERT INTO salary_advance_trans (`user_id`,`refer_user_id`,`amount`,`datetime`,`type`)VALUES('','$user_id','$amount','$datetime','debit')";
                      $db->sql($sql);
                      $sql = "UPDATE `repayments` SET `expiry`=1 WHERE `user_id` = $user_id";
                      $db->sql($sql);
    
    
                      $sql = "SELECT salary_advance_balance,ongoing_sa_balance,refer_balance,sa_refer_count FROM users WHERE id = $user_id ";
                      $db->sql($sql);
                      $res = $db->getResult();
                      $salary_advance_balance = $res[0]['salary_advance_balance'];
                      $ongoing_sa_balance = $res[0]['ongoing_sa_balance'];
                      $refer_balance = $res[0]['refer_balance'];
                      $sa_refer_count = $res[0]['sa_refer_count'];
                      $response['success'] = true;
                      $response['salary_advance_balance'] = $salary_advance_balance;
                      $response['ongoing_sa_balance'] = $ongoing_sa_balance;
                      $response['refer_balance'] = $refer_balance;
                      $response['sa_refer_count'] = $sa_refer_count;
                      $response['message'] = "Withdrawal requested successfully";
                      print_r(json_encode($response));
                }
                else{
                    $response['success'] = false;
                    $response['message'] = "Please complete your ongoing salary balance";
                    print_r(json_encode($response));
                }
               
          }
          else{
              $response['success'] = false;
              $response['message'] = "Insufficent Balance";
              print_r(json_encode($response)); 
          }
    
        }
        else{
            $response['success'] = false;
            $response['message'] = "Update Bank Details";
            print_r(json_encode($response));  
        }
    }
    else{
        $response['success'] = false;
        $response['message'] = "Withdrawal Disabled Right Now,Please Try Again";
        print_r(json_encode($response));
        return false;
    }

   
}else{
    $response['success'] = false;
    $response['message'] = "User Not Found";
    print_r(json_encode($response));    
}






?>