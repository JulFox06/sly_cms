<?php
session_start();
include '../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<head>
	<title><?php echo $array_config['titre'];?> | Connexion</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="assets/fox-logo.png">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Latest compiled and minified JavaScript -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/css/style1.css">

</head>

<body>
<?php
include 'inc/menu.php';
?>

<div class="container">
	<div class="col-sm-6 col-sm-offset-3 text-center bg_white">
	  <form method="post" action="login.php" class="form-signin">       
	    <h2 class="form-signin-heading">Connexion</h2>
	    <input type="text" class="form-control" name="login" placeholder="Login" required="" autofocus="" />
	    <input type="password" class="form-control" name="password" placeholder="Mot de passe" required=""/>
	    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Se connecter</button>
	  </form>
	  <?php
			if(isset($_POST['submit'])) {
				$login = trim(htmlentities(mysqli_real_escape_string($lien,$_POST['login'])));
      	$password = md5($_POST['password']);

				$req = "SELECT * FROM sly_user WHERE login='$login' AND mdp='$password'";
				$res = mysqli_query($lien,$req);
				if(!$res){
					echo "Erreur SQL : $req <br>".mysqli_error($lien);
				}
				else{
					$correct = mysqli_num_rows($res);
					if($correct==1) {
						$tab = mysqli_fetch_array($res);
						session_start();
						$_SESSION['uid'] = $tab['uid'];
						$_SESSION['login'] = $tab['login'];
						$_SESSION['nom'] = $tab['nom'];
						$_SESSION['prenom'] = $tab['prenom'];
						$_SESSION['mail'] = $tab['mail'];
						$_SESSION['groupe'] = $tab['groupe'];
						$_SESSION['born'] = $tab['born'];
						$_SESSION['register'] = $tab['register'];
						$_SESSION['sexe'] = $tab['sexe'];

						header("Location:../web");

					}else echo "Login ou mot de passe incorrect.";
				}
			}
    ?>
	</div>
</div>
<?php
include 'inc/footer.php';
?>
</body>
</html>
