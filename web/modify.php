<?php
session_start();
if ($_SESSION['login'] == "") {
	header('Location:../web');
}
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

<?php
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$req = "SELECT * FROM sly_article WHERE aid=$id";
	$res = mysqli_query($lien,$req);
	$modif = mysqli_fetch_array($res);
}
else {
	header("Location:../web");
}
?>

<div class="container">
  <div class="row content">
    <div class="bg_white col-sm-8 col-sm-offset-2">
    <form method="post" action="modify.php?id=<?php echo $id;?>" class="form-signin">       
      <h2 class="form-signin-heading text-center">Modifier un article</h2>
      <?php
      echo '<input type="text" class="form-control" value="'.$modif['titre'].'" name="titre" placeholder="Titre de l\'article" required="" autofocus="" />';
      ?>
      <div id="editor" name="contenu"><?php echo $modif['contenu'];?></div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Modifier</button>
    </form>
<?php
if (isset($_POST['submit'])) {
	$titre = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['titre'])));
	$array_1 = array("'",'"');
	$array_2 = array("\'",'\"');
	$contenu_txt = $_POST['editor'];
	$contenu = str_replace($array_1 ,$array_2 , $contenu_txt);

	$req = "SELECT count(*) AS ntitre FROM sly_article WHERE titre='$titre' AND aid!=$id";
	$res = mysqli_query($lien,$req);
	if (!$res) {
		echo "Erreur SQL : $req <br>".mysqli_error($lien);
	}
	else {
		$tab = mysqli_fetch_array($res);
		if ($tab['ntitre']==0) {
			$req = "UPDATE sly_article SET titre='$titre',contenu='$contenu' WHERE aid=$id";
			$res2 = mysqli_query($lien,$req);
			if (!$res2) {
				echo "Erreur SQL : $req <br>".mysqli_error($lien);
			}
			else {
				echo '<script type="text/javascript">alert("Votre article a bien été modifié."); location ="../web"</script>';
			}
		}
		else {
			echo "<p class='text-center'>Titre d'article déjà utilisé.</p>";
		}
	}
}
mysqli_close($lien);
?>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
	$("#editor").trumbowyg({
		lang: 'fr',
		btns: [
        ['viewHTML'],
        ['formatting'],
        'btnGrp-design',
        ['link'],
        ['insertImage'],
        'btnGrp-justify',
        'btnGrp-lists',
        ['removeformat'],
    ]
	});

  });
</script>
<?php
include 'inc/footer.php';
?>
</body>
</html>
