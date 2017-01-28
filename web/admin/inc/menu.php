<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><span><?php echo $array_config['titre'];?></span>Admin</a>
			<ul class="user-menu">
				<li class="dropdown pull-right">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo $_SESSION['login'];?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="../profil.php"> Profil</a></li>
						<li><a href="#"> Paramétres</a></li>
						<li><a href="../logout.php"> Déconnexion</a></li>
					</ul>
				</li>
			</ul>
		</div>
						
	</div><!-- /.container-fluid -->
</nav>