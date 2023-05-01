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
$sql = "SELECT id,refer_code FROM `users` WHERE LEFT(refer_code, 3) != 'YMS' ";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $total = 0 ;
    foreach ($res as $row) {
        
        $ID = $row['id'];
        $refer_code = $row['refer_code'];
        $refer_code = substr($refer_code, 0, 3);
        $sql = "SELECT id,short_code FROM `branches` WHERE short_code = '$refer_code' ";
        $db->sql($sql);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if ($num == 0) {
            $total += 1;
            $short_code = 'YMS';
            $short_code = $short_code.$ID;
            $sql_query = "UPDATE users SET refer_code = '$short_code' WHERE id =  $ID";
            $db->sql($sql_query);

        }
 
    }
    $response['success'] = true;
    $response['message'] = "Refer Code Updated Successfully";
    $response['total'] = $total;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Results Found";
    print_r(json_encode($response));

}




?>