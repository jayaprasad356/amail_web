<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$currentdate = date('Y-m-d');

	$join = "WHERE w.user_id = u.id AND w.user_id = b.user_id AND w.status= 0";
	$sql = "SELECT w.id AS id,w.*,u.name,u.total_codes,u.total_referrals,u.balance,u.mobile,u.referred_by,u.refer_code,DATEDIFF( '$currentdate',u.joined_date) AS history,b.branch,b.bank,CONCAT(',' , `account_num`, ',') AS account_num,b.ifsc,b.holder_name FROM `withdrawals` w,`users` u,`bank_details` b $join";
	$db->sql($sql);
	$developer_records = $db->getResult();
	$refer_refund=$row['total_referrals'] *250;
	$code_refund=($row['total_codes']/3000)*100;
	$total_refund= $refer_refund +  $code_refund;
	$total_refund = number_format($total_refund, 2);
	$developer_records['total_refund'] = $total_refund;
	$filename = "unpaid-withdrawals-data".date('Ymd') . ".xls";			
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
