<?php
session_start();
include('bd/connexionDB.php');

if (!isset($_SESSION['id'])){
header('Location: index.php');
exit;
}

$afficher_profil = $DB->query("SELECT * FROM utilisateur WHERE id <> ?",
array($_SESSION['id']));
$afficher_profil = $afficher_profil->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>utilisateurs du site</title>
  </head>
  <body>
  <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
    <?php require_once('menu.php') ?>
    <h2 class="text-center mt-5">Utilisateurs</h2>
    <table class="table table-hover mt-5 w-55 mx-auto">
      <thead>
        <tr>
          <th scope="col">Nom</th>
          <th scope="col">Prénom</th>
          <th scope="col">Voir le profil</th>
        </tr>
        <?php
        foreach($afficher_profil as $ap){
          ?>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $ap['nom'] ?></td>
          <td><?php echo $ap['prenom'] ?></td>
          <td><a href="voir_profil?id=<?= $ap['id'] ?>" class="text-muted text-decoration-none btn btn-outline-warning">Aller au profil</a></td>
        </tr>
        <?php
        }
         ?>
      </tbody>
    </table>
  </body>
</html>
