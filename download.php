<?php
	session_start();
	include("config.php");
	include("classes/checkAccess.php");
	include("classes/scoresheet.php");

	$check = new checkAccess();

	if ($check->CheckAccess($brewerID, $_REQUEST["pdf"])){
		$BrewName = $check->BrewName;
		foreach(array(" ", "'", '"', "&") as $item){
			$BrewName = str_replace($item, "", $BrewName);
		}

		$DownloadScoreSheet = new scoresheet();
		$DownloadScoreSheet->GetJudgingNumberByBrewID($_REQUEST["pdf"]);

		header('Content-type: application/pdf');

		// It will be called Scoresheet####BrewName.pdf
		header('Content-Disposition: attachment; filename="Scoresheet' . $ScoresheetID . '-' . $DownloadScoreSheet->BrewName . '.pdf"');

		// Original PDF:
		//echo $PdfDirectory . $FileNamePrefix . $DownloadScoreSheet->ReturnJudgingNumber() . '.pdf';
		readfile($PdfDirectory . $FileNamePrefix . $DownloadScoreSheet->ReturnJudgingNumber() . '.pdf');

	}else{
		echo "A generic error occurred.";
	}
	
?>