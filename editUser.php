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
                $id=$_POST['id_user'];
                $listeUsers = $bdd->prepare('SELECT nom, prenom, mail FROM users WHERE id_user='.$id);
                $listeUsers->execute();
                $users=$listeUsers->fetchAll();
                foreach ($users as $user) 
                {
                    echo "<div>
                    <form action='updateUser.php' method='post'>
                        <div class='formInput'>
                            <span for='colFormspan' class='col-sm-2 col-form-span'>Nom</span>
                            <div class='col-sm-10'>
                                <input name='id_user' type='hidden' value='".$id."' >
                                <input type='text' class='form-control' name='nom' id='name' placeholder='Nom' value='".$user['nom']."'>
                            </div>
                        </div>

                        <div class='formInput'>
                            <span for='colFormspan' class='col-sm-2 col-form-span'>Prénom</span>
                            <div class='col-sm-10'>
                                <input type='text' class='form-control' name='prenom' id='firstname' placeholder='Prénom' value='".$user['prenom']."'>
                            </div>
                        </div>

                        <div class='formInput'>
                            <span for='colFormspan' class='col-sm-2 col-form-span'>Email</span>
                            <div class='col-sm-10'>
                                <input type='email' class='form-control' name='mail' id='mail' placeholder='Email' value='".$user['mail']."'>
                            </div>
                        </div>

                        <div class='inscription'>
                            <button type='submit' id='buttonInscri'>M'inscrire</button>
                        </div>  
                    </form>
                </div>";
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