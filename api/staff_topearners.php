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
date_default_timezone_set('Asia/Kolkata');

if (empty($_POST['staff_id'])) {
    $response['success'] = false;
    $response['message'] = "Staff Id is Empty";
    print_r(json_encode($response));
    return false;
}

$staff_id = $db->escapeString($_POST['staff_id']);
$sql = "SELECT * FROM staffs WHERE id= $staff_id";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $branch_id = $res[0]['branch_id'];
    $sql = "SELECT * FROM staffs WHERE branch_id= $branch_id ORDER BY (SELECT SUM(amount) FROM staff_transactions WHERE staff_id=staffs.id AND type != 'salary') DESC";
    $db->sql($sql);
    $result = $db->getResult();
    foreach ($result as $staff) {
        $staff_id = $staff['id'];
        $sql = "SELECT SUM(amount) As total_incentive FROM staff_transactions WHERE staff_id= $staff_id AND type != 'salary'";
        $db->sql($sql);
        $staff_incentives = $db->getResult();
        $temp['id'] = $staff['id'];
        $temp['first_name'] = $staff['first_name'];
        $temp['mobile'] = $staff['mobile'];
        $temp['role'] = $staff['role'];
        $temp['incentives'] = $staff_incentives[0]['total_incentive'];
        $rows[]=$temp;
    }

    $response['success'] = true;
    $response['message'] = "Incentive Details Fetched Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

} else {
    $response['success'] = false;
    $response['message'] = "Staff Not Found";
    print_r(json_encode($response));
}

?>