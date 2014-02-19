<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Test Scoresheets being ready.</title>
</head>

<body>
<?php
		include("../classes/user.php");
?>
<h1>DownloadScoreSheets Tests</h1>

<h2>Simulate User:</h2>
<form name="form1" method="post" action="index.php">
	<p>UserID: <input type="text" name="UserID"></p>
	<p><input type="submit"></p>
</form>
<?php
	if (isset($_POST["UserID"]){
	/*$SimulateUser = new User($_POST["UserID"]);
	$SimulateUser->GetScoreSheetsForUser();
	var_dump($SimulateUser);*/
?>

<?php } ?>
</body>
</html>
