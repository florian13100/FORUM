<?php
session_start();

session_destroy();

header('Location: /SIFORUM/index');
exit;



 ?>
