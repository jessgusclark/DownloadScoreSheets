<?
class ScoreSheet {

	public $BrewID;
	public $BrewName;
	public $UserID;
	public $JudgingNumber;

	public function ReturnJudgingNumber(){		
		return substr($this->JudgingNumber, 0, 2) . "-" . substr($this->JudgingNumber, 2, 4);
	}
	
	public function GetSafeBrewName(){
		$SafeName = $this->BrewName;
		foreach(array(" ", "'", '"', "&") as $item){
			$SafeName = str_replace($item, "", $SafeName);
		}
		return ($SafeName);
	}

	public function GetJudgingNumberByBrewID($_brewID){
		include("../../site/config.php");
		mysql_select_db($database, $connection);
		
		$sql = "SELECT id, brewName, brewJudgingNumber FROM `brewing` WHERE Id = '" . $_brewID . "' ";
		$result = mysql_query($sql) or die('Query failed (scoresheet.php): ' . mysql_error());
		while ($row = mysql_fetch_object($result)) {
			$this->BrewID = $row->id;
			$this->BrewName = $row->brewName;
			$this->JudgingNumber = $row->brewJudgingNumber;
		}
	}

}
?>