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

if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobile is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "Password is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['device_id'])) {
    $response['success'] = false;
    $response['message'] = "Device Id is Empty";
    print_r(json_encode($response));
    return false;
}
$mobile = $db->escapeString($_POST['mobile']);
$password = $db->escapeString($_POST['password']);
$device_id = $db->escapeString($_POST['device_id']);
$sql = "SELECT * FROM users WHERE mobile ='$mobile' AND password ='$password'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1){
    $sql = "SELECT * FROM users WHERE device_id ='$device_id'";
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num == 1){
        $response['success'] = true;
        $response['message'] = "Logged In Successfully";
        $response['data'] = $res;
        print_r(json_encode($response));
    }
    else{
        $response['success'] = false;
        $response['message'] = "Please Login With your Device";
        $response['data'] = $res;
        print_r(json_encode($response));
    
    }

}
else{
    $response['success'] = false;
    $response['message'] = "User Not Found";
    $response['data'] = $res;
    print_r(json_encode($response));

}
?>