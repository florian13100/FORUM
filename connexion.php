<?php
session_start();
include('bd/connexionDB.php');

if (isset($_SESSION['id'])){
header('Location: /SIFORUM/index');
exit;
}
if (!empty($_POST)){
extract($_POST);
$valid = true;

if (isset($_POST['connexion'])){
$mail = htmlentities(strtolower(trim($mail)));
$mdp = trim($mdp);

if(empty($mail)){
$valid = false;
$er_mail = "il faut mettre un mail";
echo "il faut mettre un mail";

}

if(empty($mdp)) {
$valid = false;
$er_mdp = "il faut mettre un mot de passe";
echo "il faut mettre un mot de passe";
}

$req = $DB->query("SELECT * FROM utilisateur WHERE mail = ? AND mdp = ?",
array($mail, crypt($mdp, '$6$rounds=5000$hd25jskd48fnyuzkkoz78gtmp65qsr995g$')));
$req = $req->fetch();


if ($req['id'] == ""){
$valid = false;
$er_mail = "Le mail ou le mot de passe est incorrecte";
echo '<p class="text-danger">Le mail ou le mot de passe est incorrecte</p>';
}elseif($req['n_mdp'] == 1){
$DB->insert("UPDATE utilisateur SET n_mdp = 0 WHERE id = ?",
    array($req['id']));
}


if ($valid){
$_SESSION['id'] = $req['id'];
$_SESSION['nom'] = $req['nom'];
$_SESSION['prenom'] = $req['prenom'];
$_SESSION['mail'] = $req['mail'];
$_SESSION['avatar'] = $req['avatar'];
header('Location: /SIFORUM/index');
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
    <title>Connexion</title>
  </head>

  <body>
  <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
      <h1 class="text-center mt-5">Connexion</h1>
    <form method="post" class="w-50 mx-auto">
      <?php
      if (isset($er_mail)) {
       ?>
       <div class=""><?php $er_mail ?></div>
       <?php } ?>
       <div class="form-group mt-5">
       <input type="email" class="form-control" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required>
       <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre adresse mail ou votre mot de passe avec quelqu'un d'autre.</small>
       </div>
       <div class="form-group">
       <input type="password"  class="form-control" placeholder="Mot de passe" name="mdp" value="<?php if(isset($psw)){ echo $psw; }?>" required>
       </div>

         <button type="submit" class="btn btn-primary m-auto d-block" name="connexion">Se connecter</button>

    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
