<?php
session_start();
// include_once('../api-firebase/send-email.php');
include('../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");

include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/functions.php');
$function = new functions;

if (isset($_POST['delete_variant'])) {
    $v_id = $db->escapeString(($_POST['id']));
    $sql = "DELETE FROM product_variant WHERE id = $v_id";
    $db->sql($sql);
    $result = $db->getResult();
    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['refer_code_change'])) {
    $user_id = $db->escapeString($fn->xss_clean($_POST['user_id']));
    $sql = "SELECT * FROM users WHERE id=" . $user_id;
    $db->sql($sql);
    $res = $db->getResult();
    if (!empty($res)) {
        $refer_code = $res[0]['refer_code'];
        echo $refer_code;
    } else {
        echo "";
    }

}