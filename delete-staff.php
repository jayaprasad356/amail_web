<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();
	
	if (isset($_GET['id'])) {
		$ID = $db->escapeString($_GET['id']);
	} else {
		// $ID = "";
		return false;
		exit(0);
	}
	$data = array();
	$sql_query = "SELECT *  FROM staffs WHERE id =" . $ID;
	$db->sql($sql_query);
	$res = $db->getResult();
	$target_path = $res[0]['photo'];
	$target_path1 = $res[0]['resume'];
	$target_path2 = $res[0]['education_certificate'];
	$target_path3 = $res[0]['aadhar_card'];
	if(!empty($target_path) && !empty($target_path1) && !empty($target_path2) && !empty($target_path3)){
		if(unlink($target_path) && unlink($target_path1) && unlink($target_path2) && unlink($target_path3)){	
			$sql_query = "DELETE  FROM staffs WHERE id =" . $ID;
			$db->sql($sql_query);
			$res = $db->getResult();
			header("location:staffs.php");
	    }
	}
	else{
		    $sql_query = "DELETE  FROM staffs WHERE id =" . $ID;
			$db->sql($sql_query);
			$res = $db->getResult();
			header("location:staffs.php");
	}
	
?>
