<?php
session_start();
if ($_SESSION['login'] =="") {
	header("Location:../web");
}
include '../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<head>
	<title><?php echo $array_config['titre'];?> | Profil</title>

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
  <div class="row content">
    <div class="bg_white col-sm-8 col-sm-offset-2">
    <?php
    if (isset($_GET['user'])) {
    	$user = $_GET['user'];
    	$req = "SELECT * FROM sly_user WHERE login='$user'";
    	$res = mysqli_query($lien,$req);
    	$profil = mysqli_fetch_array($res);

    	$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
			list($annee, $mois, $jour) = explode('-', $profil['born']);
			$mois = str_replace('0','',$mois);
			$born = $jour. ' '.$mois_fr[$mois].' '.$annee;

			list($annee2, $mois2, $jour2) = explode('-', $profil['register']);
			$mois2 = str_replace('0','',$mois2);
			$register = $jour2. ' '.$mois_fr[$mois2].' '.$annee2;
    	?>
    	<h1 class="text-center">Profil de <?php echo $user;?></h1>
	    <div class="col-sm-12 col-sm-offset-0 toppad" >
	      <div class="panel panel-primary">
	        <div class="panel-heading">
	          <h3 class="panel-title"><?php echo $profil['nom']." ".$profil['prenom'];?></h3>
	        </div>
	        <div class="panel-body">
	          <div class="row">
	            <div class="col-md-3 col-lg-3 " align="center">
	            <?php
	            if ($profil['sexe'] == 'F') {
	            	echo '<img alt="User Pic" src="profil_img/woman.png" class="img-circle img-responsive">';
	            }
	            else {
	            	echo '<img alt="User Pic" src="profil_img/boss.png" class="img-circle img-responsive">';
	            }
	            ?>
	            </div>
	            <div class=" col-md-9"> 
	              <table class="table table-user-information">
	                <tbody>
	                	<tr>
	                		<td>Login :</td>
	                		<td><?php echo $profil['login'];?></td>
	                	</tr>
	                  <tr>
	                    <td>Rang :</td>
	                    <td><?php echo $profil['groupe'];?></td>
	                  </tr>
	                  <tr>
	                    <td>Date d'inscription :</td>
	                    <td><?php echo $register;?></td>
	                  </tr>
	                  <tr>
	                    <td>Date d'anniversaire :</td>
	                    <td><?php echo $born;?></td>
	                  </tr>
	               
	                  <tr>
	                    <tr>
		                    <td>Sexe :</td>
		                    <td>
		                    <?php
		                    if ($profil['sexe'] == 'F') {
		                    	echo "Femme";
		                    }
		                    else {
		                    	echo "Homme";
		                    }
		                    ?>	
		                    </td>
		                  </tr>
		                  <?php
		                  if (($_SESSION['groupe'] == 'Administrateur') || ($_SESSION['groupe'] == 'Modérateur')) {
		                  	?>
		                  <tr>
		                    <td>Email</td>
		                    <td>
		                    <?php
		                    echo '<a href="mailto:'.$profil['mail'].'">'.$profil['mail'].'</a>';
		                    ?>
		                    </td>
		                  </tr>
		                  	<?php
		                  }
		                  ?>
		                  
	                  </tr>
	                </tbody>
	              </table>
	            </div>
	          </div>
	        </div>
	      </div>
	      <!-- AFFICHAGE DES ARTICLES -->
	      <div class="panel panel-primary">
	        <div class="panel-heading">
	          <h3 class="panel-title">Ses articles</h3>
	        </div>
	        <div class="panel-body">
	          <div class="row">
	            <div class=" col-md-12"> 
	              <table class="table table-user-information">
	                <tbody>
	                	<tr>
	                		<th>Catégorie</th>
	                		<th>Titre</th>
	                	</tr>
	                	<?php
	                	$req = "SELECT * FROM sly_article WHERE auteur='".$profil['login']."'";
	                	$res2 = mysqli_query($lien,$req);
	                	while ($article = mysqli_fetch_array($res2)) {
	                		//Vérif nom catégorie
											$req = "SELECT * FROM appartient WHERE aid=".$article['aid'];
											$res3 = mysqli_query($lien,$req);
											$array_cat = mysqli_fetch_array($res3);

											$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat['cid'];
											$res4 = mysqli_query($lien,$req);
											$array_cat_s_name = mysqli_fetch_array($res4);

											$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat_s_name['cid_1'];
											$res5 = mysqli_query($lien,$req);
											$array_cat_name = mysqli_fetch_array($res5);

	                		echo "<tr>";
	                		if ($array_cat_s_name['cid_1'] == NULL) {
												echo "<td><span class='label label-primary'>".$array_cat_s_name['name']."</span></td>";
											}
											else {
												echo "<td><span class='label label-primary'>".$array_cat_name['name']."</span> <span class='label label-info'>".$array_cat_s_name['name']."</span></td>";
											}
	                		echo "<td><a href='index.php?comment=".$article['aid']."'>".$article['titre']."</a></td>";
	                		echo "</tr>";
	                	}
	                	?>
	                </tbody>
	              </table>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  <?php
    }
    else {
    	$mois_fr = Array("", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
			list($annee, $mois, $jour) = explode('-', $_SESSION['born']);
			$mois = str_replace('0','',$mois);
			$born = $jour. ' '.$mois_fr[$mois].' '.$annee;

			list($annee2, $mois2, $jour2) = explode('-', $_SESSION['register']);
			$mois2 = str_replace('0','',$mois2);
			$register = $jour2. ' '.$mois_fr[$mois2].' '.$annee2;
    ?>
    <h1 class="text-center">Votre profil</h1>
    <div class="col-sm-12 col-sm-offset-0 toppad" >
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $_SESSION['nom']." ".$_SESSION['prenom'];?></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-3 col-lg-3 " align="center">
            <?php
            if ($_SESSION['sexe'] == 'F') {
            	echo '<img alt="Avatar" src="profil_img/woman.png" class="img-circle img-responsive">';
            }
            else {
            	echo '<img alt="Avatar" src="profil_img/boss.png" class="img-circle img-responsive">';
            }
            ?>
            </div>
            <div class=" col-md-9"> 
              <table class="table table-user-information">
                <tbody>
                	<tr>
                		<td>Login :</td>
                		<td><?php echo $_SESSION['login'];?></td>
                	</tr>
                  <tr>
                    <td>Rang :</td>
                    <td><?php echo $_SESSION['groupe'];?></td>
                  </tr>
                  <tr>
                    <td>Date d'inscription :</td>
                    <td><?php echo $register;?></td>
                  </tr>
                  <tr>
                    <td>Date d'anniversaire :</td>
                    <td><?php echo $born;?></td>
                  </tr>
               
                  <tr>
                    <tr>
	                    <td>Sexe :</td>
	                    <td>
	                    <?php
	                    if ($_SESSION['sexe'] == 'F') {
	                    	echo "Femme";
	                    }
	                    else {
	                    	echo "Homme";
	                    }
	                    ?>	
	                    </td>
	                  </tr>
	                  <tr>
	                    <td>Email</td>
	                    <td>
	                    <?php
	                    echo '<a href="mailto:'.$_SESSION['mail'].'">'.$_SESSION['mail'].'</a>';
	                    ?>
	                    </td>
	                  </tr>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="panel-footer">
          <a class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
          <span class="pull-right">
	          <a href="edituser.php" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
	          <a href="deluser.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
          </span>
        </div>
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Vos articles</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class=" col-md-12"> 
              <table class="table table-user-information">
                <tbody>
                	<tr>
                		<th>Catégorie</th>
                		<th>Titre</th>
                	</tr>
                	<?php
                	$req = "SELECT * FROM sly_article WHERE auteur='".$_SESSION['login']."'";
                	$res2 = mysqli_query($lien,$req);
                	while ($article = mysqli_fetch_array($res2)) {
                		//Vérif nom catégorie
										$req = "SELECT * FROM appartient WHERE aid=".$article['aid'];
										$res3 = mysqli_query($lien,$req);
										$array_cat = mysqli_fetch_array($res3);

										$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat['cid'];
										$res4 = mysqli_query($lien,$req);
										$array_cat_s_name = mysqli_fetch_array($res4);

										$req = "SELECT * FROM sly_categorie WHERE cid=".$array_cat_s_name['cid_1'];
										$res5 = mysqli_query($lien,$req);
										$array_cat_name = mysqli_fetch_array($res5);

                		echo "<tr>";
                		if ($array_cat_s_name['cid_1'] == NULL) {
											echo "<td><span class='label label-primary'>".$array_cat_s_name['name']."</span></td>";
										}
										else {
											echo "<td><span class='label label-primary'>".$array_cat_name['name']."</span> <span class='label label-info'>".$array_cat_s_name['name']."</span></td>";
										}
                		echo "<td><a href='index.php?comment=".$article['aid']."'>".$article['titre']."</a></td>";
                		echo "</tr>";
                	}
                	?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    }
    ?>
  	</div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>
</body>
</html>
