<?php
// Catégorie seul + sous catégorie
if (isset($_GET['cat'])) {
	$catid = $_GET['cat'];
	$req = "SELECT count(*) FROM appartient WHERE cid =".$catid;

	$req2 = "SELECT * FROM appartient WHERE cid=".$catid;
	$res = mysqli_query($lien,$req);
	$array_count = mysqli_fetch_array($res);

	if (($array_count = $array_count[0]) == 0) {
		echo "<h4 class='text-center'>Aucun article trouvé.</h4>";
	}
	else {
		$res_art = mysqli_query($lien,$req2);

		$req_c = "SELECT * FROM appartient WHERE cid=".$catid;
		$res_art2 = mysqli_query($lien,$req_c);
		$name_cat = mysqli_fetch_array($res_art2);
		$req_t = "SELECT * FROM sly_categorie WHERE cid=".$name_cat['cid'];
		$res_t = mysqli_query($lien,$req_t);
		$titre_cat = mysqli_fetch_array($res_t);
		echo "<h3>".$titre_cat['name']."</h3>";
		?>

		<table class="table table-user-information">
	  	<thead>
	  		<tr>
	  			<th>Titre</th>
	  			<th>Auteur</th>
	  			<th>Posté le</th>
	  			<th class="text-center">Commentaires</th>
	  		</tr>
	  	</thead>
      <tbody>
    <?php
		while ($array_art_com = mysqli_fetch_array($res_art)){
			$art_com = $array_art_com['aid'];
			$req = "SELECT * FROM sly_article WHERE aid=$art_com ORDER BY date_public DESC";
			$res = mysqli_query($lien,$req);

			$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
			
			while ($array_art = mysqli_fetch_array($res)) {

				//Vérif compteur de commentaire
				$req = "SELECT count(*) AS nbcom FROM sly_comment WHERE aid=".$array_art['aid'];
				$res2 = mysqli_query($lien,$req);
				$array_com = mysqli_fetch_array($res2);

				list($date_complete, $heure) = explode(' ', $array_art['date_public']);
			  list($annee, $mois, $jour) = explode('-', $date_complete);
			    $mois = str_replace('0','',$mois);
			    $date_actus = $jour. ' '.$mois_fr[$mois].' '.$annee;
			    ?>
          	<tr>
          		<td><?php echo "<a href='index.php?comment=".$array_art['aid']."'>".$array_art['titre']."</a>"; ?></td>
          		<td><?php echo "<a href='profil.php?user=".$array_art['auteur']."'>".$array_art['auteur']."</a>"; ?></td>
          		<td><?php echo $date_actus; ?></td>
          		<td class="text-center"><?php echo "<span class='badge'>".$array_com['nbcom']."</span>"; ?></td>
          	</tr>

<?php
		  }
		}
		echo "</tbody></table>";
	}
}

// Catégorie principale
else {
	$catid = $_GET['cats'];

	$req = "SELECT count(*) FROM appartient WHERE cid =".$catid;

	$res = mysqli_query($lien,$req);
	$array_count = mysqli_fetch_array($res);

	if (($array_count = $array_count[0]) == 0) {
		echo "";
	}
	else {
		$req_c = "SELECT * FROM appartient WHERE cid=".$catid;
		$res_art2 = mysqli_query($lien,$req_c);
		$name_cat = mysqli_fetch_array($res_art2);
		$req_t = "SELECT * FROM sly_categorie WHERE cid=".$name_cat['cid'];
		$res_t = mysqli_query($lien,$req_t);
		$titre_cat = mysqli_fetch_array($res_t);
		echo "<h3>".$titre_cat['name']."</h3>";
		?>
		<table class="table table-user-information">
	  	<thead>
	  		<tr>
	  			<th>Titre</th>
	  			<th>Auteur</th>
	  			<th>Posté le</th>
	  			<th class="text-center">Commentaires</th>
	  		</tr>
	  	</thead>
      <tbody>
    <?php
		$req2 = "SELECT * FROM appartient WHERE cid=".$catid;
		$res_art = mysqli_query($lien,$req2);
		while ($array_art_com = mysqli_fetch_array($res_art)){
			$art_com = $array_art_com['aid'];
			$req = "SELECT * FROM sly_article WHERE aid=$art_com ORDER BY date_public DESC";
			$res = mysqli_query($lien,$req);

			$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
			while ($array_art = mysqli_fetch_array($res)) {

				//Vérif compteur de commentaire
				$req = "SELECT count(*) AS nbcom FROM sly_comment WHERE aid=".$array_art['aid'];
				$res2 = mysqli_query($lien,$req);
				$array_com = mysqli_fetch_array($res2);

				list($date_complete, $heure) = explode(' ', $array_art['date_public']);
			  list($annee, $mois, $jour) = explode('-', $date_complete);
			    $mois = str_replace('0','',$mois);
			    $date_actus = $jour. ' '.$mois_fr[$mois].' '.$annee;
				?>
      	<tr>
      		<td><?php echo "<a href='index.php?comment=".$array_art['aid']."'>".$array_art['titre']."</a>"; ?></td>
      		<td><?php echo "<a href='profil.php?user=".$array_art['auteur']."'>".$array_art['auteur']."</a>"; ?></td>
      		<td><?php echo $date_actus; ?></td>
      		<td class="text-center"><?php echo "<span class='badge'>".$array_com['nbcom']."</span>"; ?></td>
      	</tr>

<?php
		  }
		}
		echo "</tbody></table>";
	}
	
	$req ="SELECT * FROM sly_categorie WHERE cid_1=".$catid;
	$res_cid = mysqli_query($lien,$req);
	while ($array_cid = mysqli_fetch_array($res_cid)) {

		$req = "SELECT count(*) FROM appartient WHERE cid =".$array_cid['cid'];

		$res = mysqli_query($lien,$req);
		$array_count = mysqli_fetch_array($res);

		if (($array_count = $array_count[0]) == 0) {
			echo "<br><div class='alert alert-danger'><strong>Attention !</strong> Aucun article trouvé dans la/les sous catégorie(s).</div>";
		}
		else {
			$req_c = "SELECT * FROM appartient WHERE cid=".$array_cid['cid'];
			$res_art2 = mysqli_query($lien,$req_c);
			$name_cat = mysqli_fetch_array($res_art2);
			$req_t = "SELECT * FROM sly_categorie WHERE cid=".$name_cat['cid'];
			$res_t = mysqli_query($lien,$req_t);
			$titre_cat = mysqli_fetch_array($res_t);
			echo "<h3>".$titre_cat['name']."</h3>";
			?>
		<table class="table table-user-information">
	  	<thead>
	  		<tr>
	  			<th>Titre</th>
	  			<th>Auteur</th>
	  			<th>Posté le</th>
	  			<th class="text-center">Commentaires</th>
	  		</tr>
	  	</thead>
      <tbody>
    <?php
			$req2 = "SELECT * FROM appartient WHERE cid=".$array_cid['cid'];
			$res_art = mysqli_query($lien,$req2);
			while ($array_art_com = mysqli_fetch_array($res_art)){
				$art_com = $array_art_com['aid'];
				$req = "SELECT * FROM sly_article WHERE aid=$art_com ORDER BY date_public DESC";
				$res = mysqli_query($lien,$req);

				$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
				while ($array_art = mysqli_fetch_array($res)) {

					//Vérif compteur de commentaire
					$req = "SELECT count(*) AS nbcom FROM sly_comment WHERE aid=".$array_art['aid'];
					$res2 = mysqli_query($lien,$req);
					$array_com = mysqli_fetch_array($res2);

					list($date_complete, $heure) = explode(' ', $array_art['date_public']);
				  list($annee, $mois, $jour) = explode('-', $date_complete);
				  $mois = str_replace('0','',$mois);
				  $date_actus = $jour. ' '.$mois_fr[$mois].' '.$annee;

				    ?>
      	<tr>
      		<td><?php echo "<a href='index.php?comment=".$array_art['aid']."'>".$array_art['titre']."</a>"; ?></td>
      		<td><?php echo "<a href='profil.php?user=".$array_art['auteur']."'>".$array_art['auteur']."</a>"; ?></td>
      		<td><?php echo $date_actus; ?></td>
      		<td class="text-center"><?php echo "<span class='badge'>".$array_com['nbcom']."</span>"; ?></td>
      	</tr>

<?php
			  }
			}
			echo "</tbody></table>";
		}
	}
}
?>