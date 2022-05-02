<?php 
    session_start();
    try{
        $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
        $sql="INSERT INTO liste (id_film_liste, id_user_liste) VALUES ('".$_POST["id_film"]."','"$_SESSION["id_user"]"');";
        $bdd->exec($sql);
        header('Location: index.php');
        exit();  
    }catch(PDOException $e)
    {
        echo "<br>". $sql . "<br>" . $e->getMessage();
    }
?>
