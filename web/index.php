<?php
session_start();
include '../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<head>
	<?php include 'inc/head.php';?>

</head>

<body>
<?php
include 'inc/menu.php';
?>

<div class="container">
  <div class="row content">
  	<?php 
  	if (($_SESSION['login'] != "") && (!isset($_GET['comment']))) {
  		echo "<div class='bg_white text-center col-sm-8 col-sm-offset-2' style='margin-bottom:20px;'>";
  		echo "<h1>Bonjour <i>".$_SESSION['nom']." ".$_SESSION['prenom']."</i>.<br>";
  		if ($_SESSION['groupe'] != "Visiteur") {
  			echo "<small>Créez un nouvel article !</small></h1>";
  			echo "<a href='new.php' class='btn btn-md btn-info' style='margin-bottom:10px;'>Nouvel article</a>";
  		}
  		else {
  			echo "</h1>";
  		}
  		echo "</div>";
  	}
  	?>
    <div class="bg_white col-sm-8 col-sm-offset-2">
    <?php

    if (isset($_GET['page'])) {
			$page = $_GET['page'];
		}
		else{
			$page = 1;
		}

		$parpage = 3;
		$premier = $parpage*($page-1);

    $login = $_SESSION['login'];

    if (isset($_GET['comment'])) {
    	include 'inc/comment.php';
    }
    else if ((isset($_GET['cat'])) || (isset($_GET['cats']))) {
      include 'inc/categorie.php';
    }
    else {
    	include 'inc/article.php';
      include 'inc/page.php';
		}
		
    ?>
  </div>
</div>
</div>
<br><br>
<?php
include 'inc/footer.php';
mysqli_close($lien);
?>
</body>
</html>
