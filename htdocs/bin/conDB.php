<?php
	function conDb(){
		
		$db_host        = '104.37.86.25';
		$db_user        = 'xveosnmr';
		$db_pass        = 'O@cj[XB0z6Nr83';
		$db_database    = 'xveosnmr'; 
		$db_port        = '3306';
		$conn = mysqli_connect($db_host,$db_user,$db_pass,$db_database,$db_port);
		
		return $conn;
	}
?>