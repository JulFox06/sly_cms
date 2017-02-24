<?php
$configfile = "contents/sly_config.php";
if(file_exists($configfile) AND filesize($configfile) > 0) {
	header("Location:web/");
}
else {
	header("Location:install/");
}
?>