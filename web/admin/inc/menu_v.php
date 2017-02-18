<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<ul class="nav menu">
		<?php
		function active($url)
		{
			$tab = explode("/", $_SERVER["PHP_SELF"]);
			$tab = $tab[count($tab)-1];
		  if ($tab == $url)
		  {
		    echo ' class="active"';
		  }
		}
		?>
		<li role="presentation" class="divider"></li>
		<?php
		if ($_SESSION['groupe'] == 'Rédacteur') {
			?>
			<li<?php active('index.php'); ?>><a href="index.php"><i class="fa fa-laptop"></i> Dashboard</a></li>
			<li<?php active('messagerie.php'); ?>><a href="messagerie.php"><i class="fa fa-comments"></i> Messagerie</a></li>
			<?php
		}
		else{
			?>
			<li<?php active('index.php'); ?>><a href="index.php"><i class="fa fa-laptop"></i> Dashboard</a></li>
			<li<?php active('users.php'); ?>><a href="users.php"><i class="fa fa-users"></i> Utilisateurs</a></li>
			<li<?php active('articles.php'); ?>><a href="articles.php"><i class="fa fa-folder-open"></i> Articles</a></li>
			<li<?php active('categorie.php'); ?>><a href="categorie.php"><i class="fa fa-list"></i> Catégories</a></li>
			<li<?php active('messagerie.php'); ?>><a href="messagerie.php"><i class="fa fa-comments"></i> Messagerie</a></li>
			<?php
			if ($_SESSION['groupe'] == 'Administrateur') {
				?>
				<li role="presentation" class="divider"></li>
				<li<?php active('config.php'); ?>><a href="config.php"><i class="fa fa-cogs"></i> Configuration</a></li>
				<li<?php active('droit.php'); ?>><a href="droit.php"><i class="fa fa-drivers-license-o"></i> Gestion des droits</a></li>
				<?php
			}
		}
		?>
		<li role="presentation" class="divider"></li>
	</ul>
</div>