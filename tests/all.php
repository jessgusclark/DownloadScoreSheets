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


?>
<h1>DownloadScoreSheets Tests</h1>

<h2>ALL ScoreSheets</h2>

<?php
$AllScoreSheets = array();

$sql = "SELECT id, brewName, brewStyle, brewCategory, brewJudgingNumber, brewBrewerID FROM brewing ORDER BY brewJudgingNumber";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
	while ($row = mysql_fetch_object($result)) {
		$TempScoreSheet = new ScoreSheet();
		$TempScoreSheet->BrewID = $row->id;
		$TempScoreSheet->BrewName = $row->brewName . "(" . $row->brewStyle . ")";
		$TempScoreSheet->UserID = $row->brewBrewerID;
		$TempScoreSheet->JudgingNumber = $row->brewJudgingNumber;

		array_push($AllScoreSheets, $TempScoreSheet);
	}
?>

<table width="100%">
<tr>
		<th>Entry #</th>
		<th>Judging #</th>
		<th>Beer Name (style)</th>
		<th>Download</th>
		<th>Auto Tests</th>
</tr>
<?php

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
			}
			echo "-->";


		echo "<tr>
			<td>" . $SingleSheet->BrewID . "</td>
			<td>" . $SingleSheet->JudgingNumber . "</td>
			<td>" . $SingleSheet->BrewName . "</td>
			<td><a href='/mods/downloadScoreSheets/download.php?pdf=" . $SingleSheet->BrewID . "' target=\"_blank\">Test Download</a></td>
			<td><strong>user has access:</strong> " . $HasAccess . "
					  <br/><strong>file exists:</strong> " . $FileExists . "
					  </td>
		</tr>";
	}
?>
</table>
</body>
</html>
