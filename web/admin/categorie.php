<?php
session_start();
if ($_SESSION['login'] == "" | $_SESSION['groupe'] == "Visiteur" | $_SESSION['groupe'] == "Rédacteur") {
	header('Location:../');
}
include '../../contents/sly_config.php';
$req = 'SELECT * FROM sly_config';
$res = mysqli_query($lien,$req);
$array_config = mysqli_fetch_array($res);

?>
<!DOCTYPE html>
<head>
	<title><?php echo $array_config['titre'];?> | Administration</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="../assets/fox-logo.png">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Latest compiled and minified JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function(){
		$(document).on("click",".alert-succes", function(){
			$(".bg-success").remove();
		});
		$(document).on("click",".alert-fail", function(){
			$(".bg-danger").remove();
		});

		$("#delete").on("click", function(){
		  $(".selected").each(function(){
		  	var row = $(this);
		    var id = parseInt($(this).find("td:nth-child(2)").html());
		    console.log(id);
		    var par = {id: id};

		    $.ajax({
		      url: "delete/delete_cate.php",
		      method: "POST",
		      data: par,
		      success: function(){
		        $('.page-header').after('<div class="alert bg-success" role="alert"><i class="fa fa-check"></i> Catégorie(s) supprimé(s) avec succés ! <a href="#" class="alert-succes pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
		        row.remove();
		      },
		      error: function(){
		      	$('.page-header').after('<div class="alert bg-danger" role="alert"><i class="fa fa-exclamation"></i> Une erreur s\'est produite ! <a href="#" class="alert-fail pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
		      }

		    });

		  });

		});

	});
	</script>

	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

</head>

<body>
	<?php
	include 'inc/menu.php';
	$active = 'categorie';
	include 'inc/menu_v.php';
	?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Catégories</h1>
			</div>
		</div><!--/.row-->
		<?php
			if (isset($_POST['add_cat'])) {
				$name = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['name_cat'])));

				$req = "SELECT count(*) AS nbcate FROM sly_categorie WHERE name='$name'";
				$res = mysqli_query($lien,$req);
				if (!$res) {
					echo "Erreur SQL : $req <br>".mysqli_error($lien);
				}
				else {
					$tab = mysqli_fetch_array($res);
					if ($tab['nbcate']==0) {
						$req = "INSERT INTO sly_categorie VALUES (NULL, '$name', NULL)";
						$res2 = mysqli_query($lien,$req);
						if (!$res2) {
							echo "Erreur SQL : $req <br>".mysqli_error($lien);
						}
						else {
							echo '<div class="alert alert-success"><strong>Super !</strong> Nouvelle catégorie ajoutée !</div>';
						}
					}
					else {
						echo '<div class="alert alert-danger"><strong>Erreur !</strong> Le nom de catégorie est déjà utilisé.</div>';
					}
				}
			}
			if (isset($_POST['add_cat_s'])) {
				$name = trim(htmlentities(mysqli_real_escape_string($lien, $_POST['name_cat_s'])));
				$id_parent = $_POST['id_parent'];

				$req = "SELECT count(*) AS nbcate FROM sly_categorie WHERE name='$name'";
				$res = mysqli_query($lien,$req);
				if (!$res) {
					echo "Erreur SQL : $req <br>".mysqli_error($lien);
				}
				else {
					$tab = mysqli_fetch_array($res);
					if ($tab['nbcate']==0) {
						$req = "INSERT INTO sly_categorie VALUES (NULL, '$name', '$id_parent')";
						$res2 = mysqli_query($lien,$req);
						if (!$res2) {
							echo "Erreur SQL : $req <br>".mysqli_error($lien);
						}
						else {
							echo '<div class="alert alert-success"><strong>Super !</strong> Nouvelle catégorie ajoutée !</div>';
						}
					}
					else {
						echo '<div class="alert alert-danger"><strong>Erreur !</strong> Le nom de catégorie est déjà utilisé.</div>';
					}
				}
			}
			?>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Catégories principales
					</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/categories.php" >
						    <thead>
						    <tr>
							    <?php
										if ($_SESSION['groupe'] == "Administrateur") {
											echo '<th data-field="state" data-checkbox="true" >Item ID</th>';
										}
									?>
					        <th data-field="cid" data-sortable="true">ID catégorie</th>
					        <th data-field="name" data-sortable="true">Nom catégorie</th>
						    </tr>
						    </thead>
						</table>
						<?php
							if ($_SESSION['groupe'] == "Administrateur") {
								echo '<form method="post">';
								echo '<input class="form-control" type="text" name="name_cat" placeholder="Nom de la catégorie" required>';
								echo '<input type="submit" class="btn btn-sm btn-success" name="add_cat" value="Ajouter">';
								echo '</form>';
							}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Catégories secondaires
					</div>
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/categories_s.php" >
						    <thead>
						    <tr>
							    <?php
										if ($_SESSION['groupe'] == "Administrateur") {
											echo '<th data-field="state" data-checkbox="true" >Item ID</th>';
										}
									?>
					        <th data-field="cid" data-sortable="true">ID catégorie</th>
					        <th data-field="name" data-sortable="true">Nom catégorie</th>
					        <th data-field="cid_1" data-sortable="true">ID parent</th>
						    </tr>
						    </thead>
						</table>
						<?php
							if ($_SESSION['groupe'] == "Administrateur") {
								echo '<form method="post">';
								echo '<select name="id_parent" class="form-control">';
								$req = "SELECT * FROM sly_categorie WHERE cid_1 IS NULL ORDER BY name";
					      $res = mysqli_query($lien,$req);
					      while ($cate = mysqli_fetch_array($res)) {
					        echo "<option value='".$cate['cid']."'>".$cate['name']."</option>";
					       }
								echo '</select>';
								echo '<input class="form-control" type="text" name="name_cat_s" placeholder="Nom de la catégorie" required>';
								echo '<input type="submit" class="btn btn-sm btn-success" name="add_cat_s" value="Ajouter">';
								echo '</form>';
							}
						?>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		<?php
			if ($_SESSION['groupe'] == "Administrateur") {
				echo '<span class="pull-right">Si vous supprimez une catégorie principale, assurez vous qu\'il ne contient pas de sous-catégories.
				<button id="delete" class="btn btn-sm btn-danger">Supprimer</button>
			</span>';
			}
		?>

		<script src="js/bootstrap-table.js"></script>

		<script>
	    $(function () {
	        $('#hover, #striped, #condensed').click(function () {
	            var classes = 'table';
	
	            if ($('#hover').prop('checked')) {
	                classes += ' table-hover';
	            }
	            if ($('#condensed').prop('checked')) {
	                classes += ' table-condensed';
	            }
	            $('#table-style').bootstrapTable('destroy')
	                .bootstrapTable({
	                    classes: classes,
	                    striped: $('#striped').prop('checked')
	                });
	        });
	    });
	
	    function rowStyle(row, index) {
	        var classes = ['active', 'success', 'info', 'warning', 'danger'];
	
	        if (index % 2 === 0 && index / 2 < classes.length) {
	            return {
	                classes: classes[index / 2]
	            };
	        }
	        return {};
	    }
		</script>
	</div>	<!--/.main-->

	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
</body>

</html>
