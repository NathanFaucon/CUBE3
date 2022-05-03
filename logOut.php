<?php session_start();
unset($_SESSION['email']);
unset($_SESSION['isAdmin']);
unset($_SESSION['id_user']);
header('Location: index.php');
exit();
?>
