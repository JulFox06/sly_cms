<?php
// CALCUL DU NOMBRE DE PAGE
$req = "SELECT count(*) AS nbart FROM sly_article";
$res = mysqli_query($lien,$req);
if(!$res){
    echo "Erreur SQL";
}
else {
    $tab = mysqli_fetch_array($res); 
    $nbpages = ceil($tab['nbart']/$parpage);
    if ($nbpages == 0) {
      $nbpages = 1;
    }
    echo "<br><ul class='pagination pull-right'>";
    if ($page != 1) {
        echo "<li><a href='index.php'> << </a></li>";
        echo "<li><a href='?page=".($page-1)."'> < </a></li>";
    }

    if ($page > 2) {
        $deb = $page-2;
    }
    else{
        $deb = 1;
    }

    if ($page < $nbpages-2) {
        $fin = $page+2;
    }
    else{
        $fin = $nbpages;
    }

    for ($i=$deb; $i <= $fin; $i++) { 
      if ($page!=$i) {
        echo "<li><a href='?page=$i'> $i </a></li>";
      }
      else{
        echo "<li class='disabled'><a> $i </a></li>";
      }
    }
    if ($page != $nbpages) {
        echo "<li><a href='?page=".($page+1)."'> > </a></li>";
        echo "<li><a href='?page=$nbpages'> >> </a></li>";
    }
    echo "</ul>";
  }
?>