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

		if(!$this->CheckIfUserHasAccessToDownload())
			return false;


		$this->ScoresheetID = $scoresheetID;	
		$this->UserID = $userID;	


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
		global $database;
		global $brewing;

		echo $database . "<br>" . $brewing . "<br>";

		
		mysql_select_db($database, $brewing);

		//check to see if this user has access to download this PDF:
		$sql = "SELECT id, brewName FROM `brewing` WHERE brewBrewerID = '" . $this->UserID . "' AND id= '" . $this->ScoresheetID . "' LIMIT 1";
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());

		echo $sql;

		if(mysql_num_rows($result)==0)
			return false;

	}

}
?>