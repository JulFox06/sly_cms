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
	<title><?php echo $array_config['titre'];?> | Articles</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="assets/fox-logo.png">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/trumbowyg.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Latest compiled and minified JavaScript -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/trumbowyg.min.js"></script>
	<script type="text/javascript" src="assets/js/langs/fr.min.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/css/style1.css">
</head>

<body>
<?php
include 'inc/menu.php';
?>

<div class="container">
  <div class="row content">
    <div class="bg_white col-sm-8 col-sm-offset-2">
    <form method="post" action="new.php" class="form-signin">       
      <h2 class="form-signin-heading text-center">Rédiger un article</h2>
      <input type="text" class="form-control" name="titre" placeholder="Titre de l'article" required="" autofocus="" />
      <h3><small>Catégorie :</small></h3>
      <select name="categorie" class="form-control">
      <?php
      $req = "SELECT * FROM sly_categorie WHERE cid_1 IS NULL ORDER BY name";
      $res = mysqli_query($lien,$req);
      while ($cate = mysqli_fetch_array($res)) {
      	$req = "SELECT * FROM sly_categorie WHERE cid_1 = ".$cate['cid'];
        $fils = mysqli_query($lien,$req);
        $s_cate = mysqli_fetch_array($fils);
        if ($s_cate == NULL) {
        	echo "<option>".$cate['name']."</option>";
        }
        else {
        	echo "<option>".$cate['name']."</option>";
        	do {
        		echo "<option style='padding-left:30px'>".$s_cate['name']."</option>";
        	}while ($s_cate = mysqli_fetch_array($fils));
        }
      }
      ?>
      </select>
      <div id="editor" name="contenu"></div>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Poster</button>
    </form>
<?php
if (isset($_POST['submit'])) {
	$titre = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['titre'])));
	$categorie = $_POST['categorie'];
	$array_1 = array("'",'"');
	$array_2 = array("\'",'\"');
	$contenu_txt = $_POST['editor'];
	$contenu = str_replace($array_1 ,$array_2 , $contenu_txt);
	$login = $_SESSION['login'];

	$req = "SELECT count(*) AS ntitre FROM sly_article WHERE titre='$titre'";
	$res = mysqli_query($lien,$req);
	if (!$res) {
		echo "Erreur SQL : $req <br>".mysqli_error($lien);
	}
	else {
		$tab = mysqli_fetch_array($res);
		if ($tab['ntitre']==0) {
			$req = "SELECT * FROM sly_categorie WHERE name='$categorie'";
			$res = mysqli_query($lien,$req);
			$id_cate = mysqli_fetch_array($res);
			$id = $id_cate['cid'];

			$req = "INSERT INTO sly_article VALUES(NULL,'$titre','$login','".date('Y-m-d H:i:s')."',NULL,'$contenu','1')";
			$res2 = mysqli_query($lien,$req);
		  if (!$res2) {
		    echo "Erreur SQL : $req <br>".mysqli_error($lien);
		  }
		  else{
		  	$req = "SELECT * FROM sly_article WHERE titre = '$titre'";
	        $res3 = mysqli_query($lien,$req);
	        $id_article = mysqli_fetch_array($res3);
	        $id_art = $id_article['aid'];

		  	$req = "INSERT INTO appartient VALUES('$id_art','$id')";
				$res4 = mysqli_query($lien,$req);
				if (!$res4) {
			    echo "Erreur SQL : $req <br>".mysqli_error($lien);
			  }
			  else{
		    	header("Location:../web");
		    }
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
