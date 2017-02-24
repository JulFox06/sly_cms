<?php
session_start();
if ($_SESSION['login'] == "" | $_SESSION['groupe'] == "Visiteur") {
	header('Location:../login.php');
}
include '../../contents/sly_config.php';
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
	$active = 'index';
	include 'inc/menu_v.php';
	?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="panel panel-teal panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-3 widget-left">
							<i class="fa fa-user-o" style="font-size: 50px"></i>
						</div>
						<div class="col-sm-9 col-lg-9 widget-right">
							<?php
							$req = "SELECT count(*) AS nb FROM sly_user";
							$res = mysqli_query($lien, $req);
							$user = mysqli_fetch_array($res);
							echo '<div class="large">'.$user['nb'].'</div>';
							?>
							<div class="text-muted">Utilisateurs</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-3 widget-left">
							<i class="fa fa-list-ul" style="font-size: 50px"></i>
						</div>
						<div class="col-sm-9 col-lg-9 widget-right">
							<?php
							$req = "SELECT count(*) AS nb FROM sly_article";
							$res = mysqli_query($lien, $req);
							$art = mysqli_fetch_array($res);
							echo '<div class="large">'.$art['nb'].'</div>';
							?>
							<div class="text-muted">Articles</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-4">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-3 widget-left">
							<i class="fa fa-commenting-o" style="font-size: 50px"></i>
						</div>
						<div class="col-sm-9 col-lg-9 widget-right">
							<?php
							$req = "SELECT count(*) AS nb FROM sly_comment";
							$res = mysqli_query($lien, $req);
							$comment = mysqli_fetch_array($res);
							echo '<div class="large">'.$comment['nb'].'</div>';
							?>
							<div class="text-muted">Commentaires</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->

	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
</body>

</html>
