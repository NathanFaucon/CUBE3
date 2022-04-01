<?php
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$mail = $_POST['mail'];
	$password = $_POST['password'];

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=videotheque;charset=utf8', 'root', 'root');
	}
	catch(Exception $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
	
	$req = $bdd->prepare("INSERT INTO users(nom, prenom, mail, password) VALUES(:nom, :prenom, :mail, :password)");

	$req->bindParam(':nom',$nom);
	$req->bindParam(':prenom',$prenom);
    $req->bindParam(':mail',$mail);
    $req->bindParam(':password',$password);

    $req->execute();

    header('Location: index.php');
            exit();
?>