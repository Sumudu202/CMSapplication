<?php 
	session_start();
	
	require_once 'conDB.php';
	$conn = conDb();
	
	if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$gender = $_POST['gender'];
		
		if(!isset($_POST['address'])){
			$address = "";				 
		}
		else {
			$address = $_POST['address'];	
		}
		if(!isset($_POST['website'])){
			$website = "";				 
		}
		else {
			$website = $_POST['website'];	 
		}
	
		$sql = "INSERT INTO user (name, address, phone, email, website, gender) values('$name', '$address', '$phone', '$email', '$website', '$gender' )";
		if ($conn->query($sql) === TRUE) {
			echo '<script type="text/javascript"> alert("User was successfully registered"); </script>';
			echo "<a href=../formValidation.php>Back to User Registration</a>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		
	} 
?>