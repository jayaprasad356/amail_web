
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
$fn = new custom_functions;

if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "email is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = "password is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['Mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobile is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['address'])) {
    $response['success'] = false;
    $response['message'] = "address is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['Bank_Account_Number'])) {
    $response['success'] = false;
    $response['message'] = "Bank_Account_Number is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['IFSC_code'])) {
    $response['success'] = false;
    $response['message'] = "IFSC_code is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['Bank_name'])) {
    $response['success'] = false;
    $response['message'] = "Bank_name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['Branch'])) {
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

if (!isset($_FILES['Education_Certificate']) || empty($_FILES['Education_Certificate']['name'])) {
    $response['success'] = false;
    $response['message'] = "Please upload an Education_Certificate ";
    print_r(json_encode($response));
    return false;
}

$name = $db->escapeString($_POST['name']);
$email = $db->escapeString($_POST['email']);
$password = $db->escapeString($_POST['password']);
$Mobile = $db->escapeString($_POST['Mobile']);
$address = $db->escapeString($_POST['address']);
$Bank_Account_Number= $db->escapeString($_POST['Bank_Account_Number']);
$IFSC_code = $db->escapeString($_POST['IFSC_code']);
$Bank_name = $db->escapeString($_POST['Bank_name']);
$Branch = $db->escapeString($_POST['Branch']);

$aadhar_card = "";
if (isset($_FILES['aadhar_card']) && $_FILES['aadhar_card']['error'] == UPLOAD_ERR_OK) {
$uploadDir = '/upload/aadhar_card';
   if (!is_dir($uploadDir)) {
   mkdir($uploadDir, 0777, true);
}
$fileName = $_FILES['aadhar_card']['name'];
$aadhar_card = $uploadDir . '/' . $fileName;
$extension = pathinfo($aadhar_card, PATHINFO_EXTENSION);
if (strtolower($extension) !== 'pdf') {
   $response["success"] = false;
   $response["message"] = "Aadhar card file type must be pdf!";
   print_r(json_encode($response));
   return false;
}
   move_uploaded_file($_FILES['aadhar_card']['tmp_name'], $aadhar_card);
}

$resume = "";
if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
$uploadDir = '/upload/resume';
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
    move_uploaded_file($_FILES['resume']['tmp_name'], $resume);
}

if (isset($_FILES['photo']) && !empty($_FILES['photo']) && $_FILES['photo']['error'] == 0 && $_FILES['photo']['size'] > 0) {
    if (!is_dir('/upload/photo/')) {
        mkdir('/upload/photo/', 0777, true);
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
    $full_path = '/upload/photo/' . $photo_name;
    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $full_path)) {
        $response["success"] = false;
        $response["message"] = "Invalid directory to upload image!";
        print_r(json_encode($response));
        return false;
    }
}

$Education_Certificate = "";
if (isset($_FILES['Education_Certificate']) && $_FILES['Education_Certificate']['error'] == UPLOAD_ERR_OK) {
$uploadDir = '/upload/Education_Certificate';
    if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
$fileName = $_FILES['Education_Certificate']['name'];
$Education_Certificate = $uploadDir . '/' . $fileName;
$extension = pathinfo($Education_Certificate, PATHINFO_EXTENSION);
if (strtolower($extension) !== 'pdf') {
    $response["success"] = false;
    $response["message"] = "Education certificate file type must be pdf!";
    print_r(json_encode($response));
    return false;
}
    move_uploaded_file($_FILES['Education_Certificate']['tmp_name'], $Education_Certificate);
}
    
$sql = "SELECT * FROM staffs WHERE email = '$email'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $response['success'] = false;
    $response['message'] = "You are already registered";
    print_r(json_encode($response));
} else {
    $sql = "INSERT INTO staffs (name, email, password, Mobile, address,Bank_Account_Number, ifsc_code, bank_name, branch, aadhar_card, resume, photo, education_certificate) VALUES ('$name', '$email', '$password', '$Mobile', '$address', '$Bank_Account_Number', '$IFSC_code', '$Bank_name', '$Branch', '$aadhar_card', '$resume', '$photo', '$Education_Certificate')";
    $db->sql($sql);
    $sql = "SELECT * FROM staffs WHERE email = '$email'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Staff added successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
}

  

