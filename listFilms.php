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
        <ul>
        <li><a href="home.php">Accueil</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="profil.php">Profil</a></li>
            <?php if(!isset($_SESSION['email']))
            {
                echo "<li><a href='connexion.php'>Connexion</a></li>
                <li><a href='inscription.php'>Inscription</a></li>";
            } 
            else
            {
                echo "<li><a href='logOut.php'>Se déconnecter</a></li>";
                if($_SESSION['isAdmin']==1)
                {
                    echo "<li><a href='listUser.php'>Utilisateurs</a></li>";
                }
            }
            ?>
        </ul>
        <?php 
            try{
                $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
                $listeFilms = $bdd->prepare('SELECT * FROM films');
                $listeFilms->execute();
                $films=$listeFilms->fetchAll();
                echo "<table>
                <tr>
                    <th>Nom</th>
                    <th>Réalisateur(s)</th>
                    <th>Date de sortie</th>
                    <th>Durée</th>
                    <th>Synopsis</th>
                    <th>Moderation</th>
                </tr>";
                foreach ($films as $film)  
                {
                    
                    $listeReals = $bdd->prepare('SELECT id_real FROM realise_par WHERE id_film='.$film['id_film']);
                    $listeReals->execute();
                    $reals=$listeReals->fetchAll();
                    echo "<tr>
                    <td><input type='hidden' value='".$film['id_film']."' name='id_film'>".$film['nom_film']."</td>
                    <td>";
                    foreach ($reals as $real)  
                    {
                        $listeReals = $bdd->prepare('SELECT nom_real FROM realisateurs WHERE id_real='.$real['id_real']);
                        $listeReals->execute();
                        $realis=$listeReals->fetchAll();
                        foreach($realis as $reali){
                            echo $reali['nom_real'];
                            echo "<br>";
                        }
                    }
                    echo "</td>
                    <td>".$film['date_film']."</td>
                    <td>".$film['duree_film']." minutes</td>
                    <td>".$film['synopsis']."</td>
                    <input type='hidden' value='".$film['nom']."' name='nom'>
                    <input type='hidden' value='".$film['prenom']."' name='prenom'>
                    <input type='hidden' value='".$film['mail']."' name='mail'>
                    <form action='editFilm.php' method='POST'>
                    <td><button type='submit' value='".$film['id_film']."' name='id_film' class='bouton'>Modifier</button><br></form>
                    <form action='deleteFilm.php' method='POST'>
                    <button type='submit' value='".$film['id_film']."' name='id_film' class='bouton'>Supprimer</button></td>
                    </tr></form>";
                    }
                    
                   
                
                echo "</table>";
            }
            catch(PDOException $e)
            {
                echo "<br>". $sql . "<br>" . $e->getMessage();
            }
            $bdd=null;
        ?>
    </body>
</html>