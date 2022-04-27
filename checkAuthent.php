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
            
            $listeUsers = $bdd->prepare('SELECT * FROM users');
            $listeUsers->execute();
            $users=$listeUsers->fetchAll();
            foreach ($users as $user) 
            {
                if ((strcmp($user['mail'],$_POST['email'])==0) && (strcmp($user['password'],$_POST['pass'])==0))
                {
                    $flag=1;
                    $email_user=$user['mail'];
                    $isAdmin=$user['admin'];
                } 
            }
            if ($flag==0)
            {
                echo "Mauvais identifiants";
            }
            else{
            $_SESSION['email']=$email_user;
            $_SESSION['admin']=$isAdmin;
            header('Location: index.php');
            exit();     
            }
        ?>
            
        
        
    </body>
</html>