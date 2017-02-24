<!DOCTYPE html>
<head>
	<title>Sly CMS | Installation</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="../assets/fox-logo.png">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">

	<script type="text/javascript">
  $(document).ready(function(){

    function getQuerystring(key, default_) {
      if (default_==null) default_="";
      key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
      var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
      var qs = regex.exec(window.location.href);
      if(qs == null) return default_; else return qs[1];
    }

    var contenu = $("#contenu");
    var form = $("#formulaire");
    var suite = $("#suite");
    var step = getQuerystring('step');

    function test1(){
      contenu.append("<p>Pour la suite, il nous reste quelques informations à savoir afin de pouvoir vous rendre un site web fonctionnel dès maintenant.</p>");
      form.append("<p>Veuillez remplir ces champs correctement.</p>");
      form.append("<label for='title'>Titre de votre site :</label><input type='text' name='title' required><br>");
      form.append("<label for='nom_admin'>Nom  :</label><input type='text' name='nom_admin' required><br>");
      form.append("<label for='prenom_admin'>Prénom :</label><input type='text' name='prenom_admin' required><br>");
      form.append("<label for='mail_admin'>Adresse mail :</label><input type='mail' name='mail_admin' required><br>");
      form.append("<label for='tel_admin'>Téléphone :</label><input type='phone' name='tel_admin' required><br>");
      form.append("<label for='login_admin'>Login :</label><input type='text' name='login_admin' required><br>");
      form.append("<label for='mdp_admin'>Mot de passe :</label><input type='password' name='mdp_admin' required><br>");
      form.append("<label for='mdp_admin2'>Recopier le mot de passe :</label><input type='password' name='mdp_admin2' required><br>");
      form.append("<label for='sexe' class='text_center'>Votre sexe :</label><br>");
      form.append("<label class='rad'><input type='radio' name='sexe' value='H' checked/><i></i> Homme</label><label class='rad'><input type='radio' name='sexe' value='F' /><i></i> Femme</label><br>");
      form.append("<label for='theme' class='text_center'>Thème de votre site :</label><br>");
      form.append("<label class='rad'><input type='radio' name='theme' value='1' checked/><i></i> Défaut</label><label class='rad'><input type='radio' name='theme' value='2' /><i></i> Journal</label><label class='rad'><input type='radio' name='theme' value='3'/><i></i> Yéti</label><label class='rad'><input type='radio' name='theme' value='4' /><i></i> Simplex</label><br>");
      form.append("<label for='description' class='text_center'>Description de votre site :</label><br><textarea name='description' required></textarea><br>");

      form.append("<input type='submit' name='valider' value='Suivant'>");
    }      

    test1();
  });
  </script>


</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="page">
					<img style="width: 80px;" src="../assets/fox-logo.png">
					<span>Configuration de votre site</span>
					<div id="contenu"></div>
          <form method="post" action="config_web.php">
            <div id="formulaire"></div>
          </form>
<?php
if (isset($_POST['valider'])) {
  if ($_POST['mdp_admin']==$_POST['mdp_admin2']) {
    include '../contents/sly_config.php';
    $title = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['title'])));
    $nom = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['nom_admin'])));
    $prenom = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['prenom_admin'])));
    $sexe = $_POST['sexe'];
    $mail_admin = trim($_POST['mail_admin']);
    $tel_admin = trim($_POST['tel_admin']);
    $login_admin = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['login_admin'])));
    $mdp_admin = md5($_POST['mdp_admin']);
    $theme = $_POST['theme'];
    $description = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['description'])));

    $req = "INSERT INTO sly_config VALUES(NULL,'$title','$mail_admin','$tel_admin','$theme','$description')";
    $res = mysqli_query($lien,$req);
    if (!$res) {
      echo "Erreur SQL : $req <br>".mysqli_error($lien);
    }
    else{
      $req = "INSERT INTO sly_user VALUES(NULL,'$nom' ,'$prenom' ,'$login_admin','$mail_admin','$mdp_admin',NULL,'".date('Y-m-d H:i:s')."','Administrateur','$sexe')";
      $res = mysqli_query($lien,$req);
      if (!$res) {
        echo "Erreur SQL : $req <br>".mysqli_error($lien);
      }
      else{
        echo "Configuration terminée";
        header("Location:config_end.php");
      }
    }
  }
  else{
    echo "Mots de passe non identiques.";
  }
  mysqli_close($lien);
}
?>
          <div id="suite"></div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
