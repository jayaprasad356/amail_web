<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();

$date = $db->escapeString(($_POST['date']));

	//$currentdate = date('Y-m-d');
    //$join = "LEFT JOIN `branches` b ON u.branch_id = b.id LEFT JOIN `staffs` e ON u.lead_id = e.id LEFT JOIN `staffs` s ON u.support_id = s.id WHERE u.id IS NOT NULL";
	$sql_query = "SELECT users.id,users.name,users.mobile,users.level,users.worked_days,users.duration,staffs.name AS staff_name,users.today_codes,users.earn,users.joined_date,users.l_referral_count 
    FROM users
    JOIN transactions ON users.id = transactions.user_id JOIN staffs ON staffs.id = users.support_id WHERE DATE(transactions.datetime) = '$date' AND transactions.type = 'generate' GROUP BY users.id ORDER BY today_codes DESC";
	$db->sql($sql_query);
	$developer_records = $db->getResult();
	
	$filename = "Activeusers-data".$date . ".xls";			
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
