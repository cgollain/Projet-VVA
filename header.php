<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association VVA - Village Vacances Alpes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php"><img src="img/logo.jpg" alt="Logo de l'association"></a></li> <!-- Ajout du logo -->
            <li><a href="hebergement.php">Hébergement</a></li>

            <?php
            if (isset($_SESSION["typecompte"]) &&  $_SESSION["typecompte"] == "admin") {
                echo ("<li><a href='gestionlocation.php'>Gestion Location</a></li>");
                echo ("<li><a href='modif_hebergement.php'>Modif Hebergement</a></li>");
                echo ("<li><a href='newhebergement.php'>Création Hebergement</a></li>");
            }
             
            if (isset($_SESSION["typecompte"]) && $_SESSION["typecompte"] == "gestionnaire") {
                echo ("<li><a href='gestionlocation.php'>Gestion Location</a></li>");
                echo ("<li><a href='modif_hebergement.php'>Modif Hebergement</a></li>");
                echo ("<li><a href='newhebergement.php'>Création Hebergement</a></li>");
                echo ("<li><a href='ajtclient.php'>Ajout Client</a></li>");

            }
            

            ?>

            <?php
            if (isset($_SESSION["user"])) {
                echo ("<li><a href='deconnexion.php'>Déconnexion</a></li>");
            } else {
                echo ("<li><a href='connexion.php'>Connexion</a></li>");
            }
            ?>
        </ul>
    </nav>
    <div class="title">
    <h1>Association VVA</h1>
    <p>Votre destination de vacances dans les Alpes et au-delà</p>
</div>

</body>
</html>

