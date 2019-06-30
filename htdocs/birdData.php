<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
table {
margin: 5px 50px 5px 10px;
}

#table1{
	margin: 5px 50px 5px 10px;
}

#table2{
	margin: 5px 50px 5px 10px;
}

th {
font-family: Arial, Helvetica, sans-serif;
font-size: .7em;
background: #666;
color: #FFF;
padding: 2px 6px;
border-collapse: separate;
border: 1px solid #000;
}

td {
font-family: Arial, Helvetica, sans-serif;
font-size: 1em;
}

/* unvisited link */
a:link {
    color: #ea9c4c;
}

/* visited link */
a:visited {
    color: #db6e00;
}

/* mouse over link */
a:hover {
    color: #db6e00;
}

/* selected link */
a:active {
    color: #db6e00;
}

/* remove underline */
a {
text-decoration: none;
}

.heading span {
  color: #8d8d8d;
}

/* Species Style the button that is used to open and close the collapsible content */
.collapsible {
  background-color: #777;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 920px;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #555;
}

.collapsible:after {
  //content: '\002B';
  color: white;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  //content: "\2212";
}

.content {
  padding: 0 18px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  background-color: #f1f1f1;
}

/* SubSpecies Style the button that is used to open and close the collapsible content */
.collapsibleSub {
  background-color: #a1a1a1;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 920px;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active2, .collapsibleSub:hover {
  background-color: #ea9c4c;
}

.collapsibleSub:after {
  //content: '\002B';
  color: white;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active2:after {
  //content: "\2212";
}

.content {
  padding: 0 18px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  background-color: #f1f1f1;
}

</style>
</head>
<body>

<?php
require_once 'bin/conDB.php';
$conn = conDb();


?>

<table border='0' width="100%">
	<tr>
		<td>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		</td>
		<td align="right">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET" >
				<input type="text" name="search" placeholder="Search for species..." />
				<input type="submit" name="submit" value="Search" id="post_search" />
			</form>
		</td>
	</tr>
</table>

<?php

//Search **********
//Search by species or subSpName
if (isset($_REQUEST['submit'])){
	$searchq = $_GET['search'];
	
	//to avoid searcing NULL
	if ($searchq != ""){
		$sqlSpecies = "SELECT DISTINCT spName FROM birddata WHERE spName LIKE '%$searchq%' ORDER BY spName ASC";
		$query = mysqli_query($conn, $sqlSpecies);
	
		$message = "Search results for: ".$searchq;
		
		if (mysqli_num_rows($query) == 0) {
			echo "<table border='0' id='table2' bgcolor='#f2eee5' width='100%'>";
			echo "<tr><td>Sorry, your search ".$searchq." did not find any records. Please try with different bird name.</td></tr>";
			echo "</table>";
		} else{
			echo "<table border='0' id='table2' bgcolor='#f2eee5' width='100%'>";
			echo "<tr><td>".$message."</td></tr>";
			while($row = mysqli_fetch_assoc($query)) {
				// Row for species
				echo "<tr>";
				echo '<td id="speciesData'.$i.'"><a name="name'.$i.' href="#name'.$i.'" onclick="loadsubspecies(\''.$row["spName"].'\', \''.$i.'\')"><button class="collapsible"> ' .ucfirst($row["spName"]). '</button></a></td>';
				echo "</tr>";
				
				//Row for description
				echo "<tr>";
				echo '<td id="desc'.$i.'"></td>';
				echo "</tr>";
				$i = $i+1;
			}
		} 
		echo "</table>";
	}
}

//Filter the list of bird names
$sql = "SELECT DISTINCT spName FROM birddata ORDER BY spName ASC";
$result = mysqli_query($conn, $sql);

// Insert each species into a table
if (mysqli_num_rows($result) > 0) {
	$i=1;
	echo "<table border='0' id='table1' width='100%'>";
	echo "<tr><td>All species</td></tr>";
    while($row = mysqli_fetch_assoc($result)) {
		// Row for species
		echo "<tr>";
		echo '<td id="speciesData'.$i.'"><a name="name'.$i.' href="#name'.$i.'" onclick="loadsubspecies(\''.$row["spName"].'\', \''.$i.'\')"><button class="collapsible"> ' .ucfirst($row["spName"]). '</button></a></td>';
		echo "</tr>";
		
		//Row for description
		echo "<tr>";
		echo '<td id="desc'.$i.'"></td>';
		echo "</tr>";
		
		$i = $i+1;
    }
} else {
    echo "0 results";
}

echo "</table>";
mysqli_close($conn);
?>

<script>

function loadsubspecies(spName,i){
	var x = document.getElementById("desc"+i).innerHTML;
	var y = document.getElementById("speciesData"+i).innerHTML;
	
	$.post("desc.php?spName="+spName+"&rowNo1="+i,
    function(data){
			if (x==""){
				$("#desc"+i).html(data);
				re_y = y.replace("+", "*");	// replace + with -
				$("#speciesData"+i).html(re_y);
			}
			else{
				$("#desc"+i).html("");
				re_y = y.replace("*", "+");	// replace - with +
				$("#speciesData"+i).html(re_y);
			}
    });
}


function myFunction() {
  var x = document.getElementById("table1");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

<script>
var coll = document.getElementsByClassName("collapsible");
var j;

for (j = 0; j < coll.length; j++) {
  coll[j].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>

</body>
</html>