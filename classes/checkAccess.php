<?php

class CheckAccess{

	//Boolean:
	public function __construct() {
		
	}

	public function CheckAccess($userID, $scoresheetID){
		
		include_once("../config.php");
		global $DownloadLinksReady;
		global $TestMode;

		if (!$DownloadLinksReady && !TestMode){
			echo "Scoresheets are not ready.<br>";
			return false;
		}

		if (!is_numeric($scoresheetID) || !is_numeric($userID)){
			echo "ScoresheetID or UserID is not numeric.";
			return false;
		}

		// variables are good; set them:
		include_once("scoresheet.php");

		$CheckScoreSheet = new ScoreSheet();
		$CheckScoreSheet->GetJudgingNumberByBrewID($scoresheetID);
		$CheckScoreSheet->UserID = $userID;


		if(!$this->CheckIfUserHasAccessToDownload($CheckScoreSheet))
			return false;
		if (!$this->CheckToSeeIfFileExists($CheckScoreSheet))
			return false;
		


		return true;
	}

	public function CheckIfUserHasAccessToDownload($scoreSheet){
		global $TestMode;

		if ($TestMode)
			return true;

		/*include_once("../../site/config.php");		
		mysql_select_db($database, $connection);*/

		//check to see if this user has access to download this PDF:
		$sql = "SELECT id, brewName FROM `brewing` WHERE brewBrewerID = '" . $scoreSheet->UserID . "' AND brewJudgingNumber= '" . $scoreSheet->JudgingNumber . "' LIMIT 1";
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());

		if(mysql_num_rows($result)==0){
			echo "User Does not have access to download that file.";
			return false;
		}
		
		return true;
	}

	public function CheckToSeeIfFileExists($scoreSheet){
		global $PdfDirectory, $FileNamePrefix;
		$FileName = $PdfDirectory . $FileNamePrefix . $scoreSheet->ReturnJudgingNumber() . '.pdf';
		//echo $FileName;
		if (!file_exists ( $FileName )){
			echo "The file '" . $FileName . "' could not be found.";
			return false;
		}
		
		return true;
	}
}
?>