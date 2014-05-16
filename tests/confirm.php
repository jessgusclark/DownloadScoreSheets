<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Confirm Scoresheet</title>
</head>

<body>

<?php
include("../../../site/config.php");
include("../config.php");
mysql_select_db($database, $connection);

include("../classes/scoresheet.php");
include("classes/scoresheetTest.php");

if (isset($_REQUEST["scoresheetID"])){

	$ConfirmScoreSheet = new ScoreSheetTest();	
	$ConfirmScoreSheet->BrewID = $_REQUEST["scoresheetID"];
	$ConfirmScoreSheet->CheckConfirm();

	//temp: nasty SELECT:
	$sql = "SELECT id, brewName, brewStyle, brewJudgingNumber FROM `brewing` WHERE Id = '" . $ConfirmScoreSheet->BrewID . "' ";
	$result = mysql_query($sql) or die('Query failed (scoresheet.php): ' . mysql_error());
	while ($row = mysql_fetch_object($result)) {
		$brewName = $row->brewName;
		$brewStyle = $row->brewStyle;
		$JudgingNumber = $row->brewJudgingNumber;
	}
?>

<form id="form1" name="form1" method="post" action="confirm.php">
	<h2>Scoresheet: <?php echo $ConfirmScoreSheet->ReturnJudgingNumber(); ?></h2>
	<p><a href='../download.php?pdf=<?php echo $ConfirmScoreSheet->BrewID; ?>' target=\"_blank\">Test Download</a></p>
	<input type="hidden" name="ConfirmID" value="<?php echo $ConfirmScoreSheet->ConfirmID; ?>">
	<input type="hidden" name="BrewID" value="<?php echo $ConfirmScoreSheet->BrewID; ?>">

	<p>Brew Style: <?php echo $brewStyle;?></p>
	<p>Judging ID: <?php echo $JudgingNumber; ?></p>
	<p>Scoresheet Status: 
	<select name="Status">
		<option value="0">Error</option>
		<option value="1" <?php if ($ConfirmScoreSheet->Status == "1"){ ?>selected="selected"<?php } ?>>Confirmed.</option>
	</select>
	</p>
	<p>Reviewed by: <input type="text" name="VerifiedBy" value="<?php echo $ConfirmScoreSheet->VerifiedBy; ?>"/></p>
	<p>Comments:<textarea name="Comments"><?php echo $ConfirmScoreSheet->Comments; ?></textarea></p>
	<p><input type="submit"></p>
</form>

<?php } ?>


<?php

if (isset($_POST["ConfirmID"])){

	$SetConfirmScoreSheet = new ScoreSheetTest();
	$SetConfirmScoreSheet->ConfirmID = $_POST["ConfirmID"];
	$SetConfirmScoreSheet->BrewID = $_POST["BrewID"];
	$SetConfirmScoreSheet->Status = $_POST["Status"];
	$SetConfirmScoreSheet->VerifiedBy = $_POST["VerifiedBy"];
	$SetConfirmScoreSheet->Comments = $_POST["Comments"];

	$SetConfirmScoreSheet->ConfirmScoreSheet();

	echo "<h2>Comfirmed Saved.</h2>";
}
?>
<hr/>
<ul>
	<li><a href="all.php">Back to All Listings</a></li>
	<li><a href="index.php">Back to People Search</a></li>
</ul>
</body>
</html>
