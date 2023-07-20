<?php
//session_save_path("../temp");
	session_start();	
	session_destroy();
	header("location: index.php");
