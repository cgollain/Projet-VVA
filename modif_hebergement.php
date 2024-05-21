<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include("bdd.php");
    include("header.php");
    ?>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<main>
    <section class="annonces">
        <?php
        $query = "SELECT * FROM hebergement";
        $result = $bdd->query($query);

        while ($donnees = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="annonce">';
            echo "<img src='img/" . $donnees['PHOTOHEB'] . "'><br>";
            echo "<h3>" . $donnees['NOMHEB'] . "</h3>";
            echo "<p>Secteur : <span class='secteur'>" . $donnees['SECTEURHEB'] . "</span></p>";
            echo "<p>Tarif : " . $donnees['TARIFSEMHEB'] . " € par semaine</p>";
            echo "<p>Secteur : " . $donnees['SECTEURHEB'] . "</p>";
            echo "<a href='details_modif.php?id=" . $donnees['NOHEB'] . "' class='lien-details'>Modifier l'hebergement</a>";
            echo '</div>';
            
        }
        $result->closeCursor();
        ?>
    </section>
</main>
<?php include('footer.php'); ?>
</body>
</html>
