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
include("../classes/scoresheetTest.php");

if (is_numeric($_REQUEST["scoresheetID"])){

	$ConfirmScoreSheet = new Scoresheet();
	$ConfirmScoreSheet->GetJudgingNumberByBrewID($_REQUEST["scoresheetID"]);

?>

<form id="form1" name="form1" method="post" action="confirm.php">
	<h2>Scoresheet: <?php echo $ConfirmScoreSheet->ReturnJudgingNumber(); ?></h2>
	<p>ConfirmID: <?php echo $ConfirmScoreSheet->ConfirmID; ?></p>
	<p>Scoresheet ID: <?php echo $ConfirmScoreSheet->JudgingNumber; ?><input type="hidden" name="JudgingID" value="<?php echo $ConfirmScoreSheet->JudgingNumber; ?>"></p>
	<p>Judging ID: <?php echo $ConfirmScoreSheet->BrewID; ?><input type="hidden" name="BrewID" value="<?php echo $ConfirmScoreSheet->BrewID; ?>"></p>
	<p>Scoresheet Status: 
	<select name="status">
		<option value="0">Error</option>
		<option value="1">Confirmed.</option>
	</select>
	</p>
	<p>Reviewed by: <input type="text" name="VerifiedBy" value=""/></p>
	<p>Comments:<textarea name="comments"> </textarea></p>
	<p><input type="submit"></p>
</form>


<?php

}


?>

</body>
</html>
