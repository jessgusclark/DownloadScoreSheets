<?php
class brewUser{
	public $UserID;
	public $UserName;
	public $AllScoresheets;

	public function __construct($int) {
        $this->UserID = $int;
    }  

	public function GetScoreSheetsForUser(){
		include_once("scoresheet.php");
		$this->AllScoresheets = array();

		$sql = "SELECT id, brewName, brewJudgingNumber FROM `brewing` WHERE brewBrewerID = '" . $this->UserID . "' ";
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
		while ($row = mysql_fetch_object($result)) {

			$tempScoresheet = new scoresheet();
			$tempScoresheet->BrewID = $row->id;
			$tempScoresheet->BrewName = $row->brewName;
			$tempScoresheet->JudgingNumber = $row->brewJudgingNumber;

			array_push($this->AllScoresheets, $tempScoresheet);
		}

	}

}
?>