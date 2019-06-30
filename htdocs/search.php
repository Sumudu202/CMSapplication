<!DOCTYPE html>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<script type="text/javascript">
	function validateForm()
	{
		var x=document.forms["editUser"]["name"].value;
		if(x==null || x=="")
		{
			alert("Please enter your name!");
			document.forms["editUser"]["name"].focus();
			return false;
		}
		
		var x=document.forms["editUser"]["phone"].value;
		var y=parseFloat(x);
		if(isNaN(y) || x.length<10 || x.length>12)
			{
				alert("Invalid phone number!");
				document.forms["editUser"]["phone"].focus();
				return false;
			}
	}
</script>

<h2>Edit Records</h2>

<table border='0' width="100%">
	<tr>
		<td align="left">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET" >
				<input type="text" name="search" placeholder="Search by Name..." />
				<input type="submit" name="submit" value="Search" id="post_search" />
			</form>
		</td>
	</tr>
</table>


<?php
require_once 'bin/conDB.php';
$conn = conDb();
	
//Search by name
if (isset($_REQUEST['submit'])){
	$searchq = $_GET['search'];
	
	//to avoid searcing NULL
	if ($searchq != ""){
		$sqlSpecies = "SELECT * FROM user WHERE name LIKE '%$searchq%'";
		$query = mysqli_query($conn, $sqlSpecies);
	
		$message = "Search results for: ".$searchq;
		
		if (mysqli_num_rows($query) == 0) {
			echo "<table border='0'>";
			echo "<tr><td>Sorry, your search ".$searchq." did not find any records.</td></tr>";
			echo "</table>";
		} 
		else {
			while($row=mysqli_fetch_assoc($query)) {
				?>
				<p><span class="error">* required field</span></p>
				
				<form action="bin/editUser.php" name="editUser" onsubmit="return validateForm()" enctype="multipart/form-data" method="post" >        	

				<table width="70%">
					<tr></tr>
					<tr></tr>
					<tr>
						<td>Name</td>
						<td><input type="text" name="name" value="<?php echo $row["name"]; ?>"/><span class="error">*</span></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><textarea rows="5" name="address"><?php echo $row["address"]; ?></textarea></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td><input type="text" name="phone" value="<?php echo $row["phone"]; ?>"/><span class="error">*</span></td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><input type="text" readonly="readonly" name="email" value="<?php echo $row["email"]; ?>"/><span class="error">* read only</span></td>
					</tr>
					<tr>
						<td>Website:</td>
						<td><input type="text" name="website" value="<?php echo $row["website"]; ?>"/></td>
					</tr>
					<tr>
						<td>Gender:</td>
						<td><input type="text" name="gender" value="<?php echo $row["gender"]; ?>"/></td>
					</tr>
					<td></td>
					<td><button type="submit">Update</button></td>
					</tr>
				</table>
		   
				</form>
				<?php
			}
		}
	}
}
mysqli_close($conn);
?>
</body>
</html>