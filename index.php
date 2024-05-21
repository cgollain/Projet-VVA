<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association VVA - Village Vacances Alpes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    session_start();
    include("bdd.php");
    include("header.php");
    ?>
  <div id="banner">
    <div class="banner-content">
        <h1>Bienvenue chez Association VVA</h1>
        <p>Votre destination de vacances dans les Alpes et au-delà</p>
        <a href="hebergement.php" class="btn">Découvrir nos offres</a>
    </div>
</div>


    <section id="a-propos">
        <h2>À Propos de Nous</h2>
        <p>L'Association VVA gère une collection de villages de vacances situés dans les plus belles régions des Alpes françaises et d'autres massifs montagneux. Nous sommes dédiés à offrir des vacances authentiques et respectueuses de l'environnement.</p>
    </section>

    <section id="reservations">
        <h2>Réservations en Ligne</h2>
        <p>Découvrez notre nouvel outil de réservation en ligne pour planifier vos vacances avec facilité. Vous pouvez choisir parmi une variété d'hébergements, suivre vos réservations et profiter d'une expérience de réservation transparente.</p>
        <a href="hebergement.php">Réserver maintenant</a> <!-- Lien vers la page de réservation -->
    </section>


    <?php
    include('footer.php');
    ?>
</body>
</html>
