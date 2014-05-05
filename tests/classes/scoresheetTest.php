<?php
class ScoreSheetTest extends ScoreSheet{
	public $BrewPaid;
	public $BrewReceived;

	public $BrewStyle;

	// for use with the confirm table:
	public $ConfirmID;
	public $Status;
	public $VerifiedBy;
	public $Comments;
	public $Sha;

	public function CheckConfirm() {

		$sql = "SELECT * FROM downloadConfirm WHERE ScoreSheetID = '" . $this->BrewID . "'";
		$result = mysql_query($sql) or die('Query failed (scoresheet.php): ' . mysql_error());
		while ($row = mysql_fetch_object($result)) {
			$this->ConfirmID = $row->ID;
			$this->ScoresheetID = $row->ScoresheetID;
			$this->Status = $row->Status;
			$this->VerifiedBy = $row->VerifiedBy;
			$this->Comments = $row->Comments;
			$this->Sha = $row->Sha;
		}

	}

	public function ReturnConfirmation(){
		if (!isset($this->ConfirmID))
			return "<span class='grey'>Not Confirmed</span>";

		if ($this->Status == 0)
			return "<span class='red'>ERROR!</span>" ;

		return "<img src=\"/images/check.jpg\">" . $this->VerifiedBy;

	}

	public function ConfirmScoreSheet(){
		if ($this->ConfirmID == ""){
			$sql = "INSERT INTO `downloadConfirm` (`ScoresheetID`, `Status`, `VerifiedBy`, `Comments`) 
			VALUES ('" . $this->BrewID . "', 
					'" . $this->Status . "', 
					'" . $this->VerifiedBy . "', 
					'" . $this->Comments . "');";
		}else{
			//update	
			$sql = "UPDATE `downloadConfirm` 	
					SET `Status` = '" . $this->Status . "', 
					`VerifiedBy` = '" . $this->VerifiedBy . "', 
					`Comments` = '" . $this->Comments . "' 
					WHERE `ID` = '" . $this->ConfirmID . "';";
		}

		$result = mysql_query($sql) or die('Query failed (scoresheetTest.php): ' . mysql_error());
	}
}
?> 