<html>
    <body>
        <p>
            <a href="listUser.php">Retourner à la liste des utilisateurs</a>
        </p>
        <?php 
            try{
                $bdd=new PDO('mysql:host=localhost; dbname=videotheque; charset=utf8', 'root', 'root');
                $sql="UPDATE users SET mail='".$_POST['mail']."',password='".$_POST['password']."',nom='".$_POST['nom']."',prenom='".$_POST['prenom']."' WHERE id_user=".$_POST['id_user'];
                $prep = $bdd->prepare($sql);
                $prep->execute();
                echo $prep->rowCount() . " records UPDATED successfully<br>Modification effectuée";
                header('Location: listUser.php');
                exit();
            }
            catch(PDOException $e)
            {
                echo "<br>". $sql . "<br>" . $e->getMessage();
            }
            $bdd=null;
            
        ?>
    </body>
</html>