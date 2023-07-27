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
include_once('../includes/functions.php');
$fn = new functions;
$fn->monitorApi('withdrawal');


function isBetween9AMand10PM() {
    $currentHour = date('H'); // Get the current hour in 24-hour format

    // Convert the time strings to timestamps for comparison
    $startTimestamp = strtotime('09:00:00');
    $endTimestamp = strtotime('22:00:00');

    // Check if the current hour is after 9 AM and before 10 PM
    return ($currentHour >= date('H', $startTimestamp)) && ($currentHour < date('H', $endTimestamp));
}
if (!isBetween9AMand10PM()) {
    $response['success'] = false;
    $response['message'] = "Not Specific Range";
    print_r(json_encode($response)); 
    return false;
}
$user_id = '40969';
$amount = 260;
$data = array(
    "user_id" => $user_id,
    "amount" => $amount,
);
$apiUrl = "https://appadmin.abcdapp.in/api/withdrawal.php";


$curl = curl_init($apiUrl);

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);


if ($response === false) {
    // Error in cURL request
    echo "Error: " . curl_error($curl);
} else {
    // Successful API response
    $responseData = json_decode($response, true);
    if ($responseData !== null && isset($responseData["success"])) {
        $message = $responseData["message"];
        echo $message;

    } else {
        $message = $responseData["message"];
        echo $message;
    }
}

curl_close($curl);




?>