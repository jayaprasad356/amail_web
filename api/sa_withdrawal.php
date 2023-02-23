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


$sql = "SELECT salary_advance_balance,ongoing_sa_balance,refer_balance FROM users WHERE id = $user_id ";
$db->sql($sql);
$res = $db->getResult();
$user_num=$db->numRows($res);
$salary_advance_balance = $res[0]['salary_advance_balance'];
if($user_num >= 1 ){
        if($amount <= $salary_advance_balance){
                    $sql = "UPDATE `users` SET `salary_advance_balance` = salary_advance_balance - $amount,`ongoing_sa_balance` = ongoing_sa_balance + $amount,`refer_balance`=refer_balance + $amount WHERE `id` = $user_id";
                    $db->sql($sql);
                    $sql = "INSERT INTO salary_advance_trans (`user_id`,`refer_user_id`,`amount`,`datetime`,`type`)VALUES('','$user_id','$amount','$datetime','debit')";
                    $db->sql($sql);

                    // Calculate EMI due dates
                    $emi_count = ceil($amount / 500);
                    $due_dates = array();
                    for ($i = 1; $i <= $emi_count; $i++) {
                        $due_date = date('Y-m-d', strtotime("+$i week", strtotime($datetime)));
                        array_push($due_dates, $due_date);
                    }
                    //calculate Due Amount
                    $due_amount = $amount / $emi_count;

                    // Add due dates to the database
                    foreach ($due_dates as $due_date) {
                        $sql = "INSERT INTO repayments (`user_id`, amount, `due_date`, `status`) VALUES ('$user_id', '$due_amount', '$due_date', 0)";
                        $db->sql($sql);
                    }

                    $sql = "SELECT salary_advance_balance,ongoing_sa_balance,refer_balance FROM users WHERE id = $user_id ";
                    $db->sql($sql);
                    $res = $db->getResult();
                    $salary_advance_balance = $res[0]['salary_advance_balance'];
                    $ongoing_sa_balance = $res[0]['ongoing_sa_balance'];
                    $refer_balance = $res[0]['refer_balance'];
                    $response['success'] = true;
                    $response['salary_advance_balance'] = $salary_advance_balance;
                    $response['ongoing_sa_balance'] = $ongoing_sa_balance;
                    $response['refer_balance'] = $refer_balance;
                    $response['message'] = "Successfully Transfered to refer_balance";
                    print_r(json_encode($response));
            
        }
        else{
            $response['success'] = false;
            $response['message'] = "Insufficent Balance";
            print_r(json_encode($response)); 
        }
   
}else{
    $response['success'] = false;
    $response['message'] = "User Not Found";
    print_r(json_encode($response));    
}






?>