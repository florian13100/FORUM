<?php
if(isset($_SESSION['id'])){
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/SIFORUM/index">Accueil</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/SIFORUM/profil">Profil<span class="sr-only">(current)</span></a>
      </li>
      <li>
        <a href="/SIFORUM/utilisateurs" class="nav-link">Rechercher</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/SIFORUM/f_forum/forum">Forum</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto mr-0 p-2">
      <li class="nav-item">
        <a href="/SIFORUM/profil" class="nav-link btn btn-warning font-weight-bold">
          <?php
          if(isset($_SESSION['id'])){
            echo  $_SESSION['nom'] . " " . $_SESSION['prenom'];
          }
           ?>
        </a>
      </li>
    </ul>
      <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link btn btn-outline-danger text-danger" href="/SIFORUM/deconnexion">Deconnexion</a>
      </li>
    </ul>
  </div>
</nav>
  <?php
}else{
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/SIFORUM/index">Accueil</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-md-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/SIFORUM/inscription">S'inscrire<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/SIFORUM/connexion">Se connecter</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/SIFORUM/motdepasse">Mot de passe oublié</a>
      </li>

    </ul>
  </div>
</nav>
  <?php
 }
 ?>
