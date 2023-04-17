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
$sql = "SELECT COUNT(DISTINCT CASE WHEN u.lead_id = $staff_id THEN u.lead_id END) as total_leads, 
               COUNT(DISTINCT CASE WHEN u.support_id = $staff_id THEN u.support_id END) as total_joinings, 
               u.joined_date as join_date 
        FROM users u 
        WHERE (u.support_id = $staff_id OR u.lead_id = $staff_id) 
        GROUP BY join_date";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
        $sql = "SELECT * FROM settings";
        $db->sql($sql);
        $result = $db->getResult();
        $lead_incentive=$result[0]['lead_incentive'];
        $support_incentive=$result[0]['support_incentive'];
        foreach($res as $row){
            $temp['total_leads'] = $row['total_leads'];
            $temp['total_joinings'] = $row['total_joinings'];
            $temp['incentives'] = (($row['total_leads']* $lead_incentive) + ($row['total_joinings'] * $support_incentive));
            $temp['date'] = $row['join_date'];
            $rows[] = $temp;
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
