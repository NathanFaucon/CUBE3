<?php session_start();
unset($_SESSION['email']);
unset($_SESSION['admin']);
header('Location: index.php');
exit();
?>
