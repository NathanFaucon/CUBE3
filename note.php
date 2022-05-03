<?php 
    session_start();
    try{
        $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
        $verif=$bdd->prepare("SELECT * FROM notes WHERE id_film=".$_POST['id_film']);
        $verif->execute();
        $res=$verif->fetchAll();
        foreach($res as $re){
           if($_SESSION['id_user']==$re['id_user'] && $_POST['id_film']==$re['id_film']){
               $flag=1; 
           }
        }

        if ($flag==0){
            $sql="INSERT INTO notes (id_user, id_film, valeur_note) VALUES ('".$_SESSION['id_user']."','".$_POST['id_film']."','".$_POST['valeur']."')";
            $bdd->exec($sql);
            header('Location: index.php');
            exit();  
        }else{
            $sql="UPDATE notes SET valeur_note = ".$_POST['valeur']." WHERE id_user=".$_SESSION['id_user']." AND id_film=".$_POST['id_film'].";";
            $bdd->exec($sql);
            header('Location: index.php');
            exit(); 
        }
    }catch(PDOException $e)
    {
        echo "<br>". $sql . "<br>" . $e->getMessage();
    }
?>
