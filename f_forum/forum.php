<?php
session_start();
include('../bd/connexionDB.php');

$req = $DB->query("SELECT * FROM forum ORDER BY ordre");
$req = $req->fetchAll();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Forum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
  </head>
    <body>
    <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
  <?php require_once('../menu.php') ?>
  <div class="container">
    <div class="row">   
      <div class="col-sm-0 col-md-0 col-lg-0"></div>
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h1 style="text-align: center">Forum</h1>
        <a href="creer_topic" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="margin-bottom: 10px;">Créer un topic</a>
        <div class="table-responsive">
          <table class="table table-striped">
            <tr>
    <tr>
      <th>ID</th>
      <th>Titre</th>
    </tr>
    <?php
    foreach($req as $r){
     ?>
     <tr>
       <td><?php echo $r['id'] ?></td>
       <td><a href="sujet?id=<?php echo $r['id'] ?>"><?php echo $r['titre'] ?></a></td>
     </tr>
     <?php
      }
      ?>
</table>
          </div>
        </div>
      </div>
    </div>
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
