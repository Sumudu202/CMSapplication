<?php
session_start();
$rowNo1 = $_GET['rowNo1'];
$spName = $_GET['spName'];

//Database connection
require_once 'bin/conDB.php';
$conn = conDb();

$sql = "SELECT * FROM birddata WHERE spName = '".mysqli_escape_string($conn, $spName)."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row["spSciName"]) {
	echo "&nbsp;&nbsp;&nbsp;<i>".$row["spSciName"]."</i> | " .$row["spAbv"]."";
} else {
	echo "&nbsp;&nbsp;&nbsp;".$row["spAbv"]."";
}

$totCount = 0;
$totNfeed = 0;
$ocfeed = 'Unknown';
$nsow = 0;
$ocsow = 'Unknown';
$nsoice = 0;
$ocsoice = 'Unknown';
while($row = mysqli_fetch_assoc($result)) {
	if (($row["COUNT"] == 99999) || $totCount == 99999){
		$totCount=99999;
	}
	else{
	$totCount=$totCount+$row["COUNT"];
	}
	if ($row["NFEED"] == 99999 || $totNfeed == 99999){
		$totNfeed=99999;
	}
	else{
	$totNfeed=$totNfeed+$row["NFEED"];
	}
	if ($row["OCFEED"] == 'Y'){
		$ocfeed = 'Yes';
	}
	
	$nsow=$nsow+$row["NSOW"];
	
	if ($row["OCSOW"] == 'Y'){
		$ocsow = 'Yes';
	}
	
	$nsoice=$nsoice+$row["NSOICE"];
	
	if ($row["OCSOICE"] == 'Y'){
		$ocsoice = 'Yes';
	}
	$i = $i+1;
}

//Display choice
if ($ocfeed == 'Unknown'){
	$disp_feed = 'Unknown';
}
else{
	$disp_feed = $totNfeed;
}

if ($ocsow == 'Unknown'){
	$disp_ow = 'Unknown';
}
else{
	$disp_ow = $nsow;
}

if ($ocsoice == 'Unknown'){
	$disp_oice = 'Unknown';
}
else{
	$disp_oice = $nsoice;
}


echo "<table border='0'>";
	echo "<tr>";
	echo '<td style="font-weight:bold;">Observation Summary</td>';
	echo "</tr>";
	echo "<tr>";
	echo '<td></td>';
	echo '<td>Abundance:</td>';
	echo "<td width=15%>" . $totCount."</td>";
	echo '<td>Feeding:</td>';
	echo "<td width=15%>" . $disp_feed."</td>";
	echo "</tr>";	
		
	echo "<tr>";
	echo '<td></td>';
	echo '<td>Sitting on water:</td>';
	echo "<td width=15%>" . $disp_ow."</td>";
	echo '<td>Sitting on ice:</td>';
	echo "<td width=15%>" . $disp_oice."</td>";
	echo "</tr>";
echo "</table>";
//echo "<br>Observation Summary:";
//echo "Total Count: $totCount";
/* if (mysqli_num_rows($result) > 0) {
	$i = 1;
	$total = mysqli_num_rows($result);
	echo "<table border='0' id='table8'>";
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		echo "<tr>";
		echo '<td id="subSpecies'.$rowNo1._.$i.'"><a name="name'.$rowNo1._.$i.' href="#name'.$rowNo1._.$i.'" onclick="loadproduct2(\''.mysqli_escape_string($conn, $row["subSpName"]).'\', \''.$rowNo1._.$i.'\', \''.$total.'\')"><button class="collapsibleSub">  &nbsp;&nbsp;&nbsp;&nbsp;  ' .ucfirst($row["subSpName"]). '</button></a></td>';
		echo "</tr>";
		echo "<tr><td id='bird_details".$rowNo1._.$i."'></td></tr>";
		$i = $i+1;
    }
} else {
    echo "No data to show";
}

mysqli_close($conn);
echo "</table>";        */
?>      

<script>
function loadproduct2(subSpeciesName,i,total){
	var x = document.getElementById("subSpecies"+i).innerHTML;
	var y = document.getElementById("bird_details"+i).innerHTML;
	
	$.post("birdDetails.php?subSpeciesName="+subSpeciesName+"&rowNo="+i, 
        function(data){
			if (y==""){
			$("#bird_details"+i).html(data);
			re_x = x.replace("+", "*");	// replace + with -
			$("#subSpecies"+i).html(re_x);
			}
			else{
				$("#bird_details"+i).html("");
				re_x = x.replace("*", "+");	// replace - with +
				$("#subSpecies"+i).html(re_x);
			}
    }); 
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