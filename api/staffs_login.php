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
    $response['message'] = "Mobile Number is empty";
    print_r(json_encode($response));
    return false;
}

if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "Password is empty";
    print_r(json_encode($response));
    return false;
}

$mobile = $db->escapeString($_POST['mobile']);
$password = $db->escapeString($_POST['password']);

$sql = "SELECT * FROM staffs WHERE mobile = '$mobile'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num == 1) {
       $row=$res[0];
        if($row['password']== $password){
            
            $response['success'] = true;
            $response['message'] = "Logged In Successfully";
            $response['data'] = $res;
            if(!empty($row['resume']) && !empty($row['aadhar_card']) && !empty($row['education_certificate']) && !empty($row['photo'])){
                $response['document_upload'] = 1;
            }
            else{
                $response['document_upload'] = 0;
            }
            print_r(json_encode($response));
        }
        else{
            $response['success'] = false;
            $response['message'] = "Invalid Password";
            print_r(json_encode($response));
        }
}
else {
    $response['success'] = false;
    $response['message'] = "Staff Not Found";
    print_r(json_encode($response));
}
?>