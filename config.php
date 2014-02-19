<?php
	
	// Please change these variables:
	// After the PDF's have been uploaded into the directory, change this variable to TRUE:
	$DownloadLinksReady = FALSE;


	// This is the path to the directory where the scoresheets are located. KEEP the trailing slash!
	// This can also be placed outside of the directory root if needed. 	
	$PdfDirectory = "../../../scoresheets/";


	// This is the prefix for the naming convention used. If the PDF's are named Scoresheet#.pdf, 
	// then this variable would be equal to "Scoresheet".
	$FileNamePrefix = "";


	// Please leave this variable alone:
	$brewerID = $_SESSION["brewerID"];

?>