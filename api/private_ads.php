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

if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);

$sql = "SELECT id,url FROM urls WHERE id NOT IN (SELECT url_id FROM users_url WHERE user_id = '$user_id') ORDER BY RAND() LIMIT 1";
$db->sql($sql);
$result = $db->getResult();
if(!empty($result)){
    $url_id=$result[0]['id'];
    $url=$result[0]['url'];
    $data = array(
        'user_id' => $user_id,
        'url_id' => $url_id
    );
    $db->insert('users_url', $data);
    $response['success'] = true;
    $response['message'] = "Ad URL Generated Successfully";
    $response['url'] = $url;
    $response['url_id'] = $url_id;
    $sql = "UPDATE `urls` SET views= views +1 WHERE id='$url_id'";
    $db->sql($sql);
}
else{
    $response['success'] = false;
    $response['message'] = "No new URLs available for the user";
}
print_r(json_encode($response));
?>
