<?php
if(isset($_POST['valider'])) { // si nous venons du formulaire alors

// on crée des constantes dont on se servira plus tard
define('RETOUR', '<br /><br /><input type="button" value="Retour" onclick="history.back()">');
define('OK', '<span class="ok">OK</span><br />');
define('ECHEC', '<span class="echec">ECHEC</span>');

$configfiletemp = "../contents/sly_config_temp.php";
$configfile = "../contents/sly_config.php";
if(file_exists($configfile) AND filesize($configfile) > 0) { // si le fichier existe et qu'il n'est pas vide alors
exit('Fichier de configuration déjà existant. Installation interrompue.'. RETOUR);
}	

// on crée nos variables, et au passage on retire les éventuels espaces	
$hote = trim($_POST['host_bdd']);
$login = trim($_POST['nom_user']);
$mdp = trim($_POST['mdp_user']);
$base = trim($_POST['nom_bdd']);

$lien = mysqli_connect($hote, $login, $mdp);
// on vérifie la connectivité avec le serveur avant d'aller plus loin
if(!mysqli_connect($hote, $login, $mdp)) {
exit('Mauvais paramètres de connexion.'. RETOUR);
}

// on vérifie la connectivité avec la base avant d'aller plus loin	
if(!mysqli_select_db($lien, $base)) {
exit('Mauvais nom de base.'. RETOUR);
}	

// le texte que l'on va mettre dans le config.php
$texte = '<?php
$hote   = "'. $hote .'";
$login  = "'. $login .'";
$mdp    = "'. $mdp .'";
$base   = "'. $base .'";

$lien = mysqli_connect($hote,$login,$mdp);
mysqli_select_db($lien, $base);
?>';

// on vérifie s'il est possible d'ouvrir le fichier
if(!$ouvrir = fopen($configfile, 'w')) {
exit('Impossible d\'ouvrir le fichier : <strong>'. $configfile .'</strong>.'. RETOUR);
}

// s'il est possible d'écrire dans le fichier alors on ne se gêne pas
if(fwrite($ouvrir, $texte) == FALSE) {
exit('Impossible d\'écrire dans le fichier : <strong>'. $configfile .'</strong>.'. RETOUR);
}

// tout s'est bien passé
echo 'Fichier de configuration : '. OK;
fclose($ouvrir); // on ferme le fichier
	

$requetes = ''; // on crée une variable vide car on va s'en servir après
 
$sql = file('../contents/base.sql'); // on charge le fichier SQL qui contient des requêtes
foreach($sql as $lecture) { // on le lit
	if(substr(trim($lecture), 0, 2) != '--') { // suppression des commentaires et des espaces
	$requetes .= $lecture; // nous avons nos requêtes dans la variable
	}
}
 
$reqs = preg_split("/;/", $requetes); // on sépare les requêtes
foreach($reqs as $req){	// et on les exécute
	if(!mysqli_query($lien, $req) AND trim($req) != '') { // si la requête fonctionne bien et qu'elle n'est pas vide
		exit('ERREUR : '. $req); // message d'erreur
	}
}
echo 'Installation : '. OK;	
echo '<br /><span class="note">Note : si le site est en ligne, veuillez supprimer le répertoire <strong>/install</strong> du ftp.</span>';

} // si on passe sur ce fichier sans être passé par la première étape alors on redirige
else
exit('Vous devez d\'abord être passé par <a href="index.php">le formulaire</a>.');	
?>
</p>
</body>
</html>
