DownloadScoreSheets
===================

A plugin for BCOE&amp;M that allows users to download their score sheets once they are ready. This project is still a work in progress and will be used in the 2014 Sweethearts Revenge Competition: http://sweethearts.weizguys.com/

Install
-------
Extract all the files into the directory: **/mods/downloadScoreSheets**

Open up **/mods/downloadScoreSheets/config.php** and change the second variable name ($PdfDirectory) to point to a new directory that you will upload the final score sheet PDF's to. 

Create the score sheet directory on the server.

In the BCOE&amp;M Admin area, make sure Custom Modules are turned on. If they are turned off, go to the Site Preferences located under "Defining Preferences". Set "Use Custom Modules" to "Yes"

Once Custom Modules are set to "Yes", Go to "Admin" / "Custom Modules" / "Add" / "A Custom Module". Use the following options:

- **Custom Module Name:** DownloadScoreSheets

- **Description:**

- **FileName:** downloadScoreSheets/downloadScoreSheets.php

- **Type:** PHP Code or Function

- **Permission:** All Users

- **Extends Core Function:** Entry Information

- **Rank:** 1

- **Display Order:** After Content

- **Enable?:** Yes

### Check Installation

Go to the "My Info and Entries" page and scroll to the bottom. There should be a heading that says "Download Score Sheets". 

### Upload Scoresheets

After the scoresheets have been scanned in and named correctly (Scoresheet1.pdf, Scoresheet2.pdf, etc.) upload them into the score sheets directory.

Open up **/mods/downloadScoreSheets/config.php** and change the first variable ($DownloadLinksReady) to TRUE

If you have entered a beer into the competition, go to the "My Info and Entries" page and scroll to the bottom. For each beer entered, there should be a bulleted item that when clicked will download that PDF.
