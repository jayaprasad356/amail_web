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
$fn->monitorApi('sync_uz');

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
$user_id = '44516';
$codes = 120;
if($codes != 120){
    $message = 'Generate 60 Codes Please';
    echo "<script>alert('$message');</script>";
  }
$data = array(
    "user_id" => $user_id,
    "codes" => $codes,
);
$apiUrl = "https://appadmin.abcdapp.in/api/wallet.php";


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
    if ($responseData !== null && $codes == 60 && isset($responseData["today_codes"])) {
        $message = $responseData["message"];
        echo "<script>alert('$message');</script>";

    } else {
        // echo "Failed to fetch transaction details.";
        // if ($responseData !== null) {
        //     echo " Error message: " . $responseData["message"];
        // }
    }
}

curl_close($curl);


?>