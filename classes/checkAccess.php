<?php

class CheckAccess{

	public $HasAccess;

	//Boolean:
	public $AllowDownload;
	protected $ScoresheetsReady;

	public $FileExists;
	public $BrewName;

	protected $mysql;
	protected $ScoresheetID;
	protected $UserID;

	public function __construct() {
		include("../config.php");

		global $DownloadLinksReady;
		$this->ScoresheetsReady = $DownloadLinksReady;

	}

	public function CheckAccess($userID, $scoresheetID){
		if (!$this->ScoresheetsReady)
			return false;

		if (!is_numeric($scoresheetID) || !is_numeric($userID))
			return false;

		// variables are good; set them:
		$this->ScoresheetID = $scoresheetID;	
		$this->UserID = $userID;	

		if(!$this->CheckIfUserHasAccessToDownload())
			return false;
		if (!$this->CheckToSeeIfFileExists())
			return false;
		


		return true;
	}

	protected function CheckIfUserHasAccessToDownload(){
		
		include("../../site/config.php");		
		mysql_select_db($database, $connection);

		//check to see if this user has access to download this PDF:
		$sql = "SELECT id, brewName FROM `brewing` WHERE brewBrewerID = '" . $this->UserID . "' AND id= '" . $this->ScoresheetID . "' LIMIT 1";
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());

		if(mysql_num_rows($result)==0)
			return false;
		
		while ($row = mysql_fetch_object($result)) {
			$this->BrewName = $row->brewName;
		}

		return true;
	}

	protected function CheckToSeeIfFileExists(){
		global $PdfDirectory, $FileNamePrefix;
		$FileName = $PdfDirectory . $FileNamePrefix . $this->ScoresheetID . '.pdf';
		
		if (!file_exists ( $FileName ))
			return false;

		return true;
	}
}
?>