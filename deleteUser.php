<?php
    $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
    $id=$_POST['id_user'];
    $sql= 'DELETE FROM users WHERE id_user='.$_POST['id_user'];
    $bdd->exec($sql);
    echo 'Suppression réussie';
    header('Location: listUser.php');
    exit();
?>