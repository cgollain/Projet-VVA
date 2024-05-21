<?php
session_start(); // démarrer la session

// détruire la session
session_unset();
session_destroy();

// rediriger l'utilisateur vers la page d'accueil
header('Location: index.php');
exit();
?>
