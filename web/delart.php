<?php
session_start();
if ($_SESSION['login'] =="") {
	header("Location:../web");
}
include '../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);

$id = $_GET['id'];

$req = "SELECT count(*) FROM sly_article WHERE aid=$id AND auteur='".$_SESSION['login']."'";
$res = mysqli_query($lien,$req);
$result = mysqli_fetch_array($res);
if ((($result = $result[0]) != 0) OR ($_SESSION['groupe'] == 'Administrateur') OR ($_SESSION['groupe'] == 'Modérateur')) {
}
else {
  header("Location:../web");
}
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
    <h1 class="text-center">Supprimer un article</h1>
    <div class="col-sm-12 col-sm-offset-0 toppad" >
      <div class="panel panel-danger">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $_SESSION['nom']." ".$_SESSION['prenom'];?></h3>
        </div>
        <div class="panel-body">
          <div class="row">
          <h4 class="text-center">Êtes-vous sûr de vouloir supprimer cet article ?</h4>
          <?php echo "<form class='col-sm-6 col-sm-offset-3' action='delart.php?id=$id' method='post'>";?>
          	<input type="submit" class="btn btn-danger" name="no" value="Non">
          	<span class="pull-right">
          		<input type="submit" class="btn btn-success" name="yes" value="Oui">
          	</span>
          	<br><br>
          </form>
          <?php
          if (isset($_POST['no'])) {
            header("Location:../web");
          }
          if (isset($_POST['yes'])) {
            $req = "DELETE FROM appartient WHERE aid='".$id."'";
            $res = mysqli_query($lien,$req);
            $req = "DELETE FROM sly_article WHERE aid='".$id."'";
            $res = mysqli_query($lien,$req);
            if (!$res) {
              echo "Erreur SQL : $req <br>".mysqli_error($lien);
            }
            else {
              header("Location:../web");
            }
          }
          ?>
          </div>
        </div>
      </div>
    </div>
  	</div>
	</div>
</div>
<?php
include 'inc/footer.php';
?>
</body>
</html>
