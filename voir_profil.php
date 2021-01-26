<?php

session_start();
include('bd/connexionDB.php');

if(!isset($_SESSION['id'])){
header('Location: index.php');
exit;
}

$id = (int) $_GET['id'];

$afficher_profil = $DB->query("SELECT * FROM utilisateur WHERE id = ?",
array($id));
$afficher_profil = $afficher_profil->fetch();

if(!isset($afficher_profil['id'])){
header('Location: index.php');
exit;
}
 ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Voir profil</title>
  </head>
  <body>
  <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
    <?php require_once('menu.php') ?>

    <div class="card" style="width: 35rem;">
    <?php
      if(file_exists("public/avatar/". $afficher_profil['id'] . "/" . $afficher_profil['avatar']) && isset($afficher_profil['avatar'])){
        ?>
        <img src="<?= "public/avatar/". $afficher_profil['id'] . "/" . $afficher_profil['avatar']; ?>" width="200" height="200" class="border border-warning"/>
        <?php
      }else{
         ?>
         <img src="public\avatar\default\kisspng-avatar-silhouette-computer-icons-female-id-5ac460f18e5e81.1273438915228193135832.png" alt="" width="200" height="200" class="border border-warning">
         <?php
          }
          ?>
  <div class="card-body">
    <h5 class="card-title text-primary"><?php echo $afficher_profil['nom'] . " " . $afficher_profil['prenom']; ?></h5>
    <ul>
      <li>ID :  <?php echo $afficher_profil['id'] ?></li>
      <li>Adresse mail :  <?php echo $afficher_profil['mail'] ?></li>
      <li>Membre du SIFORUM depuis le :  <?php echo $afficher_profil['date_creation_compte'] ?></li>
    </ul>
    <a href="/SIFORUM/index" class="btn btn-warning" >Retourner à l'accueil</a>
  </div>
</div>






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
