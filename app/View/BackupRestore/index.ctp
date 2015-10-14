<?php
echo "<ul>\n";
foreach ($msgs as $msg) {
	echo "<li>".$msg."</li>\n";
}
echo "</ul>\n";
echo "<h1>Backups Available for Download</h1>";
echo "<ul>\n";
foreach ($files as $fname) {
	echo "<li>".$this->Html->link($fname,
             	       array('controller'=>'BackupRestore','action'=>'download',
	                   $fname))."</li>\n";
}
echo "</ul>\n";