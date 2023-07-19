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
$fn->monitorApi('register');
date_default_timezone_set('Asia/Kolkata');

if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobilenumber is Empty";
    print_r(json_encode($response));
    return false;
}
if (strlen($_POST['mobile']) !== 10) {
    $response['success'] = false;
    $response['message'] = "Mobile number should be exactly 10 digits,please remove if +91 is there";
    print_r(json_encode($response));
    return false;
}



if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "Password is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['city'])) {
    $response['success'] = false;
    $response['message'] = "City Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['dob'])) {
    $response['success'] = false;
    $response['message'] = "Date of Birth is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['device_id'])) {
    $response['success'] = false;
    $response['message'] = "Device Id is Empty";
    print_r(json_encode($response));
    return false;
}
$name = $db->escapeString($_POST['name']);
$mobile = $db->escapeString($_POST['mobile']);
$email = $db->escapeString($_POST['email']);
$password = $db->escapeString($_POST['password']);
$city = $db->escapeString($_POST['city']);
$referred_by = (isset($_POST['referred_by']) && !empty($_POST['referred_by'])) ? $db->escapeString($_POST['referred_by']) : "";
$dob = $db->escapeString($_POST['dob']);
$device_id = $db->escapeString($_POST['device_id']);

$sql = "SELECT id FROM users WHERE device_id='$device_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $response['success'] = false;
    $response['message'] ="User Already Registered with this device kindly register with new device";
    print_r(json_encode($response));
    return false;
}

$sql = "SELECT * FROM users WHERE mobile='$mobile'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $response['success'] = false;
    $response['message'] ="Mobile Number Already Exists";
    print_r(json_encode($response));
    return false;
}
else{


    
    $datetime = date('Y-m-d H:i:s');
    $sql = "INSERT INTO users (`name`,`mobile`,`email`,`password`,`city`,`dob`,`referred_by`,`device_id`,`last_updated`,`registered_date`)VALUES('$name','$mobile','$email','$password','$city','$dob','$referred_by','$device_id','$datetime','$datetime')";
    $db->sql($sql);
    $sql = "SELECT * FROM users WHERE mobile = '$mobile'";
    $db->sql($sql);
    $res = $db->getResult();
    $user_id = $res[0]['id'];


    if(empty($referred_by)){
        $refer_code = MAIN_REFER . $user_id;

    }
    else{
        if (strlen($referred_by) < 3) {
            $refer_code = MAIN_REFER . $user_id;

        }
        else{
            $refershot = substr($referred_by, 0, 3);
            $sql = "SELECT refer_code FROM admin WHERE refer_code = '$refershot'";
            $db->sql($sql);
            $ares = $db->getResult();
            $num = $db->numRows($ares);
            if ($num >= 1) {
                $refer_code_db = $ares[0]['refer_code'];
                $refer_code = $refer_code_db . $user_id;

            }else{
                $refer_code = MAIN_REFER . $user_id;

            }

            
        }
        // $admincode = substr($referred_by, 0, -5);

        // $result = $db->getResult();
        // $num = $db->numRows($result);
        // if($num>=1){
        //     $refer_code = substr($referred_by, 0, -5) . $user_id;
        // }
        // else{
        //     $refer_code = MAIN_REFER . $user_id;
        // }
    }

    $short_code = substr($refer_code, 0, 3);
    $sql = "SELECT short_code,id FROM branches WHERE short_code = '$short_code'";
    $db->sql($sql);
    $sres = $db->getResult();
    $num = $db->numRows($sres);
    if ($num >= 1) {
        $branch_id = $sres[0]['id'];

    }else{
        $branch_id = '1';
    }

    $sql_query = "UPDATE users SET refer_code='$refer_code',branch_id = $branch_id WHERE id =  $user_id";
    $db->sql($sql_query);
    
    $sql = "SELECT * FROM settings";
    $db->sql($sql);
    $setres = $db->getResult();

    $sql = "SELECT * FROM users WHERE mobile = '$mobile'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Successfully Registered";
    $response['data'] = $res;
    $response['settings'] = $setres;
    print_r(json_encode($response));


}

?>