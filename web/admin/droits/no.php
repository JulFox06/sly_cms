<?php
include '../../../contents/sly_config.php';
list($login, $accept) = explode('_', $_POST['id']);
$req = "DELETE FROM sly_rank WHERE login = '$login'";
$res = mysqli_query($lien, $req);
if (!$res) {
	echo "Erreur SQL : $req <br>".mysqli_error($lien);
}

// Envoi de mail à réaliser ultérieurement pour prévenir le demandeur