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
  <div class="col-sm-8 col-sm-offset-2 text-center bg_white">
  <h1>L'équipe du forum</h1><br><br>
    <div class="row">
      <?php
      $req = "SELECT * FROM sly_user WHERE groupe!='Visiteur' ORDER BY groupe ASC";
      $res = mysqli_query($lien,$req);
      while ($array_team = mysqli_fetch_array($res)){
        echo "<div class='col-sm-4 text-center'>";
        if ($array_team['sexe'] == 'H') {
          echo '<img src="profil_img/boss.png" class="img-circle" width="65" alt="Avatar">';
        }
        else {
          echo '<img src="profil_img/woman.png" class="img-circle" width="65" alt="Avatar">';
        }
        echo "<h3>".$array_team['nom']." ".$array_team['prenom']."<br>";
        echo "<small>".$array_team['login']."</small></h3>";
        if ($array_team['groupe'] == 'Administrateur') {
          echo "<h4><span class='label label-danger'>".$array_team['groupe']."</span></h4><br>";
        }
        elseif ($array_team['groupe'] == 'Modérateur') {
          echo "<h4><span class='label label-primary'>".$array_team['groupe']."</span></h4><br>";
        }
        else {
          echo "<h4><span class='label label-success'>".$array_team['groupe']."</span></h4><br>";
        }
        echo "</div>";
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
