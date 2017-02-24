<?php
session_start();
if ($_SESSION['login'] == "" | $_SESSION['groupe'] == "Visiteur" | $_SESSION['groupe'] == "Modérateur" | $_SESSION['groupe'] == "Rédacteur") {
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

	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/bootstrap-table.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

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
		      url: "delete/delete_droit.php",
		      method: "POST",
		      data: par,
		      success: function(){
		        $('.page-header').after('<div class="alert bg-success" role="alert"><i class="fa fa-check"></i> Utilisateur(s) dé-gradé(s) avec succés ! <a href="#" id="alert-succes" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
		        row.remove();
		      },
		      error: function(){
		      	$('.page-header').after('<div class="alert bg-danger" role="alert"><i class="fa fa-exclamation"></i> Une erreur s\'est produite ! <a href="#" id="alert-fail" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
		      }

		    });

		  });

		});

		$(".yes").on("click", function(){
			var row = $(this);
	    var id = this.id;
	    console.log(id);
	    var par = {id: id};

	    $.ajax({
	      url: "droits/yes.php",
	      method: "POST",
	      data: par,
	      success: function(){
	        $('.page-header').after('<div class="alert bg-success" role="alert"><i class="fa fa-check"></i> Utilisateur gradé avec succés ! <a href="#" id="alert-succes" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
	        row.parent().parent().remove();
	      },
	      error: function(){
	      	$('.page-header').after('<div class="alert bg-danger" role="alert"><i class="fa fa-exclamation"></i> Une erreur s\'est produite ! <a href="#" id="alert-fail" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
	      }

	    });
		});

		$(".no").on("click", function(){
			var row = $(this);
	    var id = this.id;
	    console.log(id);
	    var par = {id: id};

	    $.ajax({
	      url: "droits/no.php",
	      method: "POST",
	      data: par,
	      success: function(){
	        $('.page-header').after('<div class="alert bg-success" role="alert"><i class="fa fa-check"></i> Demande de droit refusée avec succés ! <a href="#" id="alert-succes" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
	        row.parent().parent().remove();
	      },
	      error: function(){
	      	$('.page-header').after('<div class="alert bg-danger" role="alert"><i class="fa fa-exclamation"></i> Une erreur s\'est produite ! <a href="#" id="alert-fail" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
	      }

	    });
		});
	});
	</script>
</head>

<body>
	<?php
	include 'inc/menu.php';
	include 'inc/menu_v.php';
	?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Gestion des droits</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<table data-toggle="table" data-url="tables/droits.php" data-show-refresh="true" data-pagination="true" data-sort-name="groupe" data-sort-order="asc">
					    <thead>
					    <tr>
					    	<th data-field="state" data-checkbox="true" >Item ID</th>
				        <th data-field="uid" data-sortable="true">ID User</th>
				        <th data-field="login"  data-sortable="true">Login</th>
				        <th data-field="groupe" data-sortable="true">Groupe</th>
					    </tr>
					    </thead>
						</table>
						<span class="pull-right">
							<button id="delete" class="btn btn-sm btn-danger">Dé-grader</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4>Demande de droits :</h4>
					<?php
					$req = "SELECT * FROM sly_rank";
					$res = mysqli_query($lien, $req);
					if (!$res) {
						echo "Aucune demande de droit.";
					}
					else {
						while ($rank = mysqli_fetch_array($res)) {
							echo '<div class="row">';
							echo '<div class="col-md-9">';
							echo '<button data-toggle="collapse" data-target="#'.$rank['login'].'_btn">'.$rank['login'].'</button> souhaite devenir '.$rank['rank'].'.';
							echo '</div>';
							echo '<div class="col-md-3">';
							echo '<button class="btn btn-sm btn-success yes" id="'.$rank['login'].'_y"><i class="fa fa-check"></i></button>';
							echo '<button class="btn btn-sm btn-danger no" id="'.$rank['login'].'_n"><i class="fa fa-close"></i></button>';
							echo '</div>';
							echo '<div id="'.$rank['login'].'_btn" class="collapse"><p>'.$rank['message'].'</p></div><br>';
							echo '</div>';
						}
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

	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
</body>

</html>
