<?php
session_start();
if ($_SESSION['login'] == "") {
	header('Location:../web/login.php');
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
			<li><a href="categorie.php"><i class="fa fa-list"></i> Catégories</a></li>
			<li class="active"><a href="messagerie.php"><i class="fa fa-comments"></i> Messagerie</a></li>
			<li role="presentation" class="divider"></li>
		</ul>
	</div><!--/.sidebar-->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-sm-4">
				<div class="panel panel-default chat">
					<div class="panel-heading" id="accordion"><i class="fa fa-comments-o"></i> Messagerie</div>
					<div class="panel-body">
						<ul>
							<li class="left clearfix">
								<span class="chat-img pull-left">
									<img src="../profil_img/boss.png" alt="User Avatar" class="img-circle" />
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="primary-font">John Doe</strong> <small class="text-muted">32 mins ago</small>
									</div>
									<p>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida tortor aliquam ultricies. 
									</p>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default chat">
					<div class="panel-heading" id="accordion"><i class="fa fa-comment-o"></i> Chat</div>
					<div class="panel-body">
						<ul>
							<li class="">
								<div class="chat-body ">
									<div class="header">
										<strong class="primary-font">John Doe</strong> <small class="text-muted">32 mins ago</small>
									</div>
									<p>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida tortor aliquam ultricies. 
									</p>
								</div>
							</li>
							<li class="text-right">
								<div class="chat-body ">
									<div class="header">
										<strong class="primary-font">Jane Doe</strong> <small class="text-muted">6 mins ago</small>
									</div>
									<p>
										Mauris dignissim porta enim, sed commodo sem blandit non. Ut scelerisque sapien eu mauris faucibus ultrices. Nulla ac odio nisl. Proin est metus, interdum scelerisque quam eu, eleifend pretium nunc. Suspendisse finibus auctor lectus, eu interdum sapien.
									</p>
								</div>
							</li>
						</ul>
					</div>
					
					<div class="panel-footer">
						<div class="input-group">
							<input id="btn-input" type="text" class="form-control input-md" placeholder="Type your message here..." />
							<span class="input-group-btn">
								<button class="btn btn-success btn-md" id="btn-chat">Send</button>
							</span>
						</div>
					</div>
				</div>
				
			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->
</body>

</html>
