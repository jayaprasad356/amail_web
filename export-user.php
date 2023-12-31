<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();


	$currentdate = date('Y-m-d');
    $join = "LEFT JOIN `branches` b ON u.branch_id = b.id LEFT JOIN `staffs` e ON u.lead_id = e.id LEFT JOIN `staffs` s ON u.support_id = s.id WHERE u.id IS NOT NULL";
	$sql_query = "SELECT u.id AS id,u.*,u.name AS name,u.mobile AS mobile,u.worked_days,DATEDIFF( '$currentdate',u.joined_date) AS history,e.name AS support_name,s.name AS lead_name,b.name AS branch_name FROM `users` u $join";
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
