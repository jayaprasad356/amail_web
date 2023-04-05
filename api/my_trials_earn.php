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
// $fn->monitorApi('userdetails');

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$sql = "SELECT trial_wallet,refer_code FROM users WHERE id = $user_id";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $refer_code = $res[0]['refer_code'];
    $trial_wallet = $res[0]['trial_wallet'];
    $sql = "SELECT * FROM users WHERE referred_by = '$refer_code' AND status = 0";
    $db->sql($sql);
    $res = $db->getResult();
    foreach($res as $row){
        $ref_user_id = $row['id'];
        $temp['name'] = $row['name'];
        $temp['mobile'] = $row['mobile'];
        $temp['valid'] = $row['valid'];
        $temp['regular_trial'] = $row['regular_trial'];
        $temp['champion_trial'] = $row['champion_trial'];
        if($row['valid'] == 1 && $row['trial_bonus'] == 0){
            $sql = "UPDATE users SET trial_wallet = trial_wallet + 10 WHERE id = '$user_id' AND  status = 0";
            $db->sql($sql);
            $sql = "UPDATE users SET trial_bonus = 1 WHERE id = '$ref_user_id'";
            $db->sql($sql);

        }


        $rows[]=$temp;
    }

    $sql = "SELECT trial_wallet,refer_code FROM users WHERE id = $user_id";
    $db->sql($sql);
    $ures = $db->getResult();
    $trial_wallet = $ures[0]['trial_wallet'];
    $response['success'] = true;
    $response['message'] = "Users listed Successfully";
    $response['trial_wallet'] = $trial_wallet;
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No User Found";
    print_r(json_encode($response));

}

?>