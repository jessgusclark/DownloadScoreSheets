<?php
class brewUser{
	public $UserID;
	public $UserName;
	public $AllScoresheets;

	public function __construct($int) {
        $this->UserID = $int;
    }  

	public function GetScoreSheetsForUser(){
		include("mods/downloadScoreSheets/classes/scoresheet.php");
		$this->AllScoresheets = array();

		$sql = "SELECT id, brewName FROM `brewing` WHERE brewBrewerID = '" . $this->UserID . "' ";
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
		while ($row = mysql_fetch_object($result)) {

			$tempScoresheet = new scoresheet();
			$tempScoresheet->BrewID = $row->id;
			$tempScoresheet->BrewName = $row->brewName;

			array_push($this->AllScoresheets, $tempScoresheet);
		}

	}

}
?>