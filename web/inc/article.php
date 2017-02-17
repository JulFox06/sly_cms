<?php
$req = "SELECT count(*) FROM sly_article";
$res = mysqli_query($lien,$req);
$array_count = mysqli_fetch_array($res);

if (($array_count = $array_count[0]) == 0) {
	echo "<h4 class='text-center'>Aucun article trouvé.</h4>";
}
else {
	if ($page == 1) {
		echo "<h2><small>ARTICLES RECENTS</small></h2>";
	}
	$req = "SELECT * FROM sly_article ORDER BY aid DESC LIMIT $premier,$parpage";
	$res = mysqli_query($lien,$req);

	$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
	while ($array_art = mysqli_fetch_array($res)) {

		//Vérif compteur de commentaire
		$req = "SELECT count(*) AS nbcom FROM sly_comment WHERE aid=".$array_art['aid'];
		$res2 = mysqli_query($lien,$req);
		$array_com = mysqli_fetch_array($res2);

		//Vérif nom catégorie
		$req = "SELECT * FROM appartient WHERE aid=".$array_art['aid'];
		$res3 = mysqli_query($lien,$req);
		$array_cat = mysqli_fetch_array($res3);

		$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat['cid'];
		$res4 = mysqli_query($lien,$req);
		$array_cat_s_name = mysqli_fetch_array($res4);

		$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat_s_name['cid_1'];
		$res5 = mysqli_query($lien,$req);
		$array_cat_name = mysqli_fetch_array($res5);

		list($date_complete, $heure) = explode(' ', $array_art['date_public']);
	    list($annee, $mois, $jour) = explode('-', $date_complete);
	    $mois = str_replace('0','',$mois);
	    $date_actus = $jour. ' '.$mois_fr[$mois].' '.$annee.' à '.$heure;
		echo "<hr>";
		echo "<h2>".$array_art['titre']."</h2>";
		echo "<div class='text-right'>";
		if (($_SESSION['groupe'] == 'Administrateur') || ($_SESSION['groupe'] == 'Modérateur') || ($_SESSION['login'] == $array_art['auteur'])) {
			echo "<a href='modify.php?id=".$array_art['aid']."' class='btn btn-warning'><span class='glyphicon glyphicon-edit'></span></a> ";
			echo "<a href='delart.php?id=".$array_art['aid']."' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></a>";
		}
		echo "</div>";
		echo "<h5><span class='glyphicon glyphicon-time'></span> Posté par <a href='profil.php?user=".$array_art['auteur']."'>".$array_art['auteur']."</a>, ".$date_actus;
		echo "<h5>";
		if ($array_cat_s_name['cid_1'] == NULL) {
			echo "<span class='label label-primary'>".$array_cat_s_name['name']."</span>";
		}
		else {
			echo "<span class='label label-primary'>".$array_cat_name['name']."</span> <span class='label label-info'>".$array_cat_s_name['name']."</span>";
		}
		echo "</h5><br>";
		echo "<div class='article'>".$array_art['contenu']."</div><br>";
		echo "<p class='text-right'><span class='badge'>".$array_com['nbcom']."</span> <a href='?comment=".$array_art['aid']."'>Commentaires</a></p><br>";
  }
}
?>