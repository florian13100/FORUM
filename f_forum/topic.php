<?php
  session_start();
  include('../bd/connexionDB.php');
  $get_id_forum = (int) trim(htmlentities($_GET['id_forum'])); 
  $get_id_topic = (int) trim(htmlentities($_GET['id_topic']));
  
  if(empty($get_id_forum) || empty($get_id_topic)){
    header('Location: forum');
    exit;
  }
  
  $req = $DB->query("SELECT t.*, DATE_FORMAT(t.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom, U.nom
    FROM topic T
    LEFT JOIN utilisateur U ON U.id = T.id_user
    WHERE t.id = ? AND t.id_forum = ?
    ORDER BY t.date_creation DESC", 
    array($get_id_topic, $get_id_forum));
  $req = $req->fetch();
  
  if(!isset($req['id'])){
    header('Location: /forum/' . $get_id_forum);
    exit;
  }
  // *********************************************************************
  // On vient sélectionner les informations nécessaire pour afficher les commentaires// postés sur ce topic// *********************************************************************
  $req_commentaire = $DB->query("SELECT TC.*, DATE_FORMAT(TC.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom, U.nom, U.avatar, U.id
    FROM topic_commentaire TC
    LEFT JOIN utilisateur U ON U.id = TC.id_user
    WHERE id_topic = ?
    ORDER BY date_creation DESC",
    array($get_id_topic));
  $req_commentaire = $req_commentaire->fetchAll();

  if(!empty($_POST)){
    extract($_POST);
    $valid = true;

    if(isset($_POST['ajout-commentaire'])){
      $text = (String) trim($text);

      if(empty($text)){
        $valid = false;
        $er_commentaire = "Il faut mettre un commentaire";
      }elseif(iconv_strlen($text, 'UTF-8') <= 3){
        $valid = false;
        $er_commentaire = "Il faut mettre plus de 3 caractères";
      }

      $text = htmlentities($text);

      if($valid){

        $date_creation = date('Y-m-d H:i:s');

        $DB-> insert("INSERT INTO topic_commentaire (id_topic, id_user, text, date_creation) VALUES (?, ?, ?, ?)",
          array($get_id_topic, $_SESSION['id'], $text, $date_creation));

          header("Refresh:0");

          exit;

      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <base href="/"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
   <title>Topic</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
  <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
    <?php
      require_once('../menu.php');    
    ?>
    <div class="container">
      <div class="row">   
        <div class="col-sm-0 col-md-0 col-lg-0"></div>
        <div class="col-sm-12 col-md-12 col-lg-12">
         <h1 style="text-align: center"> <span class="text-warning">Sujet</span> : <?= $req['titre'] ?></h1>
          <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px"><h3>Contenu</h3>
            <div style="border-top: 2px solid #eee; padding: 10px 0"><?= $req['contenu'] ?></div>
           <div style="color: #002f6c; font-size: 12px; text-align: right"><?= $req['date_c'] ?>
              par 
              <?= $req['prenom'] . " " . $req['nom'] ?></div>
          </div>   
          <?php if(isset($_SESSION['id'])){
            ?>
          <!-- On vient afficher les commentaire avec un foreach -->
          <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
          <h3>Participer à la discussion</h3>
          <?php 
          if(isset($er_commentaire)){
            ?>
            <div class="er-msg"><?= $er_commentaire ?></div>
            <?php
          }
          ?>
          <form method="post">
          <div class="form-group"></div>
          <textarea class="form-control" name="text" rows="4"></textarea>
          <div class="form-group">
          <button class="btn btn-primary" style="margin: 10px;" type="submit" name="ajout-commentaire">Envoyer</button>
          </div>
          </div>
          </form>
          </div>
          <?php 
          }
        ?>
          <div class="table-responsive" style="margin: 10px;">
          <table class="table table-striped">
          <?php foreach($req_commentaire as $rc){
            ?>
            <tr>
            <td style="width: 100px;"><img src="<?="../SIFORUM/public/avatar/" . $rc['id'] . "/" . $rc['avatar']; ?>" width="70" height="70" class="border border-warning" alt=""></td>
            <td><?= $rc['nom'] . " " . $rc['prenom'] ?></td><td><?= $rc['text'] ?></td> 
                       
            <td class=""><?= $rc['date_c'] ?> <?php if ($_SESSION['id'] === $rc['id']) { ?><a href="/SIFORUM/f_forum/delete?id=<?= $rc['id']?>" class="btn btn-danger" style="float: right;">Supprimer</a><?php } ?></td></tr>
          <?php }
           
          ?>
          </table>
          </div>
          </div>
        
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script><script src="../js/bootstrap.min.js"></script>
  </body>
</html>

<!-- Ecole: je me suis rendu compte que pendant ces 5 mois, ce n'est pas une technologie vers laquelle je souhaite m'orienter: react Js , je souhaite plutôt m'orienter vers php symfony etc, et le marketing digital et rentrer dans le moule de l'entreprise.
solution: continuer l'alternance jusque septembre pour ne pas changer la situation ni la remuneration, mais je ne passerai pas l'examen (projet) final. 

ce que je propose: me former à la maison gratuitement sur php et le marketing digitale pour apporter une valeure ajoutée à l'entreprise. 
Ma finalitée: rester chez Southern Implants. -->
