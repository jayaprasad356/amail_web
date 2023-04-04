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

if (empty($_POST['staff_id'])) {
    $response['success'] = false;
    $response['message'] = "staffs Id is Empty";
    print_r(json_encode($response));
    return false;
}

$staff_id = $db->escapeString($_POST['staff_id']);

$sql = "SELECT * FROM staffs WHERE id=" . $staff_id;
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach($res as $row){

        $temp['id'] = $row['id'];
        $temp['first_name'] = $row['first_name'];
        $temp['last_name'] = $row['last_name'];
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
        $temp['salary_date'] = $row['salary_date'];
        $rows[] = $temp;

    }
    $response['success'] = true;
    $response['message'] = "staff details Retieved Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));
}
else{
    
    $response['success'] = false;
    $response['message'] ="Staff Not Found";
    print_r(json_encode($response));
}

?>