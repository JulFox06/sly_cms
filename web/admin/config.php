<?php
session_start();
if ($_SESSION['login'] == "" | $_SESSION['groupe'] == "Visiteur" | $_SESSION['groupe'] == "Modérateur" | $_SESSION['groupe'] == "Rédacteur") {
	header('Location:../');
}

include '../../contents/sly_config.php';
$yes = "";

if (isset($_POST['envoi'])) {
	$titre = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['titre'])));
	$mail = $_POST['mail'];
	$tel = $_POST['tel'];
	$theme = $_POST['theme'];
	$desc = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['desc'])));

	$req = "UPDATE sly_config SET titre='$titre',admin_email='$mail',tel_admin='$tel',theme='$theme',description='$desc' WHERE cnfid='1'";
  $res = mysqli_query($lien,$req);
  if (!$res) {
    echo "Erreur SQL : $req <br>".mysqli_error($lien);
  }
  else{
    $yes = '<div class="alert bg-success" role="alert"><i class="fa fa-check"></i> Configuration du CMS modifiée avec succès !</div>';
  }
}


$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<head>
	<title><?php echo $array_config['titre'];?> | Administration</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="../assets/fox-logo.png">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Latest compiled and minified JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

</head>

<body>
	<?php
	include 'inc/menu.php';
	include 'inc/menu_v.php';
	?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Configuration du CMS</h1>
				<?php
				echo $yes;
				?>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-6">
				<form method="post" action="config.php">
				
					<div class="form-group">
						<label>Titre du site</label>
						<input class="form-control" type="text" name="titre" value="<?php echo $array_config['titre'];?>" required>
					</div>
					<div class="form-group">
						<label>Mail de l'administrateur</label>
						<input class="form-control" type="mail" name="mail" value="<?php echo $array_config['admin_email'];?>" required>
					</div>
					<div class="form-group">
						<label>Téléphone de l'administrateur</label>
						<input class="form-control" type="text" name="tel" value="<?php echo $array_config['tel_admin'];?>" required>
					</div>
					<div class="form-group">
						<label>Description du site</label>
						<textarea class="form-control" rows="3" name="desc" required><?php echo $array_config['description'];?></textarea>
					</div>
					
				</div>
				<div class="col-md-6">
					<?php
					
					function coche($value, $nb){
						//$nb = 4;
					  if ($value == $nb){
					    echo 'checked';
					  }
					}
					?>
					<div class="form-group">
						<label>Choix du thème</label>
						<div class="radio">
							<label>
								<input type="radio" name="theme" id="theme1" value="1" <?php coche('1',$array_config['theme']);?>>Thème 1 (défaut)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="theme" id="theme2" value="2" <?php coche('2',$array_config['theme']); ?>>Thème 2 (journal)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="theme" id="theme3" value="3" <?php coche('3',$array_config['theme']); ?>>Thème 3 (yeti)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="theme" id="theme4" value="4" <?php coche('4',$array_config['theme']); ?>>Thème 4 (simplex)
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="theme" id="theme5" value="5" <?php coche('5',$array_config['theme']); ?>>Thème 5 (superhero)
							</label>
						</div>
					</div>
					
					<input type="submit" class="btn btn-primary" name="envoi" value="Modifier">
					<input type="reset" class="btn btn-default" name="reset" value="Reset">
				</div>
			</form>
		</div><!--/.row-->
	</div>	<!--/.main-->

	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
</body>

</html>
