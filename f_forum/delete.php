<?php
include('../bd/connexionDB.php');

$get_id_commentaire = (int) trim(htmlentities($_GET['id']));


$commentaire = $DB->query("SELECT id FROM topic_commentaire",
    array($get_id_commentaire));
  $commentaire = $commentaire->fetch();

 ?>