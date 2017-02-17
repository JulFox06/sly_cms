<nav class="navbar navbar-default navbar-fixed-top">
<!--<nav class="navbar navbar-inverse navbar-fixed-top">-->
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="../web"><b><?php echo $array_config['titre'];?></b></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="../web">Accueil</a></li>
        <?php
        $req = "SELECT * FROM sly_categorie WHERE cid_1 IS NULL";
        $res = mysqli_query($lien,$req);
        while ($menu = mysqli_fetch_array($res)) {
          $req = "SELECT * FROM sly_categorie WHERE cid_1 = ".$menu['cid'];
          $fils = mysqli_query($lien,$req);
          $s_menu = mysqli_fetch_array($fils);
          
          if($s_menu == NULL){
            echo "<li><a href='../web?cat=".$menu['cid']."'>".$menu['name']."</a></li>";
          }
          else {
              echo '<li class="dropdown">';
              echo '<a class="dropdown-toggle" data-toggle="dropdown">'.$menu['name'].' <span class="caret"></span></a>';
              echo '<ul class="dropdown-menu">';
              echo "<li><a href='../web?cats=".$menu['cid']."'><b>".$menu['name']."</b></a></li>";
              do{
                echo '<li><a href="../web?cat='.$s_menu['cid'].'">'.$s_menu['name'].'</a></li>';
              }while($s_menu = mysqli_fetch_array($fils));
              echo '</ul></li>';
            
          }
        }
        ?>
        

      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="team.php">L'équipe</a></li>
      <?php
      if ($_SESSION['login'] == "") {
        echo '<li class="dropdown">';
        echo '<a class="drodown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> <span class="caret"></span></a>';
        echo "<ul class='dropdown-menu'>";
        echo "<li><a href='register.php'><span class='glyphicon glyphicon-check'></span> S'inscrire</a></li>
        <li><a href='login.php'><span class='glyphicon glyphicon-log-in'></span> Connexion</a></li>";
        echo "</ul></li>";
      }
      else {
        echo '<li class="dropdown">';
        echo '<a class="drodown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> <span class="caret"></span></a>';
        echo "<ul class='dropdown-menu'>";
        if (($_SESSION['groupe'] == 'Administrateur') || ($_SESSION['groupe'] == 'Modérateur')) {
          echo "<li><a href='admin/' style='color:red;'><span class='glyphicon glyphicon-cog'></span> Administration</a></li>";
        }
        if ($_SESSION['groupe'] == 'Rédacteur') {
          echo "<li><a href='admin/' style='color:red;'><i class='fa fa-envelope-open'></i> Messagerie</a></li>";
        }
        echo "<li><a href='profil.php'><span class='glyphicon glyphicon-user'></span> ".$_SESSION['login']."</a></li>
        <li><a href='logout.php'><span class='glyphicon glyphicon-log-out'></span> Déconnexion</a></li>";
        echo "</ul></li>";
      }
      ?>
      </ul>
    </div>
  </div>
</nav>
<div style="margin-bottom: 80px"></div>