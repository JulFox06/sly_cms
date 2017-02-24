<?php
include '../../../contents/sly_config.php';
$query = "SELECT * FROM sly_categorie WHERE cid_1 IS NULL";
$req = mysqli_query($lien, $query);
$res = array();
while ($row = mysqli_fetch_array($req, MYSQLI_ASSOC)) {
  array_push($res, $row);
}
echo json_encode($res);
?>