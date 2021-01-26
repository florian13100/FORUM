<?php
session_start();
include('bd/connexionDB.php');
?>
<!DOCTYPE html>
<html>
  <head>
      <base href="/">
    <meta charset="utf-7"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
   <title>Accueil</title>
    <link rel="stylesheet" href="/SIFORUM/css/stylesheet.css">
    <link rel="stylesheet/less" type="text/css" href="/SIFORUM/css/style.less" />
    <script src="//cdn.jsdelivr.net/npm/less@3.13" ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  </head>
    <body>
    <div style="background-color: #002f6c;" class="p-3 mb-2 text-dark">
      <h1 class="text-light text-center"><a href="/SIFORUM/index" class="text-reset">SIFORUM</a></h1>
      </div>
    </div>
  <?php require_once('menu.php') ?>
  <div class="wrapper">
  <h2 style="font-size: 8em;">Your business</h2>
    <svg version="1.1" class="tooth" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         width="128px" height="128px" viewBox="0 0 128 128" style="enable-background:new 0 0 128 128;" xml:space="preserve">

    <circle class="tooth__background" style="fill:#FBE228;" cx="64" cy="64" r="64"/>

    <path class="tooth__leg" style="fill:#CAE08F;" d="M35.43,44.56c0.23,12.01,3.1,52.91,9.01,52.91c6.18,0,21.99-12.63,21.99-12.63h-0.05
        C52.15,73.71,36.55,57.32,35.43,44.56z"/>
    <path class="tooth__leg" style="fill:#FFFFFF;" d="M66.48,84.84h-0.05c0,0,15.81,12.63,21.99,12.63c5.91,0,8.78-40.9,9.01-52.91
        C96.31,57.32,80.71,73.71,66.48,84.84z"/>
        
    <path class="tooth__crown" style="fill:#FFFFFF;" d="M66.38,84.84C51.61,73.29,35.36,56.08,35.36,43.13c0-12.01,8.18-18.14,16.05-17.47
        c7.44,0.64,11.18,5.91,15.02,5.9c3.84,0.01,7.58-5.27,15.02-5.9c7.87-0.68,16.05,5.46,16.05,17.47c0,12.94-16.25,30.16-31.01,41.71
        H66.38z"/>

    <path class="tooth__line" style="fill:none;stroke:#636363;stroke-width:2.8335;stroke-linecap:round;stroke-miterlimit:10;" d="M87.96,49.22
        c-5.36,24.37-41.02,52.35-49.6,52.35c-5.72,0-8.97-39.38-8.97-54.34c0-12.01,8.85-18.49,16.05-17.47
        c7.36,1.04,11.09,5.45,14.91,5.46c3.84,0.01,7.96-4.81,15.02-5.46c8.07-0.74,16,2.57,17.79,17c2,16.17-5.64,54.81-10.71,54.81
        c-6.6,0-33.14-18.55-46-36.84"/>
    </svg>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
   <script src="/SIFORUM/js/index.js"></script>
  </body>
</html>
