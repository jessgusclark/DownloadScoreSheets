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

if (is_numeric($_REQUEST["scoresheetID"])){

	$ConfirmScoreSheet = new Scoresheet();
	$ConfirmScoreSheet->BrewID = $_REQUEST["scoresheetID"];



	var_dump($ConfirmScoreSheet);

}


?>

</body>
</html>
