<?php
session_start();
include('bd/connexionDB.php');

if (isset($_SESSION['id'])){
header('Location: /SIFORUM/index');
exit;
}

if(!empty($_POST)){
  extract($_POST);
  $valid = true;

  if (isset($_POST['Inscription'])){
    $nom = htmlentities(trim($nom));
    $prenom = htmlentities(trim($prenom));
    $mail = htmlentities(strtolower(trim($mail)));
    $mdp = trim($mdp);
    $confmdp = trim($confmdp);

    if(empty($nom)) {
      $valid = false;
      $er_nom = ("Le nom d'utilisateur ne peut pas être vide");
    }
    if(empty($prenom)) {
      $valid = false;
      $er_prenom = ("Le prénom de l'utilisateur ne peut pas être vide");
    }
    if(empty($mail)) {
      $valid = false;
      $er_mail = ("L'adresse mail ne peut pas être vide");

    }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
      $valid = false;
      $er_mail =  "Le mail n'est pas valide";


    }else{
     $req_mail = $DB->query("SELECT mail FROM utilisateur WHERE mail = ?", array($mail));
     $req_mail = $req_mail->fetch();

     if ($req_mail['mail'] <> ""){
       $valid = false;
       $er_mail =  "Ce mail existe déja";
       echo "Ce mail existe déja";

     }
  }
  if(empty($mdp)) {
  $valid = false;
  $er_mdp =  "Le mot de passe ne peut pas être vide";

}elseif($mdp != $confmdp) {
  $valid = false;
  $er_mdp =  "La confirmation du mot de passe ne correspond pas";
  echo "La confirmation du mot de passe ne correspond pas";

}

if($valid) {
  $mdp = crypt($mdp, '$6$rounds=5000$hd25jskd48fnyuzkkoz78gtmp65qsr995g$');
  $date_creation_compte = date('Y-m-d H:i:s');

  $DB->insert("INSERT INTO utilisateur (nom, prenom, mail, mdp, date_creation_compte) VALUES (?, ?, ?, ?, ?)",
  array($nom, $prenom, $mail, $mdp, $date_creation_compte));

  header('Location: connexion');
  exit;

    }
  }
}

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Inscription</title>
  </head>
  <body>
  <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
    <h1 class="text-center mt-5">Inscription</h1>
    <form class="w-50 mx-auto" method="post">
      <?php if (isset($er_nom)){
      ?>
      <div class=""><?php= $er_nom ?></div>
    <?php } ?>
    <div class="form-group">
    <input type="text" class="form-control" placeholder="Votre nom" name="nom" value="<?php if(isset($nom)){ echo $nom; }?>" required>
  </div>
    <?php if (isset($er_prenom)){
      ?>
      <div class=""><?php= $er_prenom ?></div>
      <?php } ?>
      <div class="form-group">
      <input type="text" class="form-control" placeholder="Votre prénom" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; } ?>" required>
      </div>
      <?php if(isset($er_mail)){
        ?>
        <div class=""><?php $er_mail ?></div>
        <?php } ?>
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Adresse mail" name="mail" value="<?php if(isset($er_mail)){echo $mail;} ?>"required>
        </div>
        <?php if(isset($er_mdp)){
          ?>
          <div class=""><?php= $er_mdp ?></div>
        <?php } ?>
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Mot de passe" name="mdp" value="<?php if(isset($mdp)){ echo $mdp;} ?>" required>
        </div>

        <div class="form-group">
        <input type="password" class="form-control" placeholder="Confirmer le mot de passe" name="confmdp" required>
        </div>

        <button type="submit"  class="btn btn-primary m-auto d-block" name="Inscription">Envoyer</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
