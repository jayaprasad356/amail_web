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

if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$type = $db->escapeString($_POST['type']);
$datetime = date('Y-m-d H:i:s');
if($type == 'champion'){
    $sql = "SELECT id,trial_count,device_id,referred_by,branch_id FROM  users WHERE id='$user_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $trial_count=$res[0]['trial_count'];
    if ($trial_count< 10) {
        $device_id=$res[0]['device_id'];
        $referred_by=$res[0]['referred_by'];
        $branch_id = $res[0]['branch_id'];
        $sql = "SELECT * FROM branches WHERE id = '$branch_id'";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num >= 1) {
            $trial_earnings = $res[0]['trial_earnings'];
    
        }else{
            $trial_earnings = '0';
        }
        $sql = "SELECT COUNT(id) AS count FROM  users WHERE device_id='$device_id'";
        $db->sql($sql);
        $res = $db->getResult();
        $count=$res[0]['count'];
        $sql = "UPDATE users SET trial_count=trial_count+1  WHERE id = '$user_id'";
        $db->sql($sql);
        $res = $db->getResult();
        $sql = "UPDATE users SET champion_trial = 1  WHERE id = '$user_id' AND  trial_count = 10";
        $db->sql($sql);
        if($count == 1 && $trial_earnings == '1'  && !empty($referred_by)){
            // $sql = "UPDATE users SET valid = 1 WHERE id = '$user_id' AND  champion_trial = 1 AND regular_trial = 1";
            // $db->sql($sql);
            // $sql = "SELECT valid,trial_bonus FROM  users WHERE id='$user_id'";
            // $db->sql($sql);
            // $res = $db->getResult();
            // $num = $db->numRows($res);
            // if ($num == 1) {
            //     $valid = $res[0]['valid'];
            //     $trial_bonus = $res[0]['trial_bonus'];
            //     if($valid == 1 && $trial_bonus == 0){
            //         $sql = "SELECT id FROM users WHERE refer_code = '$referred_by'";
            //         $db->sql($sql);
            //         $res = $db->getResult();
            //         $num = $db->numRows($res);
            //         if ($num == 1) {
            //             $ref_user_id = $res[0]['id'];
            //             $sql = "UPDATE `users` SET  `earn` = earn + 10,trial_wallet = trial_wallet + 10 WHERE `id` = $ref_user_id";
            //             $db->sql($sql);
            //             $sql = "UPDATE users SET trial_bonus = 1 WHERE id = '$user_id'";
            //             $db->sql($sql);
            //             $sql_query = "INSERT INTO transactions (user_id,amount,datetime,type)VALUES($ref_user_id,10,'$datetime','trial_bonus')";
            //             $db->sql($sql_query);
                
            //         }
    
    
            //     }
    
    
            // }
        }
        $response['success'] = true;
        $response['message'] = "Trial Added Successfully";
        $response['trial_count'] = $trial_count+1;
        print_r(json_encode($response));
    
    }else{
        $sql = "UPDATE users SET trial_expired=1  WHERE id = '$user_id'";
        $db->sql($sql);
        $response['success'] = false;
        $response['message'] = "Your Trial Period Expired";
        $response['trial_expired'] = "1";
        $response['trial_count'] = $trial_count;
        print_r(json_encode($response));
    
    }
    
}
else{
    $sql = "SELECT id,device_id,referred_by,branch_id FROM  users WHERE id='$user_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $device_id=$res[0]['device_id'];
    $referred_by=$res[0]['referred_by'];
    $branch_id = $res[0]['branch_id'];
    $sql = "SELECT * FROM branches WHERE id = '$branch_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num >= 1) {
        $trial_earnings = $res[0]['trial_earnings'];

    }else{
        $trial_earnings = '0';
    }
    $sql = "SELECT COUNT(id) AS count FROM  users WHERE device_id='$device_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $count = $res[0]['count'];
    $sql = "UPDATE users SET regular_trial = 1  WHERE id = '$user_id'";
    $db->sql($sql);
    if($count == 1 && $trial_earnings == '1' && !empty($referred_by)){
           
        $sql = "UPDATE users SET valid = 1  WHERE id = '$user_id' AND  regular_trial = 1";
        $db->sql($sql);
        $sql = "SELECT valid,trial_bonus FROM  users WHERE id='$user_id'";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num == 1) {
            $valid = $res[0]['valid'];
            $trial_bonus = $res[0]['trial_bonus'];
            if($valid == 1 && $trial_bonus == 0){
                $sql = "SELECT id FROM users WHERE refer_code = '$referred_by'";
                $db->sql($sql);
                $res = $db->getResult();
                $num = $db->numRows($res);
                if ($num == 1) {
                    $ref_user_id = $res[0]['id'];
                    $sql = "UPDATE `users` SET  `earn` = earn + 10,trial_wallet = trial_wallet + 10 WHERE `id` = $ref_user_id";
                    $db->sql($sql);
                    $sql = "UPDATE users SET trial_bonus = 1 WHERE id = '$user_id'";
                    $db->sql($sql);
                    $sql_query = "INSERT INTO transactions (user_id,amount,datetime,type)VALUES($ref_user_id,10,'$datetime','trial_bonus')";
                    $db->sql($sql_query);
            
                }


            }


        }
    }
    $response['success'] = true;
    $response['message'] = "Trial Added Successfully";
    print_r(json_encode($response));

}

?>