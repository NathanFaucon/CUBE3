<?php session_start() ?>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="style.css"/>
		<title>Vidéothèque</title>
	</head>

	<body>
		<div class="menuprincipal d-flex flex-row">
			<div class="menu d-flex flex-column">
				<div class="home d-flex flex-column">
					<img src="home1.png">
				</div>

				<div class="leftbar d-flex flex-column">
					<div><a href='index.php'>Home</a></div><br>
					<?php 
						if(!isset($_SESSION['email'])){
							echo "<div><a href='connexion.php'>Me connecter</a></div><br>
							<div><a href='inscription.php'>M'inscrire</a></div><br>";
						}
						else
						{
							echo "<div><a href='ajoutFilm.php'>Ajouter un film</a></div><br>
                            <div><a href='listUser.php'>Utilisateurs</a></div><br>
							<div><a href='listFilms.php'>Films</a></div><br>
							<div><a href='logOut.php'>Se déconnecter</a></div><br>";
						}
					?>
				</div>
			</div>
			<div class="en-tete d-flex flex-grow-1">	
				<p class='titre-entete'>
				<img src="video.png">
				Vidéothèque
				</p>
			</div>
		</div>
		<div class="cards-container d-flex flex-row">
		<?php 
			try{
				$bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
            }
                catch(Exception $e)
			{
				echo "Connection failed: " . $e->getMessage();
			}
                $listeFilms = $bdd->prepare("SELECT films.* FROM films, liste WHERE liste.id_user_liste=".$_SESSION['id_user']." AND films.id_film=liste.id_film_liste");
                $listeFilms->execute();
                $films=$listeFilms->fetchAll();
                foreach ($films as $film) 
                {
                    echo "
                    <form method='post' action='deleteListe.php'>
                    <div class='card' style='width: 18rem;'>
                        <img src='images/".$film['image_film']."' class='card-img-top' alt='...'>
                        <div class='card-body'>
                        <h5 class='card-title'>".$film['nom_film']."</h5>
                        <p class='card-text'>".$film['synopsis']."</p>
                        <button type='submit' value='".$film['id_film']."' name='id_film'>Enlever de ma liste</button>
                        </div>
                    </div></form>";
                }
			
			
		?>
		</div>
		
    </body>
</html>