<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=resa;charset=utf8mb4', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
