<?php
  $hote   = "localhost";
  $login  = "root";
  $mdp    = "iris";
  $base   = "cms_bdd";

  $prefix = "sly_";

  $lien = mysqli_connect($hote,$login,$mdp);
  mysqli_select_db($lien, $base);
  mysqli_set_charset($lien,"utf8");
  ?>