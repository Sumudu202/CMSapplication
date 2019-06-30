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
		var x=document.forms["registration"]["name"].value;
		if(x==null || x=="")
		{
			alert("Please enter your name!");
			document.forms["registration"]["name"].focus();
			return false;
		}
		var x=document.forms["registration"]["phone"].value;
		var y=parseFloat(x);
		if(isNaN(y) || x.length<10 || x.length>12)
			{
				alert("Invalid phone number!");
				document.forms["registration"]["phone"].focus();
				return false;
			}
			var x=document.forms["registration"]["email"].value;
			var atpos=x.indexOf("@");
			var dotpos=x.lastIndexOf(".");
			if(atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
			{
				alert("Please enter a valid email!");
				document.forms["registration"]["email"].focus();
				return false;
			}
	}
</script>

<h2>User Registration</h2>
<p><span class="error">* required field</span></p>

<form action="bin/register.php" name="registration" onsubmit="return validateForm()" method="post" >
	<table width="70%">
        <tr>
        	<td>Name:</td>
            <td><input type="text" name="name"/><span class="error">*</span></td>
        </tr>
		<tr>
        	<td>Address:</td>
            <td><textarea name="address" rows="5" cols="40"></textarea></td>
        </tr>
		<tr>
            <td>Phone</td>
            <td><input type="text" name="phone" /><span class="error">*</span></td>
        </tr>
		<tr>
        	<td>E-mail:</td>
            <td><input type="text" name="email"/><span class="error">*</span></td>
        </tr>
		<tr>
        	<td>Website:</td>
            <td><input type="text" name="website"/></td>
        </tr>
		<tr>
        	<td>Gender:</td>
            <td><input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
			<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
			<input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other
			</td>
        </tr>
		<tr>
			<td><input type="submit" name="submit" value="Submit"></td>
		</tr>
	</table>
</form>

</body>
</html> 