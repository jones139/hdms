<?php
echo "<ul>\n";
foreach ($msgs as $msg) {
	echo "<li>".$msg."</li>\n";
}
echo "</ul>\n";
echo "<h1>Backups Available for Download</h1>";
echo "<ul>\n";
if (count($files)==0) {
   echo "<li>No Backup Files Found</li><br/>";
}
foreach ($files as $fname) {
	echo "<li>".$this->Html->link($fname,
             	       array('controller'=>'BackupRestore','action'=>'download',
	                   $fname))."</li>\n";
}
echo "</ul>\n";

echo "<hr/><div >";
echo "<h1>Perform New Backup</h1>";
echo "<p>Create a backup of the current database and files.</p>";
echo "<form action=\"Backup\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=\"submit\" value=\"Create Backup\" name=\"submit\">";
echo "</form>"; 
echo "</div>";


echo "<hr/><div >";
echo "<h1>Upload New Backup File</h1>";
echo "<p>Select a backup file from your computer to upload to the server ready for restoring."
			."  Note that this does NOT restore the backup</p>";
echo "<form action=\"uploadBackupFile\" method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=\"file\" name=\"uploadedFile\">"; 
echo "<input type=\"submit\" value=\"Upload File\" name=\"submit\">";
echo "</form>"; 
echo "</div>";


echo "<hr/><div >";
echo "<h1>Delete Backup File</h1>";
echo "<p>Type in the filename of a backup file to be deleted.</p>";
echo "<p>NOTE:  This action is non-reversible - be very careful!!!!</p>";
echo "<form action=\"DeleteBackupFile\" method=\"post\"  enctype=\"multipart/form-data\">";
echo "<input type='text' name='fname' id='fname'>"; 
echo "<input type='submit' value='Delete Backup File' name='submit'>";
echo "</form>"; 
echo "</div>";

echo "<hr/><div >";
echo "<h1>Restore Backup</h1>";
echo "<p>Type in the filename of a backup file stored on the server as listed above to restore the database"
		." and files.</p>";
echo "<p>NOTE:  This action is non-reversible - be very careful!!!!</p>";
echo "<form action=\"RestoreBackup\" method=\"post\"  enctype=\"multipart/form-data\">";
echo "<input type='text' name='fname' id='fname'>"; 
echo "<input type='submit' value='Restore Backup' name='submit'>";
echo "</form>"; 
echo "</div>";


?>

