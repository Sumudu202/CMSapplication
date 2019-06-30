<?php
	
	require_once 'conDB.php';
	$conn = conDb();

	
	if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email'])){
		
			$name = $_POST['name'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$website = $_POST['website'];
			$gender = $_POST['gender'];
			 
			if(isset($_POST['address'])){
				$address = $_POST['address'];
			}
			else {
				$address = "";
			}
		$sql="UPDATE user SET name='$name', address='$address', phone='$phone', website='$website', gender='$gender' WHERE email='".$email."'";
		
		if ($conn->query($sql) === TRUE) {
			echo '<script type="text/javascript"> alert("User was successfully updated"); </script>';
			echo "<a href=../search.php>Back to Edit Records</a>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	mysqli_close($conn);
?>