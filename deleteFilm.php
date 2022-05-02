<?php
    $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
    $sql= 'DELETE FROM films WHERE id_film='.$_POST['id_film'];
    $bdd->exec($sql);
    echo 'Suppression réussie';
    header('Location: listFilm.php');
    exit();
?>