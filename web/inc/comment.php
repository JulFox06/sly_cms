<?php
if (isset($_GET['comment'])) {
	$comment = $_GET['comment'];

	$req = "SELECT * FROM sly_article WHERE aid=$comment";
	$res = mysqli_query($lien,$req);

	$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
	while ($array_art = mysqli_fetch_array($res)) {

		//Vérif nom catégorie
		$req = "SELECT * FROM appartient WHERE aid=".$array_art['aid'];
		$res3 = mysqli_query($lien,$req);
		$array_cat = mysqli_fetch_array($res3);

		$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat['cid'];
		$res4 = mysqli_query($lien,$req);
		$array_cat_s_name = mysqli_fetch_array($res4);

		$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat_s_name['cid_1'];
		$res5 = mysqli_query($lien,$req);
		if ($res5) {
			$array_cat_name = mysqli_fetch_array($res5);
		}

		list($date_complete, $heure) = explode(' ', $array_art['date_public']);
    list($annee, $mois, $jour) = explode('-', $date_complete);
    $mois = str_replace('0','',$mois);
    $date_actus = $jour. ' '.$mois_fr[$mois].' '.$annee.' à '.$heure;
		echo "<h2>".$array_art['titre']."</h2>";
		echo "<div class='text-right'>";
		if (isset($_SESSION['login']) && (($_SESSION['groupe'] == 'Administrateur') || ($_SESSION['groupe'] == 'Modérateur') || ($_SESSION['login'] == $array_art['auteur']))) {
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
		echo "<div class='article'>".$array_art['contenu']."</div>";
		echo "<hr>";
	}
}

if (isset($_SESSION['login'])) {
	?>
	<h4>Laissez un commentaire :</h4>
  <form method="post" action="index.php?comment=<?php echo $_GET['comment'];?>" role="form">
    <div class="form-group">
      <textarea class="form-control" name="contenu" style="resize: vertical;" rows="3" required></textarea>
    </div>
    <button type="submit" name="submit" class="btn btn-info">Poster</button>
  </form>
<?php
	if (isset($_POST['submit'])) {
		$message = trim(htmlentities(mysqli_real_escape_string($lien,$_POST['contenu'])));
		$login = $_SESSION['login'];
		$aid = $_GET['comment'];
		$req_s = "INSERT INTO sly_comment VALUES (NULL,'$login','".date('Y-m-d H:i:s')."','$message','$aid')";
		$res_s = mysqli_query($lien,$req_s);
		if (!$res_s) {
			echo "Erreur SQL : $req_s <br>".mysqli_error($lien);
		}
		else {
			echo '<div class="alert alert-success"><strong>Bravo !</strong> Votre commentaire a été ajouté.</div>';
		}
	}
}
?>


  <div class="row">
  	<?php
  	$req = "SELECT * FROM sly_comment WHERE aid=$comment ORDER BY date_post DESC";
  	$res = mysqli_query($lien,$req);
  	while ($array_comment = mysqli_fetch_array($res)) {
  		list($date_complete2, $heure2) = explode(' ', $array_comment['date_post']);
	    list($annee2, $mois2, $jour2) = explode('-', $date_complete2);
	    $mois2 = str_replace('0','',$mois);
	    $date_comment = $jour2. ' '.$mois_fr[$mois2].' '.$annee2.' à '.$heure2;

  		echo '<div class="col-sm-2 text-center">';
  		//Affichage des avatars
  		$req = "SELECT * FROM sly_user WHERE login='".$array_comment['auteur']."'";
  		$res2 = mysqli_query($lien,$req);
	  	while ($array_team = mysqli_fetch_array($res2)){
	  		if ($array_team['sexe'] == 'F') {
	  			echo '<img src="profil_img/woman.png" class="img-circle" height="65" width="65" alt="Avatar">';
	  		}
	  		else if ($array_team['sexe'] == 'H') {
	      	echo '<img src="profil_img/boss.png" class="img-circle" height="65" width="65" alt="Avatar">';
	      }
    	}

    	echo '</div>';
	    echo '<div class="col-sm-10">';
	    echo '<h4>'.$array_comment['auteur'].' <small>'.$date_comment.'</small></h4>';
	    echo '<p>'.$array_comment['contenu'].'</p><br>';
	    echo '</div>';
  	}
  	?>
  </div>