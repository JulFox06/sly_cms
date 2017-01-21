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
      contenu.append("<p>Bienvenue sur Sly. Avant de commencer, quelques informations sur votre base de données sont nécessaires.</p>");
      contenu.append("<ol><li>Nom de la base de données</li><li>Nom d'utilisateur MySQL</li><li>Mot de passe de l'utilisateur</li><li>Adresse de la base de données</li></ol>");
      contenu.append("<p>Nous allons préparer les fichiers de configuration (que vous pourrez modifier par la suite) et nous avons besoin de ces informations.</p>")
      contenu.append("<p>Vous devriez avoir reçu toutes ces informations de la part de votre <b>hébergeur</b>. Contactez les si nécessaire. <b>On attend plus que vous pour commencer.</b></p>");
      contenu.append("<button id='ready'>Allons-y !</button>");
    }      

    function test2(){
      form.append("<p>Veuillez remplir ces champs correctement.</p>");
      form.append("<input type='hidden' name='etape' value='1' />");
      form.append("<label for='nom_bdd'>Nom de la base :</label><input type='text' name='nom_bdd' required><br>");
      form.append("<label for='nom_user'>Nom d'utilisateur :</label><input type='text' name='nom_user' required><br>");
      form.append("<label for='mdp_user'>Mot de passe utilisateur :</label><input type='text' name='mdp_user'><br>");
      form.append("<label for='host_bdd'>Adresse de la base :</label><input type='text' name='host_bdd' required><br>");
      form.append("<p>Nous allons mettre le préfixe '<b><i>sly_</i></b>' devant chaque fichiers et nom de table afin de faciliter votre navigation.</p>");

      form.append("<input type='submit' name='valider' value='Suivant'>");
    }

    function test3(){
      form.empty();
      suite.append("<input type='button' id='next' name='suite' value='Suivant'>");
    }

    function test4(){
      contenu.append("<p>Nous pouvons désormais communiquer avec votre base de données. On continue ?</p>");
      form.append("<input type='button' id='continue' name='continue' value='Continuer'>");
    }


    $(document).on("click", "#ready", function(){
      contenu.empty();
      test2();
    });

    $(document).on("click", "#next", function(){
      window.location = "config.php?step=4";
    });

    $(document).on("click", "#continue", function(){
      window.location = "config_web.php?step=1&login=&mdp=";
    });


    if (step == 3) {
      test3();
    }
    else if (step == 4) {
      test4();
    }
    else {
      test1();
    }
  });
  </script>


</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="page">
					<img style="width: 80px;" src="../assets/fox-logo.png">
					<span>Installation du Sly CMS</span>
					<div id="contenu"></div>
          <form method="post" action="config.php?step=3">
            <div id="formulaire"></div>
          </form>
<?php
if(isset($_POST['valider'])) {

  define('RETOUR', '<br /><br /><input type="button" value="Retour" onclick="history.back()">');
  define('OK', '<p class="ok">OK</p><br />');
  define('ECHEC', '<p class="echec">ECHEC</p>');

  $configfile = "../contents/sly_config.php";
  if(file_exists($configfile) AND filesize($configfile) > 0) {
  exit('<p>Fichier de configuration déjà existant. Installation interrompue.</p>'. RETOUR);
  } 

  $hote = trim($_POST['host_bdd']);
  $login = trim($_POST['nom_user']);
  $mdp = trim($_POST['mdp_user']);
  $base = trim($_POST['nom_bdd']);

  $lien = mysqli_connect($hote, $login, $mdp);
  if(!mysqli_connect($hote, $login, $mdp)) {
  exit('<p>Mauvais paramètres de connexion.</p>'. RETOUR);
  }

  if(!mysqli_select_db($lien, $base)) {
  exit('<p>Mauvais nom de base.</p>'. RETOUR);
  } 

  $texte = '<?php
  $hote   = "'. $hote .'";
  $login  = "'. $login .'";
  $mdp    = "'. $mdp .'";
  $base   = "'. $base .'";

  $prefix = "sly_";

  $lien = mysqli_connect($hote,$login,$mdp);
  mysqli_select_db($lien, $base);
  mysqli_set_charset($lien,"utf8");
  ?>';

  if(!$ouvrir = fopen($configfile, 'w')) {
  exit('<p>Impossible d\'ouvrir le fichier : <strong>'. $configfile .'</strong>.</p>'. RETOUR);
  }

  if(fwrite($ouvrir, $texte) == FALSE) {
  exit('<p>Impossible d\'écrire dans le fichier : <strong>'. $configfile .'</strong>.</p>'. RETOUR);
  }

  echo '<p>Fichier de configuration : </p>'. OK;
  fclose($ouvrir); 
    

  $requetes = '';
   
  $sql = file('../contents/base.sql');
  foreach($sql as $lecture) {
    if(substr(trim($lecture), 0, 2) != '--') {
    $requetes .= $lecture;
    }
  }
   
  $reqs = preg_split("/;/", $requetes);
  foreach($reqs as $req){
    if(!mysqli_query($lien, $req) AND trim($req) != '') {
      exit('ERREUR : '. $req);
    }
  }
  echo '<p>Installation : <p>'. OK; 
}
?>
          <div id="suite"></div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
