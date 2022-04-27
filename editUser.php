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
                $id=$_POST['id_user'];
                if(isset($_POST['deleteUser']))
                {
                    
                    if($id!=1)
                    { 
                        echo $id;
                        $sql= 'DELETE FROM users WHERE id_user='.$_POST['id_user'];
                        $bdd->exec($sql);
                        echo 'Suppression réussie';
                        header('Location: listUser.php');
                        exit();
                    }
                   
                }else if(isset($_POST['editUser']))
                {
                    echo "<div>
                    <form action='updateUser.php' method='post'>
                        <div class='formInput'>
                            <span for='colFormspan' class='col-sm-2 col-form-span'>Nom</span>
                            <div class='col-sm-10'>
                                <input name='id_user' type='hidden' value='".$id."' >
                                <input type='text' class='form-control' name='nom' id='name' placeholder='Nom' value='".$_POST['nom']."'>
                            </div>
                        </div>

                        <div class='formInput'>
                            <span for='colFormspan' class='col-sm-2 col-form-span'>Prénom</span>
                            <div class='col-sm-10'>
                                <input type='text' class='form-control' name='prenom' id='firstname' placeholder='Prénom' value='".$_POST['prenom']."'>
                            </div>
                        </div>

                        <div class='formInput'>
                            <span for='colFormspan' class='col-sm-2 col-form-span'>Email</span>
                            <div class='col-sm-10'>
                                <input type='email' class='form-control' name='mail' id='mail' placeholder='Email' value='".$_POST['mail']."'>
                            </div>
                        </div>

                        <div class='formInput'>
                            <span for='colFormspan' class='col-sm-2 col-form-span'>Mot de passe</span>
                            <div class='col-sm-10'>
                                <input type='password' class='form-control' name='password' id='mdp' placeholder='Mot de passe'>
                            </div>
                        </div>

                        <div class='inscription'>
                            <button type='submit' id='buttonInscri'>M'inscrire</button>
                        </div>  
                    </form>
                    <script src='script.js'></script>
                    <script src='inscription.js'></script>
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