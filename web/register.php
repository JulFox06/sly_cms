<?php
session_start();

if ($_SESSION['login'] != "") {
  header("Location:../web");
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

<div class="container">
  <div class="col-sm-6 col-sm-offset-3 text-center bg_white">
    <form method="post" action="register.php" class="form-signin">       
      <h2 class="form-signin-heading">Inscription</h2>
      <input type="text" class="form-control" name="nom" placeholder="Nom" required="" autofocus="" />
      <input type="text" class="form-control" name="prenom" placeholder="Prénom" required=""/>
      <input type="text" class="form-control" name="login" placeholder="Login" required=""/>
      <input type="mail" class="form-control" name="mail" placeholder="Mail" required=""/>
      <input type="password" class="form-control" name="password" placeholder="Mot de passe" required=""/>
      <input type="password" class="form-control" name="password2" placeholder="Confirmer mot de passe" required=""/> 
      <br><span>Vous êtes :</span>
      <label for="sexe"> Homme </label>
      <input type="radio" name="sexe" value="H" checked="">
      <label for="sexe"> Femme </label>
      <input type="radio" name="sexe" value="F"><br><br>     
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">S'inscrire</button>
    </form>

<?php
  if(isset($_POST['submit'])){

    if ($_POST['password']==$_POST['password2']) {

      $nom = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['nom'])));
      $prenom = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['prenom'])));
      $email = trim($_POST['mail']);
      $login = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['login'])));
      $password = md5($_POST['password']);
      $sexe = $_POST['sexe'];

      //Vérification de l'utilisation du login
      $req = "SELECT count(*) AS nblogin FROM sly_user WHERE login='$login'";
      $res = mysqli_query($lien,$req);
      if(!$res){
        echo "Erreur SQL : $req <br>".mysqli_error($lien);
      }
      else{
        $tab = mysqli_fetch_array($res);
        if ($tab['nblogin']==0) {

          //Requête d'insertion dans la base de données
          $req = "INSERT INTO sly_user VALUES(NULL,'$nom','$prenom','$login','$email','$password',NULL,'".date('Y-m-d H:i:s')."','Visiteur','$sexe')";
          $res = mysqli_query($lien,$req);
          if (!$res) {
            echo "Erreur SQL : $req <br>".mysqli_error($lien);
          }
          else{
            echo "Inscription réussie";
          }
        }
        else{
          echo "Login déjà utilisé.";
        }
      }
      mysqli_close($lien);
    }
    else{
      echo "Mots de passe non identiques.";
    }
  }
?>

  </div>
</div>
<?php
include 'inc/footer.php';
?>
</body>
</html>
