<?php
$user1 = $_SESSION['uid'];
$user2 = $_GET['msg'];


$req = "SELECT * FROM sly_message WHERE (auteur='$user1' AND destinataire='$user2') OR (auteur='$user2' AND destinataire='$user1') ORDER BY date_post DESC";
$res = mysqli_query($lien, $req);
while ($post = mysqli_fetch_array($res)) {
	if ($post['auteur'] == $user1) {
		echo '<li><div class="chat-body"><div class="header"><small class="text-muted">'.$post['date_post'].'</small></div>
		<p>'.$post['contenu'].'</p></div></li>';
	}
	else {
		echo '<li class="text-right"><div class="chat-body "><div class="header"><small class="text-muted">'.$post['date_post'].'</small></div><p>'.$post['contenu'].'</p></div></li>';
	}
}
?>