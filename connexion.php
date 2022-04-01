<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
		<meta charset="utf-8">
		<title>Connexion</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="style.css"/>
	</head>
    
    <body>
        <div class="menuprincipal d-flex flex-row">
			<div class="menu d-flex flex-column">
				<div class="home d-flex flex-column">
					<img src="home1.png">
				</div>

				<div class="leftbar d-flex flex-column">
					<div><a href='index.php'>Home</a></div><br>
					<div><a href='connexion.php'>Me connecter</a></div><br>
					<div><a href='inscription.php'>M'inscrire</a></div><br>
                    <div><a href='ajoutFilm.php'>Ajouter un film</a></div>
				</div>
			</div>
			<div class="en-tete d-flex flex-grow-1">	
				<p class='titre-entete'>
				<img src="video.png">
				Vidéothèque
				</p>
			</div>
		</div>

        <div class="formulaire">
            <h1>Connexion</h1>
        </div>

        <form method="POST" action="checkAuthent.php">
            <div class="formInput">
                <span for="colFormspan" class="col-sm-2 col-form-span">Email</span>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>
            </div>

            <div class="formInput">
                <span for="colFormspan" class="col-sm-2 col-form-span">Mot de passe</span>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="mdp" placeholder="Mot de passe" name="pass">
                </div>
            </div>

            <div class="inscription">
                <button type="submit" id="buttonInscri">Se connecter</button>
            </div>	
            
        </form>    
    </body>
    
</html>