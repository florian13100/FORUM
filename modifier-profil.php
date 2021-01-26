<?php
session_start();
include('bd/connexionDB.php');

if (!isset($_SESSION['id'])){
header('Location: index.php');
exit;
}


$afficher_profil = $DB->query("SELECT * FROM utilisateur WHERE id = ?", array($_SESSION['id']));
$afficher_profil = $afficher_profil->fetch();

if(!empty($_POST)){
  extract($_POST);
  $valid = true;

  if(isset($_POST['modification'])){
    $nom = htmlentities(trim($nom));
    $prenom = htmlentities(trim($prenom));
    $mail = htmlentities(strtolower(trim($mail)));

    if(empty($nom)){
      $valid = false;
      $er_nom = "Il faut mettre un nom";
    }

    if(empty($prenom)){
      $valid = false;
      $er_prenom = "Il faut mettre un prenom";
    }

    if(empty($mail)){
      $valid = false;
      $er_mail = "Il faut mettre un mail";

    }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
      $valid = false;
      $er_mail = "le mail n'est pas valide";

    }else{
      $req_mail = $DB->query("SELECT mail FROM utilisateur WHERE mail = ?", array($mail));
      $req_mail = $req_mail->fetch();

      if($req_mail['mail'] <> "" && $_SESSION['mail'] != $req_mail['mail']){
        $valid = false;
        $er_mail = "ce mail existe déja";
      }
    }

    if ($valid){
      $DB->insert("UPDATE utilisateur SET PRENOM = ?, nom = ?, mail = ? WHERE id = ?", array($prenom, $nom, $mail, $_SESSION['id']));

      $_SESSION['nom'] = $nom;
      $_SESSION['prenom'] = $prenom;
      $_SESSION['mail'] = $mail;

      header('Location: /SIFORUM/profil');
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Modifier votre profil</title>
  </head>

<body>
<div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
  <?php require_once('menu.php') ?>
</h1>
   </div>
<h2 class="text-center mt-4">Modification</h2>
<form method="post" class="w-50 mx-auto mt-5">

  <?php
  if(isset($er_nom)){
    ?>
<div class=""> <?php $er_nom ?></div>
  <?php
    }
    ?>

    <input type="text" class="form-control m-2" placeholder="Votre nom" name="nom" value="<?php if(isset($nom)){ echo $nom; }else{ echo $afficher_profil['nom'];}?>" required>
    <?php
    if(isset($er_prenom)){
      ?>
  <div class="form-group mt-5"> <?php $er_prenom ?></div>
    <?php
      }
      ?>
      <input type="text" class="form-control m-2" placeholder="Votre prénom" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; }else{ echo $afficher_profil['prenom'];}?>" required>

      <?php
      if(isset($er_mail)){
        ?>
    <div class=""> <?php $er_mail ?></div>
      <?php
        }
        ?>
        <input type="email" class="form-control m-2" placeholder="Votre adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }else{ echo $afficher_profil['mail'];}?>" required>
        <button type="submit" class="btn btn-primary m-auto d-block" name="modification">Modifier mon profil</button>
      </form>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
