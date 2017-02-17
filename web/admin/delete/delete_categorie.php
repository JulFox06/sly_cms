<?php
include '../../../contents/sly_config.php';

$req = "SELECT * FROM appartient WHERE cid = ".$_POST['id'];
$res = mysqli_query($lien, $req);
while ($article = mysqli_fetch_array($res)) {
	$req = "DELETE FROM sly_article WHERE aid = "$article['aid'];
	$res_d = mysqli_query($lien, $req);
	if (!$res) {
		echo "Erreur SQL : $req <br>".mysqli_error($lien);
	}
}

$req = "DELETE FROM appartient WHERE cid = ".$_POST['id'];
$res = mysqli_query($lien, $req);
if (!$res) {
	echo "Erreur SQL : $req <br>".mysqli_error($lien);
}
$req = "DELETE FROM sly_categorie WHERE cid = ".$_POST['id'];
$res = mysqli_query($lien, $req);
if (!$res) {
	echo "Erreur SQL : $req <br>".mysqli_error($lien);
}