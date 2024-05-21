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
        $code = $_GET['id'];
        $query = "SELECT * FROM hebergement WHERE noheb = :code";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_INT);
        $stmt->execute();

        $hebergement = $stmt->fetch(PDO::FETCH_ASSOC); 
        echo '<div class="annonce">';
        echo "<img src='img/" . $hebergement['PHOTOHEB'] . "'><br>";
        echo '<div>';
        $stmt->closeCursor();
        ?>

        <?php
        $query = "SELECT NORESA, USER, DATEDEBSEM, NOHEB, CODEETATRESA, DATERESA, DATEARRHES, MONTANTARRHES, NBOCCUPANT, TARIFSEMRESA FROM resa WHERE noheb = :code";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_INT);
        $stmt->execute();
        $location = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<p>Numéro de réservation : " . $location['NORESA'] . "<br></p>";
        echo "<p>Réservation de  : " . $location['USER'] . "<br></p>";
        echo "<p>Date début de location : " . $location['DATEDEBSEM'] . "<br></p>";
        echo "<p>Date payant arrhes : " . $location['DATEARRHES'] . "<br></p>";
        echo "<p>Montant Arrhes : " . $location['MONTANTARRHES'] . "<br></p>";
        echo "<p>Nombre d'occupant : " . $location['NBOCCUPANT'] . "<br></p>";

        echo "<form method='POST'>";
        echo "<p>État réservation : ";

        // Afficher la combobox
        echo "<select name='etapeReservation'>";
        $query = "SELECT CODEETATRESA, NOMETATRESA FROM etat_resa";
        $stmt = $bdd->prepare($query);
        $stmt->execute();

        while ($codeetat = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = ($codeetat['CODEETATRESA'] == $location['CODEETATRESA']) ? "selected" : "";
            echo '<option value="' . $codeetat['CODEETATRESA'] . '" ' . $selected . '>' . $codeetat['NOMETATRESA'] . '</option>';
        }

        echo "</select>";
        echo "</p>";

        echo '<input type="submit" name="update" value="Mettre à jour">';
        echo '</form>';

        if (isset($_POST['update'])) {
            // Si le formulaire a été soumis, mettre à jour la valeur dans la base de données
            $nouvelleEtape = $_POST['etapeReservation'];

            $updateQuery = "UPDATE resa SET CODEETATRESA = :nouvelleEtape WHERE NORESA = :noresa";
            $updateStmt = $bdd->prepare($updateQuery);
            $updateStmt->bindParam(':nouvelleEtape', $nouvelleEtape, PDO::PARAM_INT);
            $updateStmt->bindParam(':noresa', $location['NORESA'], PDO::PARAM_INT);
            $updateStmt->execute();
            
            echo "Mise à jour de l'état effectuée.";
        }

        $stmt->closeCursor();
        ?>
    </section>
</main>
<?php include('footer.php'); ?>
</body>
</html>
