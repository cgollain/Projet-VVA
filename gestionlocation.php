<?php 
session_start();
?>

<head>
<meta charset="UTF-8">
    <?php
    include("bdd.php");
    include("header.php");
    
    ?>
</head>
<body>

 <p> Gestion des locations <p>

 <main>
    <section class="annonces">
        <?php
        $query = "SELECT NORESA, NOHEB FROM resa";
        $result = $bdd->query($query);

        while ($donnees = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="annonce">';
            echo "<p>Numéro Réservation: " . $donnees['NORESA'] . "</p>";
            echo "<a href='details_location.php?id=" . $donnees['NOHEB'] . "' class='lien-details'>Géré la location</a>";
            echo '</div>';
            
        }
        $result->closeCursor();
        ?>

    </section>
</main> 

    <?php
    include('footer.php');
    ?>
</body>
</html>
