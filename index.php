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
							if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']==1){
								echo "<div><a href='ajoutFilm.php'>Ajouter un film</a></div><br>
								<div><a href='listUser.php'>Utilisateurs</a></div><br>
								<div><a href='listFilms.php'>Films</a></div><br>";
							}
							echo "<div><a href='maListe.php'>Ma Liste</a></div><br>
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
			$listeFilms = $bdd->prepare('SELECT * FROM films');
			$listeFilms->execute();
			$films=$listeFilms->fetchAll();
			foreach ($films as $film) 
			{
				$listeGenres = $bdd->prepare('SELECT * FROM genre');
				$listeGenres->execute();
				$genres=$listeGenres->fetchAll();
				
				$listeFilmGenres = $bdd->prepare('SELECT * FROM film_genre WHERE id_film='.$film['id_film']);
				$listeFilmGenres->execute();
				$FilmGenres=$listeFilmGenres->fetchAll();

				$listeRealisateurs = $bdd->prepare('SELECT * FROM realisateurs');
				$listeRealisateurs->execute();
				$realisateurs=$listeRealisateurs->fetchAll();
				
				$listeRealisePar = $bdd->prepare('SELECT * FROM realise_par WHERE id_film='.$film['id_film']);
				$listeRealisePar->execute();
				$realisepar=$listeRealisePar->fetchAll();
				

				echo "
				<form method='post' action='favFilm.php'>
				<div class='card' style='width: 18rem;'>
					<figure class='hover-img'>
						<img src='images/".$film['image_film']."' class='card-img-top' alt='...'>
						<figcaption>
							<p>".$film['synopsis']."</p>
							<p>".date("d-m-Y", strtotime($film['date_film']))."</p>
							<p>";
							
							foreach ($FilmGenres as $FilmGenre) {
								if ($FilmGenre['id_film']==$film['id_film'])
								foreach ($genres as $genre) {
									if ($genre['id_genre']==$FilmGenre['id_genre'])
									echo $genre['nom_genre']."<br>";
								}
							}
							echo "</p><p>";
							foreach ($realisepar as $realise) {
								if ($realise['id_film']==$film['id_film'])
								foreach ($realisateurs as $realisateur) {
									if ($realisateur['id_real']==$realise['id_real'])
									echo $realisateur['nom_real'];
								}
							}
						echo "</p>
						</figcaption>
					</figure>
					<div class='card-body'>
					<h5 class='card-title'>".$film['nom_film']."</h5>";
						if(isset($_SESSION['email'])){
						echo "<div class='test'>
						<form method='post' action='note.php'>
							<input type='hidden' value='".$film['id_film']."' name='id_film'>
							<input type='hidden' value='1' name='valeur'>
							<input type='image' src='images/etoile.png' class='etoile'>
						</form>
						<form method='post' action='note.php'>
							<input type='hidden' value='".$film['id_film']."' name='id_film'>
							<input type='hidden' value='2' name='valeur'>
							<input type='image' src='images/etoile.png' class='etoile'>
						</form>
						<form method='post' action='note.php'>
							<input type='hidden' value='".$film['id_film']."' name='id_film'>
							<input type='hidden' value='3' name='valeur'>
							<input type='image' src='images/etoile.png' class='etoile'>
						</form>
						<form method='post' action='note.php'>
							<input type='hidden' value='".$film['id_film']."' name='id_film'>
							<input type='hidden' value='4' name='valeur'>
							<input type='image' src='images/etoile.png' class='etoile'>
						</form>
						<form method='post' action='note.php'>
							<input type='hidden' value='".$film['id_film']."' name='id_film'>
							<input type='hidden' value='5' name='valeur'>
							<input type='image' src='images/etoile.png' class='etoile'>
						</form></div>
						";}
						echo"
						<div>Note : ";
						$moyenne = $bdd->prepare('SELECT ROUND(AVG(valeur_note),1) AS moyenne FROM notes WHERE id_film='.$film['id_film']);
						$moyenne->execute();
						$avg=$moyenne->fetchAll();
						foreach($avg as $moy)
						{
							if(1){
								echo $moy['moyenne'];
							}
						}
						echo "</div>
					
					
					</form>
					";
					if(isset($_SESSION['email'])){
					echo "<form method='post' action='favFilm.php'>
					<button type='submit' value='".$film['id_film']."' name='id_film'>Ajouter à ma liste</button></form>";
					}
					echo "</div>
				</div>";
			}
		?>
		</div>
		
    </body>
</html>