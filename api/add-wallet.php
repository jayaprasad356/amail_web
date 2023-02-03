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

if($amount>=500){
         $sql = "SELECT sync_refer_wallet FROM users WHERE id='$user_id'";
         $db->sql($sql);
         $res = $db->getResult();
         $sync_refer_wallet=$res[0]['sync_refer_wallet'];
         if($amount<= $sync_refer_wallet){
                    $sql = "UPDATE `users` SET `sync_refer_wallet` = sync_refer_wallet - $amount,`earn`=earn + $amount,`refer_balance`=refer_balance + $amount WHERE id = '$user_id'";
                    $db->sql($sql);
                    $response['success'] = true;
                    $response['message'] = "Successfully Transfered";
                    print_r(json_encode($response));

         }
         else{
                    $response['success'] = false;
                    $response['message'] = "Insufficient Balance in Sync Refer Wallet";
                    print_r(json_encode($response));

         }


}
else{
    $response['success'] = false;
    $response['message'] = "Minimum Transfered Amount is 500";
    print_r(json_encode($response));

}

?>
