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
	var_dump($ConfirmScoreSheet);

?>

<form id="form1" name="form1" method="post" action="">


</form>


<?php

}


?>

</body>
</html>
