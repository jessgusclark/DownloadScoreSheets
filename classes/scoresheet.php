<?
class ScoreSheet {

	public $BrewID;
	public $BrewName;
	public $JudgingNumber;

	public function ReturnJudgingNumber(){
		return substr($this->JudgingNumber, 0, 1) . "-" . substr($this->JudgingNumber, 2, 4);
	}

}
?>