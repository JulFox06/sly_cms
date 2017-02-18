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
				        <th data-field="uid" data-sortable="true">ID User</th>
				        <th data-field="login"  data-sortable="true">Login</th>
				        <th data-field="groupe" data-sortable="true">Groupe</th>
					    </tr>
					    </thead>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
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
							echo '<button class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>';
							echo '<button class="btn btn-sm btn-danger"><i class="fa fa-close"></i></button>';
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
