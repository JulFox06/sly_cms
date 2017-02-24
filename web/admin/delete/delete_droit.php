<?php
include '../../../contents/sly_config.php';
$req = "UPDATE sly_user SET groupe='Visiteur' WHERE uid = ".$_POST['id'];
$res = mysqli_query($lien, $req);
if (!$res) {
	echo "Erreur SQL : $req <br>".mysqli_error($lien);
}