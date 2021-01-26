<?php
session_start();
include('bd/connexionDB.php');

if (isset($_SESSION['id'])){
header('Location: index.php');
exit;
}

if(!empty($_POST)){
  extract($_POST);
  $valid = true;

if(isset($_POST['oublie'])){
  $mail = htmlentities(strtolower(trim($mail)));

  if(empty($mail)){
  $valid = false;
  $er_mail = "il faut mettre un mail";
  echo "il faut mettre un mail";

  }

  if($valid){
    $verification_mail = $DB->query("SELECT nom, prenom, mail, n_mdp FROM utilisateur WHERE mail = ?", array($mail));
    $verification_mail = $verification_mail->fetch();

    if(isset($verification_mail['mail'])){
      if($verification_mail['n_mdp']==0){

        $new_pass = rand(100000, 1000000000);
        $new_pass_crypt = crypt($new_pass, '$6$rounds=5000$hd25jskd48fnyuzkkoz78gtmp65qsr995g$');


        $objet ='nouveau mot de passe';
        $to = $verification_mail['mail'];

        $header = "From: <no-reply@southernimplants.fr> \n";
        $header .= "Reply-To: ".$to."\n";
        $header .= "MIME-version: 1.0\n";
        $header .= "Content-type: text/html; charset=utf-8\n";
        $header .= "Content-Transfer-Encoding: 8bit";

        $contenu = "<html>".
        "<body>".
         "<p style='text-align: center; font-size: 18px'><b>Bonjour Mr, Mme".$verification_mail['nom']."</b>,</p><br/>".
         "<p style='text-align: justify'><i><b>Nouveau mot de passe : </b></i>".$new_pass."</p></br>".
        "</body>".
       "</html>";

           mail($to, $objet, $contenu, $header);
          $DB->insert("UPDATE utilisateur SET mdp = ?, n_mdp = 1 WHERE mail = ?", array($new_pass_crypt, $verification_mail['mail']));

        }
      }

      header('Location: connexion.php');
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
    <title>Mot de passe oublié</title>
  </head>
  <body>
  <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
      <h1 class="text-center mt-5">Mot de passe oublié</h1>
    <form method="post" class="w-50 mx-auto">
      <?php
      if (isset($_ermail)){
       ?>
       <div class=""><?php $er_mail ?></div>
       <?php
        }
        ?>
        <div class="form-group">
        <input type="email" class="form-control" placeholder="adresse mail" name="mail" value="<?php if(isset($mail)){echo $mail;} ?>" required>
        <small id="emailHelp" class="form-text text-muted">Merci de nous communiquer votre adresse mail, nous vous communiquerons un nouveau mot de passe que vous trouverez dans votre boîte mail.</small>
      </div>
        <button type="submit" class="btn btn-primary m-auto d-block" name="oublie">Envoyer</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
