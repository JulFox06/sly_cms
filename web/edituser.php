<?php
session_start();
if ($_SESSION['login'] == "") {
	header('Location:../web');
}
include '../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<head>
	<title><?php echo $array_config['titre'];?> | Paramètres</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="assets/fox-logo.png">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Latest compiled and minified JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/js/locales/bootstrap-datepicker.fr.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/css/style1.css">
</head>

<body>
<?php
include 'inc/menu.php';
?>

<?php
$ulogin = $_SESSION['login'];
$req = "SELECT * FROM sly_user WHERE login='$ulogin'";
$res = mysqli_query($lien,$req);
$modif = mysqli_fetch_array($res);
?>

<div class="container">
  <div class="row content">
    <div class="bg_white col-sm-8 col-sm-offset-2">
    <form method="post" action="edituser.php" class="form-signin">       
      <h2 class="form-signin-heading text-center">Réglages du profil</h2>
      <br>
      <?php
      echo '<div class="input-group"><div class="input-group-addon"><i class="fa fa-id-card"></i></div><input type="text" class="form-control" value="'.$modif['nom'].'" name="nom" placeholder="Nom" required="" /></div>';
      echo '<div class="input-group"><div class="input-group-addon"><i class="fa fa-id-card"></i></div><input type="text" class="form-control" value="'.$modif['prenom'].'" name="prenom" placeholder="Prénom" required="" /></div>';
      echo '<div class="input-group"><div class="input-group-addon">@</div><input type="mail" class="form-control" value="'.$modif['mail'].'" name="mail" placeholder="Mail" required="" /></div>';
      echo '<div class="input-group"><div class="input-group-addon"><i class="fa fa-birthday-cake"></i></div><input class="form-control" id="date" name="born" placeholder="YYYY-MM-DD" type="text" value="'.$modif['born'].'"/></div>';
      ?>
      <br>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Modifier</button>
    </form>
    
<?php
if (isset($_POST['submit'])) {
	$nom = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['nom'])));
	$prenom = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['prenom'])));
	$mail = trim($_POST['mail']);
	$born = $_POST['born'];

	$req = "SELECT count(*) AS nbmail FROM sly_user WHERE mail='$mail'";
	$res = mysqli_query($lien,$req);
	if (!$res) {
		echo "Erreur SQL : $req <br>".mysqli_error($lien);
	}
	else {
		$tab = mysqli_fetch_array($res);
		if ($mail == $_SESSION['mail']) {
			$req = "UPDATE sly_user SET nom='$nom',prenom='$prenom',born='$born' WHERE login='$ulogin'";
			$res2 = mysqli_query($lien,$req);
			if (!$res2) {
				echo "Erreur SQL : $req <br>".mysqli_error($lien);
			}
			else {
				$_SESSION['nom'] = $nom;
				$_SESSION['prenom'] = $prenom;
				$_SESSION['born'] = $born;
				echo '<script type="text/javascript">alert("Votre profil a bien été mis à jour."); location ="profil.php"</script>';
			}
		}
		else if ($tab['nbmail']==0) {
			$req = "UPDATE sly_user SET nom='$nom',prenom='$prenom',mail='$mail',born='$born' WHERE login='$ulogin'";
			$res2 = mysqli_query($lien,$req);
			if (!$res2) {
				echo "Erreur SQL : $req <br>".mysqli_error($lien);
			}
			else {
				$_SESSION['nom'] = $nom;
				$_SESSION['prenom'] = $prenom;
				$_SESSION['mail'] = $mail;
				$_SESSION['born'] = $born;
				echo '<script type="text/javascript">alert("Votre profil a bien été mis à jour."); location ="profil.php"</script>';
			}
		}
		else {
			echo '<div class="alert alert-danger"><strong>Erreur !</strong> L\'adresse mail est déjà utilisée.</div>';
		}
	}
}
?>
		<form method="post" action="edituser.php" class="form-signin">       
      <h3 class="form-signin-heading text-center">Sécurité du compte</h3>
      <br>
      <?php
      echo '<div class="input-group"><div class="input-group-addon"><i class="fa fa-shield"></i></div><input type="password" class="form-control" name="mdp" placeholder="Nouveau mot de passe" required="" /></div>';
      echo '<div class="input-group"><div class="input-group-addon"><i class="fa fa-shield"></i></div><input type="password" class="form-control" name="mdp2" placeholder="Confirmation mot de passe" required="" /></div>';
      ?>
      <br>
      <button class="btn btn-lg btn-danger btn-block" type="submit" name="submit2">Modifier</button>
    </form>
<?php
if (isset($_POST['submit2'])) {
	$mdp = $_POST['mdp'];
	$mdp2 = $_POST['mdp2'];

	if ($mdp != $mdp2) {
		echo '<div class="alert alert-danger"><strong>Erreur !</strong> Les mots de passe ne sont pas identiques.</div>';
	}
	else {
		$mdp = md5($_POST['mdp']);
		$req = "UPDATE sly_user SET mdp='$mdp' WHERE login='$ulogin'";
		$res2 = mysqli_query($lien,$req);
		if (!$res2) {
			echo "Erreur SQL : $req <br>".mysqli_error($lien);
		}
		else {
			echo '<script type="text/javascript">alert("Votre mot de passe a bien été mis à jour."); location ="profil.php"</script>';
		}
	}
}
mysqli_close($lien);
?>
    </div>
  </div>
</div>

<?php
include 'inc/footer.php';
?>

<script>
    $('#date').datepicker({
    	format: 'yyyy-mm-dd',
    	language: 'fr',
    	autoclose: 'true',
    	daysOfWeekDisabled: 'true',
    });
</script>

</body>
</html>
