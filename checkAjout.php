<?php session_start() ?>
<html>
    <body>
        <p>
            <a href="connexion.php">Retourner au formulaire de connexion</a>
        </p>
        <?php 
            $flag=0;
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
                if (strcmp($film['nom_film'],$_POST['nom'])==0)
                {
                    $flag=1;  
                } 
            }
            if ($flag==1)
            {
                echo "Film déjà enregistré";
            }
            else
            {
                $sql= "INSERT INTO films (nom_film, date_film, synopsis, image_film, duree_film ) VALUES ('".$_POST['nom']."','".$_POST['date']."','".$_POST['synopsis']."','".$_FILES['image']['name']."','".$_POST['duree']."');";
                $bdd->exec($sql);
                $listeFilms = $bdd->prepare('SELECT * FROM films');
                $listeFilms->execute();
                $films=$listeFilms->fetchAll();
                foreach ($films as $film) 
                {
                    if (strcmp($film['nom_film'],$_POST['nom'])==0)
                    {
                        $id_film=$film['id_film'];  
                    } 
                }
                $genres = $_POST['genre'];
                $requete="";
                foreach($genres as $genre)
                {
                    $requete = $requete."INSERT INTO film_genre (id_film, id_genre) VALUES (".$id_film.",".$genre."); ";
                }
                $reals = $_POST['real'];
                foreach($reals as $real)
                {
                    $requete = $requete."INSERT INTO realise_par (id_film, id_real) VALUES (".$id_film.",".$real."); ";
                }
                try{
                    $bdd->exec($requete);
                    header('Location: index.php');
                    exit();
                }
                catch(Exception $e)
                {
                    echo "Insertion failed: " . $e->getMessage();
                }
            }
        ?>
    </body>
</html>