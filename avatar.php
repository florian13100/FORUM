
<?php
session_start();
include('bd/connexionDB.php');

if(!empty($_POST))
{
  extract($_POST);
  $valid = true;

  if(isset($_POST['avatar']))
  {
    if (isset($_FILES['file']) and !empty ($_FILES['file']['name']))
    {
      $filename = $_FILES['file']['tmp_name'];
      list($width_orig, $height_orig) = getimagesize($filename);

      if($width_orig >= 100 && $height_orig >= 100 && $width_orig <= 12000 && $height_orig <= 12000)
      {
        $ListeExtension = array('jpg' => 'image/jpeg', 'jpeg' => 'image/pjpeg');
        $ListeExtensionIE = array('jpg' => 'image/pjpg', 'jpeg'=>'image/pjpeg');
        $tailleMax = 10485760;
        $extensionsValides = array('jpg', 'jpeg', 'png');

        if ($_FILES['file']['size'] <= $tailleMax)
        {
          $extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
          if(in_array($extensionUpload, $extensionsValides))
          {
            $dossier = "public/avatar/" . $_SESSION['id'] . "/";

            if(!is_dir($dossier))
            {
              mkdir($dossier);
            }
            else
            {
              if(file_exists("public/avatar/". $_SESSION['id'] . "/" . $_SESSION['avatar']) && isset($_SESSION['avatar']))
              {
                unlink("public/avatar/". $_SESSION['id'] . "/" . $_SESSION['avatar']);
              }
            }

            $nom = md5(uniqid(rand(), true));
            $chemin = "public/avatar/" . $_SESSION['id'] . "/" .$nom . "." . $extensionUpload;
            $resultat = move_uploaded_file($_FILES['file']['tmp_name'], $chemin);
            
            if($resultat)
            {
              if(is_readable("public/avatar/" . $_SESSION['id'] . "/" .$nom . "." . $extensionUpload))
              {
                $verif_ext = getimagesize("public/avatar/" . $_SESSION['id'] . "/" .$nom . "." . $extensionUpload);

                if($verif_ext['mime'] == $ListeExtension[$extensionUpload] || $verif_ext['mime'] == $ListeExtensionIE[$extensionUpload])
                {
                  $filename = "public/avatar/" . $_SESSION['id'] . "/" .$nom . "." . $extensionUpload;

                  if($extensionUpload == 'jpg' || $extensionUpload == 'jpeg' || $extensionUpload == 'pjpg' || $extensionUpload == 'pjpeg')
                  {
                    $image2 = imagecreatefromjpeg($filename);
                  }

                  $width2 = 720;
                  $height2 = 720;

                  list($width_orig, $height_orig) = getimagesize($filename);
                  $image_p2 = imagecreatetruecolor($width2, $height2);
                  imagealphablending($image_p2, false);
                  imagesavealpha($image_p2, true);

                  $point2 = 0;
                  $ratio = null;
                  if($width_orig <= $height_orig)
                  {
                    $ratio = $width2 / $width_orig;
                  }
                  else if($width_orig > $height_orig)
                  {
                    $ratio = $height2 / $height_orig;
                  }

                  $width2 = ($width_orig * $ratio) + 1;
                  $height2 = ($height_orig * $ratio) +1;

                  imagecopyresampled($image_p2, $image2, 0, 0, $point2, 0, $width2, $height2, $width_orig, $height_orig);
                  imagedestroy($image2);

                  if($extensionUpload == 'jpg' || $extensionUpload == 'jpeg' || $extensionUpload == 'pjpg' || $extensionUpload == 'pjpeg')
                  {
                    header('Content_Type: image/jpeg');
                    $exif = exif_read_data($filename);

                    if(!empty($exif['orientation']))
                    {
                      switch($exif['orientation'])
                      {
                        case 8:
                          $image_p2 = imagerotate($image_p2,90,0);
                        break;
                        case 3:
                          $image_p2 = imagerotate($image_p2, 180,0);
                        break;
                        case 6:
                          $image_p2 = imagerotate($image_p2,-90,0);
                        break;
                      }
                    }

                    imagejpeg($image_p2, "SIFORUM/public/avatar/" . $_SESSION['id'] . "/" . $nom . "." . $extensionUpload, 75);
                    imagedestroy($image_p2);
                  }

                  $DB->insert("UPDATE utilisateur SET avatar = ? WHERE id = ?",
                  array(($nom.".".$extensionUpload), $_SESSION['id']));

                  $_SESSION['avatar'] = ($nom.".".$extensionUpload);

                  header('Location: profil');
                  exit;
                }
                else
                {
                  echo $_SESSION['flash']['warning'] = "Le type MIME de l'image n'est pas bon";
                }
              }
            }
            else
            {
              echo $_SESSION['flash']['error'] = "Erreur lors de l'importation de la photo";
            }
          }
          else
          {
            echo  $_SESSION['flash']['warning'] = "Votre photo doit être au format jpg.";
          }
        }
        else
        {
          echo  $_SESSION['flash']['warning'] = "Votre photo de profil ne doit pas dépasser 10 MO !";
        }
      }
      else
      {
        echo  $_SESSION['flash']['warning'] = "Dimension de l'image minimum 400 x 400 et maximum 12000 x 12000 ! ";
      }
    }
    else
    {
      echo $_SESSION['flash']['warning'] = "Veuillez mettre une image!" ;
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
    <title>Mon profil"</title>
  </head>
  <body>
  <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
      <?php require_once('menu.php') ?>
<div class="container" style="margin-top: 30px;">
<div class="row">
  
</div>

<div>
<div class="card-body" style="border: dashed #002f6c 3px;">
<h5 class="card-title ml-2" style="text-align: center;">Modifiez votre photo de profil</h5>
<?php
if(file_exists("SIFORUM/public/avatar/". $_SESSION['id'] . "/" . $_SESSION['avatar']) && isset($_SESSION['avatar'])){
  ?>
  <img src="<?php "SIFORUM/public/avatar/". $_SESSION['id'] . "/" . $_SESSION['avatar']; ?>" width="120" style="width: 100%;">
<?php
}else{
 ?>
<img src="public\avatar\default\kisspng-avatar-silhouette-computer-icons-female-id-5ac460f18e5e81.1273438915228193135832.png" width="120"  alt="">
<?php
}
 ?>
 <div class="col-sm-0 col-md-2 col-lg-1"></div>
  <div class="col-sm-12 col-md-8 col-lg-10">
    <form method="post" enctype="multipart/form-data">

        <input id="file" type="file" name="file" class="hide-upload" required>
        <i class="fa fa-plus image-plus"></i>
        <input type="submit" name="avatar" value="Envoyer">

    </form>
  </div>
</div>
 </div>
</div>
</body>
</html>
