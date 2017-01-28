<?php
session_start();
if ($_SESSION['login'] == "") {
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

	<link rel="shortcut icon" href="assets/fox-logo.png">

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
	<?php include 'inc/menu.php';?>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li role="presentation" class="divider"></li>
			<li><a href="index.php"><i class="fa fa-laptop"></i> Dashboard</a></li>
			<li><a href="users.php"><i class="fa fa-users"></i> Utilisateurs</a></li>
			<li><a href="articles.php"><i class="fa fa-folder-open"></i> Articles</a></li>
			<li class="active"><a href="categorie.php"><i class="fa fa-list"></i> Catégories</a></li>
			<li><a href="messagerie.php"><i class="fa fa-comments"></i> Messagerie</a></li>
			<li role="presentation" class="divider"></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	</div>	<!--/.main-->

	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
</body>

</html>
