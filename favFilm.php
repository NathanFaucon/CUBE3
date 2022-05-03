<?php 
    session_start();
    try{
        $flag=0;
        $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
        $verif=$bdd->prepare("SELECT * FROM liste WHERE id_film_liste=".$_POST['id_film']);
        $verif->execute();
        $res=$verif->fetchAll();
        foreach($res as $re){
           if($_SESSION['id_user']==$re['id_user_liste'] && $_POST['id_film']==$re['id_film_liste']){
               $flag=1; 
           }
        }
        

        if($flag==0){
            $sql="INSERT INTO liste (id_film_liste, id_user_liste) VALUES ('".$_POST["id_film"]."','".$_SESSION["id_user"]."');";
            $bdd->exec($sql);
            header('Location: index.php');
            exit();   
        }else{
            echo "<div>Ce film est déjà dans votre liste</div><br>
            <a href='index.php'>Retourner à l'accueil.</a>";
        }
        
    }catch(PDOException $e)
    {
        echo "<br>". $sql . "<br>" . $e->getMessage();
    }
?>
