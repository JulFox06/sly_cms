<?php
include '../../../contents/sly_config.php';
$req = "DELETE FROM sly_article WHERE aid = ".$_POST['id'];
$res = mysqli_query($lien, $req);
if (!$res) {
	echo "Erreur SQL : $req <br>".mysqli_error($lien);
}