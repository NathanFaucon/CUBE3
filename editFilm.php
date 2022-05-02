<?php session_start() ?>
<html>
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
        <?php 
            try
            {
                $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
                $id=$_POST['id_film'];
                $listeFilms = $bdd->prepare('SELECT * FROM films WHERE id_film='.$id);
                $listeFilms->execute();
                $films=$listeFilms->fetchAll();
                foreach ($films as $film) 
                {
                    echo "<form method='post' action='updateFilm.php' enctype='multipart/form-data'>
                    <div class='formInput'>
                        <span for='colFormspan' class='col-sm-2 col-form-span'>Nom du film</span>
                        <input type='hidden' value='".$_POST['id_film']."' name='id_film'>
                        <div class='col-sm-10'>
                            <input class='form-control' placeholder='Nom' name='nom' value='".$film['nom_film']."' required>
                        </div>
                    </div>
                    <div class='formInput'>
                        <span for='colFormspan' class='col-sm-2 col-form-span'>Durée du film (en minutes)</span>
                        <div class='col-sm-10'>
                            <input class='form-control' name='duree' type='number' value=".$film['duree_film']." required>
                        </div>
                    </div>
                    <div class='formInput'>
                        <span for='colFormspan' class='col-sm-2 col-form-span'>Réalisateur</span>
                        <div class='col-sm-10'>
                        <select name='real[]' multiple>
                            <option value='0' selected disabled hidden>Sélectionnez un réalisateur:</option>";
                                try
                                {
                                    $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
                                }
                                catch(Exception $e)
                                {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }
                                
                                $listeReals = $bdd->prepare('SELECT * FROM realisateurs ORDER BY nom_real ASC');
                                $listeReals->execute();
                                $reals=$listeReals->fetchAll();
                                foreach ($reals as $real) 
                                {
                                    echo "<option value=".$real['id_real'].">".$real['nom_real']."</option>";
                                }
                            echo "
                            </select>
                        </div>
                    </div>
                    <div class='formInput'>
                        <span for='colFormspan' class='col-sm-2 col-form-span'>Date de sortie</span>
                        <div class='col-sm-10'>
                            <input class='form-control' name='date' type='date' value=".$film['date_film']." required>
                        </div>
                    </div>
                    <div class='formInput'>
                        <span for='colFormspan' class='col-sm-2 col-form-span'>Genre du film</span>
                        <div class='col-sm-10'>
                        <select name='genre[]' multiple>
                            <option value='0' selected disabled hidden>Sélectionnez un genre:</option>";
                            try
                            {
                                $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
                            }
                            catch(Exception $e)
                            {
                                echo "Connection failed: " . $e->getMessage();
                            }
                            
                            $listeGenres = $bdd->prepare('SELECT * FROM genre');
                            $listeGenres->execute();
                            $genres=$listeGenres->fetchAll();
                            foreach ($genres as $genre) 
                            {
                                echo "<option value=".$genre['id_genre'].">".$genre['nom_genre']."</option>";
                            }
                        echo "
                        </select>
                        </div>
                    </div>
                    <div class='formInput'>
                        <span for='colFormspan' class='col-sm-2 col-form-span'>Synopsis</span>
                        <div class='col-sm-10'>
                            <input class='form-control' placeholder='Synopsis du film' name='synopsis' value='".$film['synopsis']."' required>
                        </div>
                    </div>
                    <div class='formInput'>
                        <span for='colFormspan' class='col-sm-2 col-form-span'>Image du film</span>
                        <div class='col-sm-10'>
                            <input class='form-control' name='image' type='file' accept='.jpg, .jpeg, .png' value=".$film['image_film']." required>
                        </div>
                    </div>
                    <div class='inscription'>
                        <button type='submit'>Ajouter le film</button>
                    </div>
                </form>	   ";
                }
                
            }
            catch(PDOException $e)
            {
                echo '<br>'. $sql . '<br>' . $e->getMessage();
            }
            $bdd=null;
            
        ?>
    </body>
</html>