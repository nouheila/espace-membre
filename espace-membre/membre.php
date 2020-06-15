<?php
session_start();
try
  {
      $db = new PDO('mysql:host=localhost;dbname=huiles-prodigieuses;charset=UTF8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch (Exception $exeption)
  {
      die('Erreur : '. $exeption->getMessage());
  }


?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
  </head>
  <body>
      <h2>Bienvenu <?php if (isset($_SESSION['user'])){echo $_SESSION['user'];}?> </h2>
     
      
  </body>
  </html>