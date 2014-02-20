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
}
?> 