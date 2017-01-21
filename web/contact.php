<?php
session_start();
include '../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<head>
  <title><?php echo $array_config['titre'];?> | Contact</title>

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
  <div class="col-sm-6 col-sm-offset-3 text-center bg_white">
    <form method="post" action="contact.php" class="form-signin">       
      <h2 class="form-signin-heading">Contactez-nous</h2>
      <input type="text" class="form-control" name="nom" placeholder="Nom" required="" autofocus="" />
      <input type="text" class="form-control" name="prenom" placeholder="Prénom" required=""/>
      <input type="mail" class="form-control" name="mail" placeholder="Mail" required=""/>
      <textarea class="form-control" style="resize: vertical;" placeholder="Votre message ..." name="message"></textarea>  
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Envoyer</button>
    </form>
    <?php
    // destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
    $destinataire = $array_config['admin_email'];
     
    // Messages de confirmation du mail
    $message_envoye = "<div class='alert alert-success'><strong>Super !</strong> Votre mail a été envoyé.</div>";
    $message_non_envoye = "<div class='alert alert-danger'><strong>Erreur !</strong> Votre mail n'a pas pu être envoyé.</div>";
     
    // Messages d'erreur du formulaire
    $message_formulaire_invalide = "<div class='alert alert-danger'><strong>Attention !</strong> Veuillez vérifier les champs du formulaire.</div>";
     
    // on teste si le formulaire a été soumis
    if (isset($_POST['submit']))
    {
      /*
       * cette fonction sert à nettoyer et enregistrer un texte
       */
      function Rec($text)
      {
        $text = htmlspecialchars(trim($text), ENT_QUOTES);
        if (1 === get_magic_quotes_gpc())
        {
          $text = stripslashes($text);
        }
     
        $text = nl2br($text);
        return $text;
      };
     
      /*
       * Cette fonction sert à vérifier la syntaxe d'un email
       */
      function IsEmail($email)
      {
        $value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
        return (($value === 0) || ($value === false)) ? false : true;
      }
     
      // formulaire envoyé, on récupère tous les champs.
      $nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
      $email   = (isset($_POST['mail']))   ? Rec($_POST['mail'])   : '';
      $objet   = '[Mail/CMS] '.$array_config['titre'].', '.$nom;
      $message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
     
      // On va vérifier les variables et l'email ...
      $email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
     
      if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
      {
        // les 4 variables sont remplies, on génère puis envoie le mail
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From:'.$nom.' '.$email.''. "\r\n" .
            'Reply-To:'.$email. "\r\n" .
            'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
            'Content-Disposition: inline'. "\r\n" .
            'Content-Transfer-Encoding: 7bit'." \r\n" .
            'X-Mailer:PHP/'.phpversion();
        echo $headers;
      
        $cible = $destinataire;

     
        // Remplacement de certains caractères spéciaux
        $message = str_replace("&#039;","'",$message);
        $message = str_replace("&#8217;","'",$message);
        $message = str_replace("&quot;",'"',$message);
        $message = str_replace('<br>','',$message);
        $message = str_replace('<br />','',$message);
        $message = str_replace("&lt;","<",$message);
        $message = str_replace("&gt;",">",$message);
        $message = str_replace("&amp;","&",$message);
        // Envoi du mail
        $num_emails = 0;
        $tmp = explode(';', $cible);
        foreach($tmp as $email_destinataire)
        {
          if (mail($email_destinataire, $objet, $message, $headers))
            $num_emails++;
        }
     
        if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
        {
          echo '<p>'.$message_envoye.'</p>';
        }
        else
        {
          echo '<p>'.$message_non_envoye.'</p>';
        };
      }
      else
      {
        // une des 3 variables (ou plus) est vide ...
        echo $message_formulaire_invalide;
      };
    }; // fin du if (isset($_POST['envoi']))
    ?>
  </div>
</div>
<?php
include 'inc/footer.php';
?>
</body>
</html>
