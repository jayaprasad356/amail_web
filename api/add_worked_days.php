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
$date = date('Y-m-d');
$sql = "SELECT id,joined_date FROM users WHERE joined_date>='2023-02-06' AND status=1 AND worked_days < 30";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach($res as $row){
        $user_id = $row['id'];
        $joined_date = $row['joined_date'];
        $sql = "UPDATE users SET worked_days = DATEDIFF('$date', joined_date) - (
            SELECT count(*) AS leaves FROM `leaves` 
            WHERE ((date BETWEEN '$joined_date' AND '$date') AND user_id = $user_id) 
            OR (type = 'common_leave' AND (date BETWEEN '$joined_date' AND '$date'))
          )
          WHERE id = $user_id;
          ";
          $db->sql($sql);
    }

}


$response['success'] = true;
$response['message'] = "Worked Days Added";
print_r(json_encode($response));
?>
