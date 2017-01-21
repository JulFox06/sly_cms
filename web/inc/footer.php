<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-6 footerleft ">
        <div class="logofooter"> <?php echo $array_config['titre'];?></div>
        <p><?php echo $array_config['description'];?></p>
        <p><i class="fa fa-map-pin"></i> </p>
        <p><i class="fa fa-phone"></i> Téléphone : </p>
        <p><i class="fa fa-envelope"></i> E-mail : <?php echo $array_config['admin_email'];?></p>
        
      </div>
      <div class="col-md-3 col-sm-6 paddingtop-bottom">
        <h6 class="heading7">LIENS UTILES</h6>
        <ul class="footer-ul">
          <li><a href="../web"> Accueil</a></li>
          <li><a href="#"> CGU</a></li>
          <li><a href="#"> Termes & Conditions</a></li>
          <li><a href="team.php"> L'équipe</a></li>
        </ul>
      </div>
      <div class="col-md-5 col-sm-6 paddingtop-bottom">
        <h6 class="heading7">DERNIERS COMMENTAIRES</h6>
        <div class="post">
        <?php
        $req = "SELECT * FROM sly_comment ORDER BY fid DESC LIMIT 0,3";
        $res_f = mysqli_query($lien,$req);
        while ($last_post = mysqli_fetch_array($res_f)) {
        	list($date_complete, $heure) = explode(' ', $last_post['date_post']);
			    list($annee, $mois, $jour) = explode('-', $date_complete);
			    $mois = str_replace('0','',$mois);
			    $post = $jour. ' '.$mois_fr[$mois].' '.$annee.' à '.$heure;

        	$req = "SELECT * FROM sly_article WHERE aid=".$last_post['aid'];
        	$res_c = mysqli_query($lien,$req);
        	$last_art = mysqli_fetch_array($res_c);
        	echo "<p>".$last_post['contenu']." ";
        	echo "<span>".$last_art['titre'].", le ".$post."</span>";
        }
        ?>
        </div>
      </div>

    </div>
  </div>
</footer>
<!--footer start from here-->

<div class="copyright">
  <div class="container">
    <div class="col-md-6">
      <p>© 2017 - Tout droits réservé avec Sly CMS</p>
    </div>
    <div class="col-md-6">
      <ul class="bottom_ul">
        <li><a href="http://julfox.fr">Sly CMS</a></li>
        <li><a href="#">Site Map</a></li>
      </ul>
    </div>
  </div>
</div>