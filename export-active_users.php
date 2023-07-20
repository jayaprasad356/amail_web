<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();

$date = $db->escapeString(($_POST['date']));

	//$currentdate = date('Y-m-d');
    //$join = "LEFT JOIN `branches` b ON u.branch_id = b.id LEFT JOIN `staffs` e ON u.lead_id = e.id LEFT JOIN `staffs` s ON u.support_id = s.id WHERE u.id IS NOT NULL";
	$sql_query = "SELECT users.level,users.worked_days,users.duration,users.id,users.task_type,users.name,staffs.name AS staff_name, SUM(transactions.codes) AS today_codes,SUM(transactions.amount) AS earn,users.joined_date,users.mobile,users.total_referrals,users.earn AS total_earn,users.l_referral_count 
    FROM users
    JOIN transactions ON users.id = transactions.user_id JOIN staffs ON staffs.id = users.support_id WHERE DATE(transactions.datetime) = '$date' AND transactions.type = 'generate'";
	$db->sql($sql_query);
	$developer_records = $db->getResult();
	
	$filename = "Allusers-data".date('Ymd') . ".xls";			
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");	
	$show_coloumn = false;
	if(!empty($developer_records)) {
	  foreach($developer_records as $record) {
		if(!$show_coloumn) {
		  // display field/column names in first row
		  echo implode("\t", array_keys($record)) . "\n";
		  $show_coloumn = true;
		}
		echo implode("\t", array_values($record)) . "\n";
	  }
	}
	exit;  
?>
