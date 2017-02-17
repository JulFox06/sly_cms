<?php
echo '<div class="panel-heading" id="accordion"><i class="fa fa-comment-o"></i> Chat</div>
<div class="panel-body">';
if ($_GET['msg'] == $_SESSION['uid']) {
	$EXPORT .= "<h3 class='text-center'><strong>Vous souhaitez vraiment vous parler à vous même ?</strong></h3>";
}
else {
	$EXPORT .= "<h3 class='text-center'><strong>Sélectionnez un contact</strong></h3>";
}
?>