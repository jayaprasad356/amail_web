<?php


include_once('includes/crud.php');
$db = new Database();
$db->connect();
$data = array();
$sql = "SELECT id,name,email FROM users LIMIT 5";
$db->sql($sql);
$data = $db->getResult();
$url = 'http://localhost/abcd/api/test_add.php';
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('data' => $data)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

print_r($response);



?>
