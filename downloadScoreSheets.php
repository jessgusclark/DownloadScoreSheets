<?php
	include("config.php");
?>
<h2>Download Score Sheets</h2>
<?php
if ($DownloadLinksReady){

	include("mods/downloadScoreSheets/classes/user.php");

	$LoadUser = new brewUser($_SESSION['brewerID']);
	$LoadUser->GetScoreSheetsForUser();

	foreach ($LoadUser->AllScoresheets as $ScoreSheet) {
		echo "<li><a href=\"mods/downloadScoreSheets/download.php?pdf=" . $ScoreSheet->BrewID . "\" target=\"_blank\">"
		 . $ScoreSheet->BrewName . "</a></li>";
	}

}else{
	echo "<p>Please come back after the competition is over to download your scoresheets.</p>";
}
?>