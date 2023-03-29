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
            $temp['id'] = $row['id'];
            $temp['name'] = $row['name'];
            $temp['email'] = $row['email'];
            $temp['mobile'] = $row['mobile'];
            $temp['password'] = $row['password'];
            $temp['address'] = $row['address'];
            $temp['bank_account_number'] = $row['bank_account_number'];
            $temp['ifsc_code'] = $row['ifsc_code'];
            $temp['bank_name'] = $row['bank_name'];
            $temp['branch'] = $row['branch'];
            $temp['aadhar_card'] = DOMAIN_URL . $row['aadhar_card'];
            $temp['photo'] = DOMAIN_URL . $row['photo'];
            $temp['resume'] = DOMAIN_URL . $row['resume'];
            $temp['education_certificate'] = DOMAIN_URL . $row['education_certificate'];
            $rows[] = $temp;

            $response['success'] = true;
            $response['message'] = "Logged In Successfully";
            $response['data'] = $rows;
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