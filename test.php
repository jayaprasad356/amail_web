<?php
 session_start();

// set time for session timeout
$currentTime = time();
$expired = 3600; // 1 hour in seconds

$_SESSION['timeout'] = $currentTime + $expired;
// if current time is more than session timeout, go back to login page
if ($currentTime > $_SESSION['timeout']) {
    //session_destroy();
    echo 'expireds';
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;
echo 'timeout '.$_SESSION['timeout'];
echo 'currentTime '.$currentTime;
?>