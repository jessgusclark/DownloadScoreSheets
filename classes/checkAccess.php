<?php

class CheckAccess{

	public $HasAccess;

	//Boolean:
	public $AllowDownload;
	protected $ScoreshetsReady;

	public $FileExists;

	protected $mysql;
	protected $ScoresheetID;
	protected $UserID;

	public function __construct() {
		include("../config.php");

		global $DownloadLinksReady;
		$this->ScoreshetsReady = $DownloadLinksReady;

	}

	public function CheckAccess($userID, $scoresheetID){
		if (!$this->ScoreshetsReady())
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

	protected function ScoreshetsReady(){
		if (!$this->ScoreshetsReady){
			return false;
			//die("Scoresheets are not ready");
		}
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