DownloadScoreSheets
===================

A plugin for BCOE&amp;M that allows competition participants to download their score sheets once they are ready. This project is still a work in progress and was used in the 2014 Sweethearts Revenge Competition: http://sweethearts.weizguys.com/

Install
-------
Extract all the files into the directory: **/mods/downloadScoreSheets**

Open up **/mods/downloadScoreSheets/config.php** and change the second variable name ($PdfDirectory) to point to a new directory that you will upload the final score sheet PDF's to. 

Upload the **/mods/downloadScoreSheets** directory to the server.

Create the score sheet directory on the server.

In the BCOE&amp;M Admin area, make sure Custom Modules are turned on. If they are turned off, go to the Site Preferences located under "Defining Preferences". Set "Use Custom Modules" to "Yes"

Once Custom Modules are set to "Yes", Go to "Admin" / "Custom Modules" / "Add" / "A Custom Module". Use the following options:

- **Custom Module Name:** DownloadScoreSheets

- **Description:**

- **FileName:** downloadScoreSheets/downloadScoreSheets.php

- **Type:** PHP Code or Function

- **Permission:** All Users

- **Extends Core Function:** User's My Info and Entries

- **Rank:** 1

- **Display Order:** After Content

- **Enable?:** Yes

### Check Installation

Go to the "My Info and Entries" page and scroll to the bottom. There should be a heading that says "Download Score Sheets". 

### Upload Scoresheets

The scoresheets need to be scanned in and then named according to their Judging Number. I.E. 01-001.pdf, 01-002.pdf.

Upload the PDF's into the score sheets directory that was defined in the configuration file.

Open up **/mods/downloadScoreSheets/config.php** and change the first variable ($DownloadLinksReady) to TRUE

If you have entered a beer into the competition, go to the "My Info and Entries" page and scroll to the bottom. For each beer entered, there should be a bulleted item that when clicked will download that PDF.

### Test Downloads

Open up config.php and change $TestMode = TRUE. This will allow any user to download any scoresheet and is helpful for testing. 

You will also need to create a new table in your database to use for confirming. Use the following SQL in PHPMyADMIN:

```
CREATE TABLE IF NOT EXISTS `downloadConfirm` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ScoresheetID` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `VerifiedBy` varchar(255) NOT NULL,
  `Comments` text NOT NULL,
  `Sha` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
);
```

Navigate to /mods/downloadScoreSheets/tests/all.php to see a list of all the beer entries in the database.