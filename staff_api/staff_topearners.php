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
//$sql = "SELECT s.name AS name,b.name AS branch_name,s.incentives FROM staffs s,branches b WHERE s.branch_id = b.id AND s.incentives != 0 AND s.staff_role_id != 1 AND s.staff_role_id != 2 ORDER BY s.incentives DESC LIMIT 5";
$sql = "SELECT s.name AS name,b.name AS branch_name,SUM(i.amount) AS incentives FROM incentives i JOIN staffs s ON i.staff_id = s.id
JOIN branches b ON s.branch_id = b.id WHERE s.branch_id = b.id AND s.incentives != 0 AND s.staff_role_id != 1 AND s.staff_role_id != 2 AND YEAR(i.datetime) = YEAR('2023-05-20') AND WEEK(i.datetime) = WEEK('2023-05-20') ORDER BY SUM(i.amount) DESC LIMIT 10";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {

    $response['success'] = true;
    $response['message'] = "Incentive Details Fetched Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));

} else {
    $response['success'] = false;
    $response['message'] = "Staff Not Found";
    print_r(json_encode($response));
}

?>