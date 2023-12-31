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
if (empty($_POST['state'])) {
    $response['success'] = false;
    $response['message'] = "State is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['district'])) {
    $response['success'] = false;
    $response['message'] = "District is Empty";
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
$state = $db->escapeString($_POST['state']);
$district = $db->escapeString($_POST['district']);


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
    $sql = "INSERT INTO users (`name`,`mobile`,`email`,`password`,`city`,`dob`,`referred_by`,`device_id`,`state`,`district`,`last_updated`)VALUES('$name','$mobile','$email','$password','$city','$dob','$referred_by','$device_id','$state','$district','$datetime')";
    $db->sql($sql);
    $sql = "SELECT * FROM users WHERE mobile = '$mobile'";
    $db->sql($sql);
    $res = $db->getResult();
    $user_id = $res[0]['id'];


    if(empty($referred_by)){
        $refer_code = MAIN_REFER . $user_id;

    }
    else{
        $admincode = substr($referred_by, 0, -5);
        $sql = "SELECT refer_code FROM admin WHERE refer_code='$admincode'";
        $db->sql($sql);
        $result = $db->getResult();
        $num = $db->numRows($result);
        if($num>=1){
            $refer_code = substr($referred_by, 0, -5) . $user_id;
        }
        else{
            $refer_code = MAIN_REFER . $user_id;
        }
    }
    $sql_query = "UPDATE users SET refer_code='$refer_code' WHERE id =  $user_id";
    $db->sql($sql_query);

    $sql = "SELECT * FROM users WHERE mobile = '$mobile'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Successfully Registered";
    $response['data'] = $res;
    print_r(json_encode($response));


}

?>