<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Test Scoresheets being ready.</title>
<style type="text/css">
		* {font-family: arial}
		th {text-align:left; border-bottom:2px solid #000;}
		td {vertical-align: top; border-bottom:1px solid #ccc;}
		.red {color: red; font-weight: bold}
		.confirmed td {color:#aaa;}
</style>
</head>

<body>
<?php
	include("../../../site/config.php");
	include("../config.php");
	mysql_select_db($database, $connection);


	include_once("../classes/user.php");
	include_once("../classes/checkAccess.php");

	include_once("../classes/scoresheet.php");
	include_once("classes/scoresheetTest.php");


?>
<h1>DownloadScoreSheets Tests</h1>

<h2>ALL ScoreSheets</h2>

<?php
$AllScoreSheets = array();

$sql = "SELECT id, brewName, brewStyle, brewCategory, brewJudgingNumber, brewBrewerID, brewPaid, brewReceived FROM brewing ORDER BY brewJudgingNumber";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
	while ($row = mysql_fetch_object($result)) {
		$TempScoreSheet = new ScoreSheetTest();
		$TempScoreSheet->BrewID = $row->id;
		$TempScoreSheet->BrewName = $row->brewName;
		$TempScoreSheet->BrewStyle = $row->brewStyle;
		$TempScoreSheet->UserID = $row->brewBrewerID;
		$TempScoreSheet->JudgingNumber = $row->brewJudgingNumber;
		$TempScoreSheet->BrewPaid = $row->brewPaid;
		$TempScoreSheet->brewReceived = $row->brewReceived;

		array_push($AllScoreSheets, $TempScoreSheet);
	}
?>

<table width="100%">
<tr>
		<th>Entry #</th>
		<th>Judging #</th>
		<th>Beer Name</th>
		<th>Style</th>
		<th>Paid</th>
		<th>Received</th>
		<th>Download</th>
		<th>Auto Tests</th>
		<th>Confirm</th>
</tr>
<?php
	$Total = 0;
	$MissingTotal = array();
	$NonRecievedTotal = array();

	$check = new CheckAccess();	

	foreach ($AllScoreSheets as $SingleSheet){

		//AutoTesting:
			//
			echo "<!--";
			//echo "<br>";
			global $TestMode;
			$TestMode = FALSE;
			if ($check->CheckIfUserHasAccessToDownload($SingleSheet)){
				$HasAccess = "TRUE";
			}else{
				$FileExists = "<span class=\"red\">FALSE</span>";
			}
			if($check->CheckToSeeIfFileExists($SingleSheet)){
				$FileExists = "TRUE";
			}else{
				$FileExists = "<span class=\"red\">FALSE</span>";
				array_push($MissingTotal, $SingleSheet->JudgingNumber);
			}
			echo "-->";

		// Confirming:
		$SingleSheet->CheckConfirm();

		if ($SingleSheet->Status == "1"){
			echo "<tr class='confirmed'>";
		}else{
			echo "<tr>";
		}

		// Received:
		if ($SingleSheet->brewReceived == 0){
			array_push($NonRecievedTotal, $SingleSheet->JudgingNumber);
		}

		echo"<td>" . $SingleSheet->BrewID . "</td>
			<td>" . $SingleSheet->JudgingNumber . "</td>
			<td>" . $SingleSheet->BrewName . "</td>
			<td>" . $SingleSheet->BrewStyle . "</td>
			<td>" . $SingleSheet->BrewPaid . "</td>
			<td>" . $SingleSheet->brewReceived . "</td>";

		if ($FileExists == "TRUE"){
			echo "<td><a href='../download.php?pdf=" . $SingleSheet->BrewID . "' target=\"_blank\">Test Download</a></td>";
		}else{
			echo "<td> </td>";
		}
			
		echo "<td><strong>user has access:</strong> " . $HasAccess . "
					  <br/><strong>file exists:</strong> " . $FileExists . "
					  </td>";

		if ($FileExists == "TRUE"){
		echo "<td>". $SingleSheet->ReturnConfirmation() .

		  		"<br><a href=\"confirm.php?scoresheetID=" . $SingleSheet->BrewID . "\" target=\"blank\">Confirm</a></td>";
		 }else{
		 	echo "<td> </td>";
		 }

		 $Total++;
		echo "</tr>";
	}
?>
</table>
<h2>Stats</h2>
<p><strong>Total:</strong> <?php echo $Total; ?></p>
<p><strong>Missing ScoreSheets:</strong> <?php echo count($MissingTotal); ?></p>
<p><strong>Not Recieved: </strong> <?php echo count($NonRecievedTotal); ?></p>
<p><strong>Missing minus Not Recieved: </strong><?php echo (count($MissingTotal) - count($NonRecievedTotal)); ?></p>
<h3>Missing List (excluding non-recieved):</h3>
<ul>
<?php
$RealMissing = array_diff($MissingTotal, $NonRecievedTotal);

foreach ($RealMissing as $ID){

	echo "<li>" . $ID . "</li>";

}
//var_dump($RealMissing);

?>
</ul>
</body>
</html>
