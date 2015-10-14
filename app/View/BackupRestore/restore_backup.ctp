<?php
echo "<ul>\n";
foreach ($msgs as $msg) {
	echo "<li>".$msg."</li>\n";
}
echo "</ul>\n";
echo "<br/>";
echo "<a href='listBackups' class='Action'>Back</a>";