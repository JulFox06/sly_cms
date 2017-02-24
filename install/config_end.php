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
		$(document).on("click", "#fin", function(){
	      window.location = "../web/login.php";
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
					<div id="contenu">
            <p>Votre configuration est désormais terminée !</p>
            <p>Pour votre première connexion, il vous est recommandé de prendre connaissance avec l'interface administrateur. Merci d'avoir choisi "Sly CMS" pour la création de votre site Web.</p>
            <p class="note">Note : si le site est en ligne, veuillez supprimer le répertoire <strong>/install</strong> du ftp.</p>
          </div>
          <form method="post" action="config_web.php">
            <div id="formulaire"></div>
          </form>
          <div id="suite">
            <input type='button' id='fin' name='fin' value='Terminer'>
          </div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
