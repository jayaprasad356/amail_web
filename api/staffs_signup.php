
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
include_once('../includes/custom-functions.php');
include_once('../includes/functions.php');
$fn = new functions;
$fn->monitorApi('staff_signup');


if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "Password is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobile Number is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['address'])) {
    $response['success'] = false;
    $response['message'] = "Address is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['bank_account_number'])) {
    $response['success'] = false;
    $response['message'] = "Bank Account Number is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['ifsc_code'])) {
    $response['success'] = false;
    $response['message'] = "IFSC Code is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['bank_name'])) {
    $response['success'] = false;
    $response['message'] = "Bank Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['branch'])) {
    $response['success'] = false;
    $response['message'] = "Branch is Empty";
    print_r(json_encode($response));
    return false;
}

if (!isset($_FILES['aadhar_card']) || empty($_FILES['aadhar_card']['name'])) {
    $response['success'] = false;
    $response['message'] = "Please upload an Aadhar Card Document";
    print_r(json_encode($response));
    return false;
}

if (!isset($_FILES['resume']) || empty($_FILES['resume']['name'])) {
    $response['success'] = false;
    $response['message'] = "Please upload an resume Document";
    print_r(json_encode($response));
    return false;
}

if (!isset($_FILES['photo']) || empty($_FILES['photo']['name'])) {
    $response['success'] = false;
    $response['message'] = "Please upload an photo";
    print_r(json_encode($response));
    return false;
}

if (!isset($_FILES['education_certificate']) || empty($_FILES['education_certificate']['name'])) {
    $response['success'] = false;
    $response['message'] = "Please upload an education_certificate ";
    print_r(json_encode($response));
    return false;
}

$name = $db->escapeString($_POST['name']);
$email = $db->escapeString($_POST['email']);
$password = $db->escapeString($_POST['password']);
$mobile = $db->escapeString($_POST['mobile']);
$address = $db->escapeString($_POST['address']);
$bank_account_number= $db->escapeString($_POST['bank_account_number']);
$ifsc_code = $db->escapeString($_POST['ifsc_code']);
$bank_name = $db->escapeString($_POST['bank_name']);
$branch = $db->escapeString($_POST['branch']);


if (isset($_FILES['aadhar_card']) && !empty($_FILES['aadhar_card']) && $_FILES['aadhar_card']['error'] == 0 && $_FILES['aadhar_card']['size'] > 0) {
    $uploadDir = '../upload/aadhar_card';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = $_FILES['aadhar_card']['name'];
    $aadhar_card = $uploadDir . '/' . $fileName;
    $extension = pathinfo($aadhar_card, PATHINFO_EXTENSION);
    if (strtolower($extension) !== 'pdf') {
        $response["success"] = false;
        $response["message"] = "Aadhar Card file type must be pdf!";
        print_r(json_encode($response));
        return false;
    }
    $upload_image = 'upload/aadhar_card/' . $fileName;
    move_uploaded_file($_FILES['aadhar_card']['tmp_name'], $aadhar_card);
}

if (isset($_FILES['resume']) && !empty($_FILES['resume']) && $_FILES['resume']['error'] == 0 && $_FILES['resume']['size'] > 0) {
    $uploadDir = '../upload/resume';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = $_FILES['resume']['name'];
    $resume = $uploadDir . '/' . $fileName;
    $extension = pathinfo($resume, PATHINFO_EXTENSION);
    if (strtolower($extension) !== 'pdf') {
        $response["success"] = false;
        $response["message"] = "Resume file type must be pdf!";
        print_r(json_encode($response));
        return false;
    }
    $upload_image1 = 'upload/resume/' . $fileName;
    move_uploaded_file($_FILES['resume']['tmp_name'], $resume);
}

if (isset($_FILES['photo']) && !empty($_FILES['photo']) && $_FILES['photo']['error'] == 0 && $_FILES['photo']['size'] > 0) {
    if (!is_dir('../upload/photo/')) {
        mkdir('..//upload/photo/', 0777, true);
    }
    $photo = $db->escapeString($fn->xss_clean($_FILES['photo']['name']));
    $extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
    $result = $fn->validate_image($_FILES["photo"]);
    if (!$result) {
        $response["success"] = false;
        $response["message"] = "Image type must be jpg, jpeg, gif, or png!";
        print_r(json_encode($response));
        return false;
    }
    $photo_name = microtime(true) . '.' . strtolower($extension);
    $full_path = '../upload/photo/' . $photo_name;
    $upload_image2 = 'upload/photo/' . $photo_name;
    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $full_path)) {
        $response["success"] = false;
        $response["message"] = "Invalid directory to upload image!";
        print_r(json_encode($response));
        return false;
    }
}

if (isset($_FILES['education_certificate']) && !empty($_FILES['education_certificate']) && $_FILES['education_certificate']['error'] == 0 && $_FILES['education_certificate']['size'] > 0) 
{
        $uploadDir = '../upload/education_certificate';
        if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = $_FILES['education_certificate']['name'];
    $education_certificate = $uploadDir . '/' . $fileName;
    $extension = pathinfo($education_certificate, PATHINFO_EXTENSION);
    if (strtolower($extension) !== 'pdf') {
        $response["success"] = false;
        $response["message"] = "Education certificate file type must be pdf!";
        print_r(json_encode($response));
        return false;
    }
    $upload_image3 = 'upload/education_certificate/' . $fileName;
    move_uploaded_file($_FILES['education_certificate']['tmp_name'], $education_certificate);
}
    
$sql = "SELECT * FROM staffs WHERE email = '$email'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $response['success'] = false;
    $response['message'] = "You are already registered";
    print_r(json_encode($response));
}
else {
    $sql = "INSERT INTO staffs (name, email, password, mobile, address,bank_account_number, ifsc_code, bank_name, branch, aadhar_card, resume, photo, education_certificate) VALUES ('$name', '$email', '$password', '$mobile', '$address', '$bank_account_number', '$ifsc_code', '$bank_name', '$branch', '$upload_image', '$upload_image1', '$upload_image2', '$upload_image3')";
    $db->sql($sql);
    $sql = "SELECT * FROM staffs WHERE email = '$email'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Staff added successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}

  

