<?php
session_start();
if ($_SESSION['login'] == "" | $_SESSION['groupe'] == "Visiteur") {
	header('Location:../login.php');
}
include '../../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);

if (isset($_POST['submit'])) {
	$body = $_POST['body'];
	$query = "INSERT INTO `sly_message` VALUES (NULL,'".$_SESSION['uid']."','".$_GET['msg']."','".$body."', '".date('Y-m-d H:s:i')."')";
	mysqli_query($lien, $query) or die("Erreur SQL : $query <br>".mysqli_error($lien));
}
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
	$active = 'messagerie';
	include 'inc/menu_v.php';
	?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-sm-4">
				<div class="panel panel-default" style="overflow-y: scroll;	height: 465px;">
					<div class="panel-heading" id="accordion"><i class="fa fa-comments-o"></i> Messagerie</div>
					<div class="panel-body">
						<ul class="nav menu">
					<?php
					$req = "SELECT * FROM sly_user WHERE (groupe='Administrateur' OR groupe='Modérateur' OR groupe='Rédacteur') AND (login!='".$_SESSION['login']."')";
					$res = mysqli_query($lien,$req);
					while ($contact = mysqli_fetch_array($res)) {
						echo '<li>';
						echo '<a href="?msg='.$contact['uid'].'">
									<strong class="primary-font">'.$contact['nom'].' '.$contact['prenom'].'</strong> <small class="text-muted">'.$contact['login'].' ('.$contact['groupe'].')</small>
								</a>';
						echo '</li>';
					}
					?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default chat">
						<?php
						$EXPORT = NULL;					// variable d affichage finale

						if (isset($_GET['msg']) && !empty($_GET['msg'])) {
							if ($_GET['msg'] == $_SESSION['uid']) {
								require_once("msg/default.php");
							}
							else{
								require_once("msg/message.php");
							}
						}
						else {
							require_once("msg/default.php"); // page par defaut homesite
						}
						ECHO $EXPORT;
						?>				
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->
</body>

</html>
