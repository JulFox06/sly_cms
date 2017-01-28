<?php
session_start();
if ($_SESSION['login'] == "") {
	header('Location:../login.php');
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

	<link rel="shortcut icon" href="assets/fox-logo.png">

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
	<?php include 'inc/menu.php';?>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li role="presentation" class="divider"></li>
			<li><a href="index.php"><i class="fa fa-laptop"></i> Dashboard</a></li>
			<li class="active"><a href="users.php"><i class="fa fa-users"></i> Utilisateurs</a></li>
			<li><a href="articles.php"><i class="fa fa-folder-open"></i> Articles</a></li>
			<li><a href="categorie.php"><i class="fa fa-list"></i> Catégories</a></li>
			<li><a href="messagerie.php"><i class="fa fa-comments"></i> Messagerie</a></li>
			<li role="presentation" class="divider"></li>
		</ul>
	</div><!--/.sidebar-->
		
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
						<table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="state" data-checkbox="true" >Item ID</th>
						        <th data-field="id" data-sortable="true">Item ID</th>
						        <th data-field="name"  data-sortable="true">Item Name</th>
						        <th data-field="price" data-sortable="true">Item Price</th>
						    </tr>
						    </thead>
						</table>
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
