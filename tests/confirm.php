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

?>

<form id="form1" name="form1" method="post" action="confirm.php">
	<h2>Scoresheet: <?php echo $ConfirmScoreSheet->ReturnJudgingNumber(); ?></h2>
	<p>ConfirmID: <?php echo $ConfirmScoreSheet->ConfirmID; ?><input type="hidden" name="ConfirmID" value="<?php echo $ConfirmScoreSheet->ConfirmID; ?>"></p>
	<p>Judging ID: <?php echo $ConfirmScoreSheet->BrewID; ?><input type="hidden" name="BrewID" value="<?php echo $ConfirmScoreSheet->BrewID; ?>"></p>
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

	include("../../../site/config.php");
	mysql_select_db($database, $connection);

	if ($_POST["ConfirmID"] == ""){
		$sql = "INSERT INTO `downloadConfirm` (`ScoresheetID`, `Status`, `VerifiedBy`, `Comments`) 
		VALUES ('" . $_POST["BrewID"] . "', 
				'" . $_POST["Status"] . "', 
				'" . $_POST["VerifiedBy"] . "', 
				'" . $_POST["Comments"] . "');";
	}else{
		//update	
		$sql = "UPDATE `downloadConfirm` 	
				SET `Status` = '" . $_POST["Status"] . "', 
				`VerifiedBy` = '" . $_POST["VerifiedBy"] . "', 
				`Comments` = '" . $_POST["Comments"] . "' 
				WHERE `ID` = '" . $_POST["ConfirmID"] . "';";
	}

		$result = mysql_query($sql) or die('Query failed (scoresheet.php): ' . mysql_error());


		echo "<h2>Comfirmed Saved.</h2>";
}
?>

</body>
</html>
