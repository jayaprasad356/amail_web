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

if($_POST['rate_type'] == 'check'){
    if (empty($_POST['user_id'])) {
        $response['success'] = false;
        $response['message'] = "User Id is Empty";
        print_r(json_encode($response));
        return false;
    }
    if (empty($_POST['ticket_id'])) {
        $response['success'] = false;
        $response['message'] = "Ticket Id is Empty";
        print_r(json_encode($response));
        return false;
    }
    $user_id = $db->escapeString($_POST['user_id']);
    $ticket_id = $db->escapeString($_POST['ticket_id']);
    $sql_query = "SELECT * FROM ratings WHERE user_id =  $user_id AND ticket_id = '$ticket_id'";
    $db->sql($sql_query);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num >= 1){
        $response['success'] = false;
        $response['message'] = "Rated";
        print_r(json_encode($response));

    }else{
        $response['success'] = true;
        $response['message'] = "Not Rated";
        print_r(json_encode($response));
    }

}
if($_POST['rate_type'] == 'add'){
    if (empty($_POST['user_id'])) {
        $response['success'] = false;
        $response['message'] = "User Id is Empty";
        print_r(json_encode($response));
        return false;
    }
    if (empty($_POST['ratings'])) {
        $response['success'] = false;
        $response['message'] = "ratings is Empty";
        print_r(json_encode($response));
        return false;
    }
    if (empty($_POST['ticket_id'])) {
        $response['success'] = false;
        $response['message'] = "Ticket Id is Empty";
        print_r(json_encode($response));
        return false;
    }
    $user_id = $db->escapeString($_POST['user_id']);
    $description = $db->escapeString($_POST['description']);
    $ratings = $db->escapeString($_POST['ratings']);
    $ticket_id = $db->escapeString($_POST['ticket_id']);
    
    
    
    $sql = "INSERT INTO ratings (`user_id`,`description`,`ratings`,`ticket_id`) VALUES ('$user_id','$description','$ratings','$ticket_id')";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Ratings Submitted Successfully";
    print_r(json_encode($response));
}





?>