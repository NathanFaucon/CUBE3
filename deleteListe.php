<?php
try{
    $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
    $sql= 'DELETE FROM liste WHERE id_film_liste='.$_POST['id_film'];
    $bdd->exec($sql);
    echo 'Suppression réussie';
    header('Location: maListe.php');
    exit();
    }
    catch(PDOException $e)
            {
                echo "<br>". $sql . "<br>" . $e->getMessage();
            }
            $bdd=null;
?>