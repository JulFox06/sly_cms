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
		$(document).on("click","#alert-succes", function(){
			$(".bg-success").remove();
		});
		$(document).on("click","#alert-fail", function(){
			$(".bg-danger").remove();
		});

		$("#delete").on("click", function(){
		  $(".selected").each(function(){
		  	var row = $(this);
		    var id = parseInt($(this).find("td:nth-child(2)").html());
		    console.log(id);
		    var par = {id: id};

		    $.ajax({
		      url: "delete/delete_user.php",
		      method: "POST",
		      data: par,
		      success: function(){
		        $('.page-header').after('<div class="alert bg-success" role="alert"><i class="fa fa-check"></i> Utilisateur(s) supprimé(s) avec succés ! <a href="#" id="alert-succes" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
		        row.remove();
		      },
		      error: function(){
		      	$('.page-header').after('<div class="alert bg-danger" role="alert"><i class="fa fa-exclamation"></i> Une erreur s\'est produite ! <a href="#" id="alert-fail" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
		      }

		    });

		  });

		});
	});
	</script>

	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/bootstrap-table.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

</head>

<body>
	<?php
	include 'inc/menu.php';
	include 'inc/menu_v.php';
	?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Utilisateurs</h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/users.php"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					    <thead>
					    <tr>
				    		<?php
									if ($_SESSION['groupe'] == "Administrateur") {
										echo '<th data-field="state" data-checkbox="true" >Item ID</th>';
									}
								?>
				        <th data-field="uid" data-sortable="true">ID User</th>
				        <th data-field="login"  data-sortable="true">Login</th>
				        <th data-field="nom" data-sortable="true">Nom</th>
				        <th data-field="prenom" data-sortable="true">Prénom</th>
				        <th data-field="mail" data-sortable="true">Mail</th>
				        <th data-field="groupe" data-sortable="true">Groupe</th>
					    </tr>
					    </thead>
						</table>
						<?php
							if ($_SESSION['groupe'] == "Administrateur") {
								echo '<span class="pull-right">
								<button id="delete" class="btn btn-sm btn-danger">Supprimer</button>
							</span>';
							}
						?>
					</div>
				</div>
			</div>
		</div><!--/.row-->

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
</body>

</html>
