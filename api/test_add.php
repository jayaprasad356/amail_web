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

if (empty($_POST['data'])) {
    $response['success'] = false;
    $response['message'] = "Data is Empty";
    print_r(json_encode($response));
    return false;
}
$datetime = date('Y-m-d H:i:s');
foreach ($_POST['data'] as $data) {
    if (empty($data['name'])) {
        $response['success'] = false;
        $response['message'] = "Name is Empty";
        print_r(json_encode($response));
        return false;
    }
    if (empty($data['email'])) {
        $response['success'] = false;
        $response['message'] = "Email is Empty";
        print_r(json_encode($response));
        return false;
    }
    $name = $db->escapeString($data['name']);
    $email = $db->escapeString($data['email']);
    $sql = "INSERT INTO `test_users` (name,email,datetime) VALUES ('$name','$email','$datetime')";
    $db->sql($sql);
}

$response['success'] = true;
$response['message'] = "Data Inserted Successfully";
print_r(json_encode($response));
?>