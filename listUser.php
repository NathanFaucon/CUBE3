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
                $listeUsers = $bdd->prepare('SELECT * FROM users');
                $listeUsers->execute();
                $users=$listeUsers->fetchAll();
                echo "<form action='editUser.php' method='POST'><table>
                <tr>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Moderation</th>
                </tr>";
                foreach ($users as $user) 
                {
                    echo "<tr>
                    <td><input type='hidden' value='".$user['id_user']."' name='id_user'>".$user['mail']."</td>
                    <td>".$user['admin']."</td>
                    <td>".$user['nom']."</td>
                    <td>".$user['prenom']."</td>
                    <input type='hidden' value='".$user['nom']."' name='nom'>
                    <input type='hidden' value='".$user['prenom']."' name='prenom'>
                    <input type='hidden' value='".$user['mail']."' name='mail'>";
                    
                    if($user['admin']!=1)
                    {
                        echo "
                        <td><input type='submit' value='Modifier' name='editUser".$user['id_user']."'><br>
                        <input type='submit' value='Supprimer' name='deleteUser".$user['id_user']."'></td>
                        </tr>";
                    }
                    
                   
                }
                echo "</table></form>";
            }
            catch(PDOException $e)
            {
                echo "<br>". $sql . "<br>" . $e->getMessage();
            }
            $bdd=null;
        ?>
    </body>
</html>