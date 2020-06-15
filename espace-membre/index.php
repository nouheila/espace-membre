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

  if(isset($_POST['inscription']))
  {
    if(empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['adresse']) || empty($_POST['email']) || empty($_POST['mdp'])){
      $message = 'tous les champs sont obligatoire';
    }
    else{
      //verifier si l'email n'est pas déjà utilisé
      $query = $db->prepare('SELECT email FROM user WHERE email = ?');
      $query->execute([
        $_POST['email']
      ]);
      $emailExists = $query->fetch();

      //si $emailExists == false, on autorise l'insertion du nouvel utilisateur
      if(!$emailExists){
        $query = $db->prepare('INSERT INTO user (nom, prenom, adresse, email, mdp) VALUES (?, ?, ?, ?, ?)');
        $result = $query->execute(
        	[
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['adresse'],
        		$_POST['email'],
            hash('md5', $_POST['mdp']),
            
            
          ]
          
        );
       
        header('Location:membre.php');
        
       
        
      }
      else{
        echo 'email déjà utilisé';
      }
    }
    
  }
  if(isset($_POST['connexion']))
  {
    if(empty($_POST['email']) || empty($_POST['mdp'])){
      $message = 'email et mot de passe obligatoires';
    }
    else{
        //ici chercher la couple email/md5(password) correspondant aux données du formulaire

        $query = $db->prepare('SELECT * FROM user WHERE email = :email AND mdp = :mdp');
        $query->execute([
          'mdp' => md5($_POST['mdp']),
          'email' => $_POST['email'],
        ]);
        $user = $query->fetch();

        
       
        
        
        //si couple email/md5(password) trouvé, connecter l'utilisateur
        if($user != false){
         
          header('Location:membre.php');
          $_SESSION['user'] = $user['prenom'];
          
        }

        else{
          $message = 'mauvais identifiants !';
        }

    }

  }
  
?>

<!DOCTYPE html>
<html>
<head>
	<title>Inscription/connexion</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
</head>
<body>
  <p><?php if(isset($message)){echo $message;}?></p>
  <div class="cont">
    <div class="form sign-in">
      <h2>Connexion</h2>
      <form action="" method="POST">
      <label for="email">
        <span>Email</span>
        <input type="email" name="email" id="email" required>
      </label>
      <label for="mdp">
        <span>Mot de passe </span>
        <input type="password" name="mdp" id="mdp" required>
      </label>
      <button class="submit" type="submit" name="connexion">Connexion</button>
    </form>
      <p class="forgot-pass">Mot de passe oublié ?</p>

      <div class="social-media">
        <ul>
          <li><img src="images/facebook.png"></li>
          <li><img src="images/twitter.png"></li>
          <li><img src="images/linkedin.png"></li>
          <li><img src="images/instagram.png"></li>
        </ul>
      </div>
    </div>
   
    <div class="sub-cont">
      <div class="img">
        <div class="img-text m-up">
          <h2>Pas Inscrit?</h2>
          <p>Inscrivez-vous pour accéder à votre espace perso !</p>
        </div>
        <div class="img-text m-in">
          <h2>Inscrit?</h2>
          <p>Connectez-vous pour accéder à votre espace perso !</p>
        </div>
        <div class="img-btn">
          <span class="m-up">Inscription</span>
          <span class="m-in">Connexion</span>
        </div>
      </div>
      
      <div class="form sign-up">
        <h2>Inscription</h2>
        <form  method="POST" action=""> 
        <label for="nom">
          <span>Nom</span>
          <input type="nom" name="nom" id="nom">
        </label>
        <label for="prenom">
          <span>Prénom</span>
          <input type="prenom" name="prenom" id="prenom" >
        </label>
        <label for="adresse">
          <span>Adresse</span>
          <input type="adresse" name="adresse" id="adresse" >
        </label>
        <label for="email">
          <span>Email</span>
          <input type="email" name="email" id="email">
        </label>
        <label for="mdp">
          <span>Mot de passe</span>
          <input type="password" name="mdp" id="mdp">
        </label>
        <button type="submit" name="inscription" class="submit">Inscription</button>
      
      </form>
      
      </div>
    </div>
  </div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>