<?php
	session_start();
	include("config.php");
	include("classes/checkAccess.php");

	$check = new checkAccess();

	if ($check->CheckAccess($_SESSION['brewerID'], $_REQUEST["pdf"])){
		$BrewName = $check->BrewName;
		foreach(array(" ", "'", '"', "&") as $item){
			$BrewName = str_replace($item, "", $BrewName);
		}

		$ScoresheetID = $_REQUEST["pdf"];

		header('Content-type: application/pdf');

		// It will be called Scoresheet####BrewName.pdf
		header('Content-Disposition: attachment; filename="Scoresheet' . $ScoresheetID . '-' . $BrewName . '.pdf"');

		// Original PDF:
		readfile($PdfDirectory . $FileNamePrefix . $ScoresheetID . '.pdf');

	}else{
		echo "A generic error occurred.";
	}

	/*
	
	include("../../site/config.php");

	//Check global data:
	if (!$DownloadLinksReady)
		die("Scoresheets are not ready");

	//ALWAYS check user input:
	if (!is_numeric($_REQUEST["pdf"]))
		die("Invalid ID Number");


	$scoresheetID = $_REQUEST["pdf"];

	mysql_select_db($database, $brewing);

	//check to see if this user has access to download this PDF:
	$sql = "SELECT id, brewName FROM `brewing` WHERE brewBrewerID = '" . $_SESSION['brewerID'] . "' AND id= '" . $scoresheetID . "' LIMIT 1";
	$result = mysql_query($sql) or die('Query failed: ' . mysql_error());

	if(mysql_num_rows($result)==0)
		die("User does not have access to download this file.");


	while ($row = mysql_fetch_object($result)) {
		$brewName = $row->brewName;
	}

	//check to see if the files has been uploaded to the server:
	$FileName = $PdfDirectory . $FileNamePrefix . $scoresheetID . '.pdf';
	if (!file_exists ( $FileName ))
		die("File was not published to server.");


	//clean up file name for download:
	*/

/*
	


	mysql_close($link);*/
?>