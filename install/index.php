<!DOCTYPE html>
<html>
<head>
	<title>Sly CMS | Wait ...</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="../assets/fox-logo.png">

	<script src="http://code.jquery.com/jquery-1.9.0b1.js"></script>
	<script src="../assets/js/pageloader.js"></script>
	<script>
	// Le DOM est pret
	$(document).ready(function() {
		$.pageLoader();
	});
	</script>

	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
<div id="chargement">Chargement...<span id="chargement-infos"></span></div>
<div id="container"></div>
</body>
</html>