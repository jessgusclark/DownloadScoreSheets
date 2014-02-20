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

<h2>Simulate User:</h2>
<form name="form1" method="post" action="">
	<p>UserID: <input type="text" name="UserID"></p>
	<p><input type="submit"></p>
</form>
<table width="100%">
<tr>
		<th>Entry #</th>
		<th>Judging #</th>
		<th>Beer Name</th>
		<th>Style</th>
		<th>Download</th>
		<th>Auto Tests</th>
</tr>
<?php

	if (isset($_POST["UserID"])){

		// uses exact same code that the user has execpt we get the ID from POST back:
		$SimulateUser = new brewUser($_POST["UserID"]);
		$SimulateUser->GetScoreSheetsForUser();

		// show user data:		
		$sql = "SELECT uid, brewerFirstName, brewerLastName FROM brewer WHERE uid = '" . $SimulateUser->UserID. "' LIMIT 1";
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
		while ($row = mysql_fetch_object($result)) {
			echo "<h3>" . $row->brewerFirstName . " " . $row->brewerLastName . " (" . $row->uid . ")</h3>";
		}

		$check = new CheckAccess();	

		foreach ($SimulateUser->AllScoresheets as $SingleSheet){

			// A few nasty SELECTS:
			$sql = "SELECT brewCategory, brewStyle FROM brewing WHERE id = '" . $SingleSheet->BrewID . "'";
			$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
			while ($row = mysql_fetch_object($result)) {
				$categoryNumber = $row->brewCategory;
				$categoryWritten = $row->brewStyle;
			}

			//AutoTesting:
			//
			//echo "<!--";
			echo "<br>";
			global $TestMode;
			$TestMode = FALSE;
			if ($check->CheckIfUserHasAccessToDownload($SingleSheet)){
				$HasAccess = "TRUE";
			}else{
				$HasAccess = "FALSE";
			}
			if($check->CheckToSeeIfFileExists($SingleSheet)){
				$FileExists = "TRUE";
			}else{
				$FileExists = "<span class=\"red\">FALSE</span>";
			}
			echo "-->";



			echo "<tr><td>" . $SingleSheet->BrewID . "</td>
					  <td>" . $SingleSheet->ReturnJudgingNumber() . "</td>
					  <td>" . $SingleSheet->BrewName . "</td>
					  <td><em>(" . $categoryNumber . ") " . $categoryWritten . "</em></td>
					  <td><a href='/mods/downloadScoreSheets/download.php?pdf=" . $SingleSheet->BrewID . "' target=\"_blank\">Test Download</a></td>
					  <td><strong>user has access:</strong> " . $HasAccess . "
					  <br/><strong>file exists:</strong> " . $FileExists . "
					  <br/><strong>file name:</strong> Scoresheet" . $SingleSheet->BrewID . "-" . $SingleSheet->GetSafeBrewName() . ".pdf
					  </td>
					</tr>";
		}


?>

<?php } ?>
</table>
</body>
</html>
