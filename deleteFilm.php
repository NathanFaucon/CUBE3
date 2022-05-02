<?php
try{
    $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
    $sql= 'DELETE FROM realise_par WHERE id_film='.$_POST['id_film'];
    $bdd->exec($sql);
    $sql= 'DELETE FROM film_genre WHERE id_film='.$_POST['id_film'];
    $bdd->exec($sql);
    $sql= 'DELETE FROM films WHERE id_film='.$_POST['id_film'];
    $bdd->exec($sql);
    echo 'Suppression réussie';
    header('Location: listFilms.php');
    exit();
    }
    catch(PDOException $e)
            {
                echo "<br>". $sql . "<br>" . $e->getMessage();
            }
            $bdd=null;
?>