<html>
    <body>
        <p>
            <a href="listFilms.php">Retourner à la liste des films</a>
        </p>
        <?php 
            try{
                $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
                $sql="UPDATE films SET nom_film='".$_POST['nom']."', date_film='".$_POST['date']."', synopsis='".$_POST['synopsis']."', image_film='".$_FILES['image']['name']."', duree_film='".$_POST['duree']."' WHERE id_film='".$_POST['id_film']."'";
                $genres = $_POST['genre'];
                $requete="DELETE FROM realise_par WHERE id_film=".$_POST['id_film'].";";
                $requete=$requete."DELETE FROM film_genre WHERE id_film=".$_POST['id_film'].";";
                foreach($genres as $genre)
                {
                    $requete = $requete."INSERT INTO film_genre (id_film, id_genre) VALUES (".$_POST['id_film'].",".$genre."); ";
                }
                $reals = $_POST['real'];
                foreach($reals as $real)
                {
                    $requete = $requete."INSERT INTO realise_par (id_film, id_real) VALUES (".$_POST['id_film'].",".$real."); ";
                }
                try{
                    $bdd->exec($requete);
                    $prep = $bdd->prepare($sql);
                    $prep->execute();
                    header('Location: index.php');
                    exit();
                }
                catch(Exception $e)
                {
                    echo "Insertion failed: " . $e->getMessage();
                }
            }
            catch(PDOException $e)
            {
                echo "<br>". $sql . "<br>" . $e->getMessage();
            }
            var_dump($bdd);
            var_dump($requete);
            $bdd=null;
            
        ?>
    </body>
</html>