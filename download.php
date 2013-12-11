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
	
?>