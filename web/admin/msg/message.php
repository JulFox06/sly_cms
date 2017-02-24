	<?php
	$req = "SELECT * FROM sly_user WHERE uid=".$_GET['msg'];
	$res = mysqli_query($lien, $req);
	$desti = mysqli_fetch_array($res);
	$msg = $_GET['msg'];
	?>
	<div class="panel-heading" id="accordion"><i class="fa fa-comment-o"></i> Chat : <?php echo $desti['nom'].' '.$desti['prenom'];?></div>
	<div class="panel-body">
		<ul>
			<?php
				include "controllers/message.controller.php";
			?>
		</ul>
	</div>
</div>
<form method="post" action="messagerie.php?msg=<?php echo $msg;?>">
	<div class="panel-footer">
		<div class="input-group" id="messagerie">
			<input id="btn-input" type="text" name="body" class="form-control input-md" placeholder="Votre message ..." />
			<span class="input-group-btn">
				<input type="submit" class="btn btn-success btn-md" name="submit" value="Envoi">
			</span>
		</div>
	</div>
</form>