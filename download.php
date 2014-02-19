<?php
	session_start();
	include("config.php");
	include("classes/checkAccess.php");
	include("classes/scoresheet.php");

	$check = new checkAccess();

	if ($check->CheckAccess($brewerID, $_REQUEST["pdf"])){

		$DownloadScoreSheet = new scoresheet();
		$DownloadScoreSheet->GetJudgingNumberByBrewID($_REQUEST["pdf"]);

		header('Content-type: application/pdf');

		// It will be called Scoresheet####BrewName.pdf
		header('Content-Disposition: attachment; filename="Scoresheet' . $ScoresheetID . '-' . $DownloadScoreSheet->GetSafeBrewName . '.pdf"');

		// Original PDF:
		//echo $PdfDirectory . $FileNamePrefix . $DownloadScoreSheet->ReturnJudgingNumber() . '.pdf';
		readfile($PdfDirectory . $FileNamePrefix . $DownloadScoreSheet->ReturnJudgingNumber() . '.pdf');

	}else{		
		echo "<hr/>A generic error occurred.";
	}
	
?>