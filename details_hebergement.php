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
        echo "<h3>" . $hebergement['NOMHEB'] . "</h3>";
        echo "<p>Pour " . $hebergement['NBPLACEHEB'] . " personnes <br></p>";
        echo "<p>Secteur : " . $hebergement['SECTEURHEB'] . "<br></p>";
        echo "<p>Internet : " . $hebergement['INTERNET'] . "<br></p>";
        echo "<p>Année  : " . $hebergement['ANNEEHEB'] . "<br></p>";
        echo "<p>Orientation : " . $hebergement['ORIENTATIONHEB'] . "<br></p>";
        echo "<p>Etat : " . $hebergement['ETATHEB'] . "<br></p>";
        echo "<p>Description : " . $hebergement['DESCRIHEB'] . "<br></p>";
        echo "<p>Tarif : " . $hebergement['TARIFSEMHEB'] . " € par nuit</p>";
        echo '<div>';
    
        $stmt->closeCursor();
        ?>

        <h4>Réserver ce logement ? ☺</h4>
        <form method="post" action="details_hebergement.php?id=<?php echo $code; ?>" enctype="multipart/form-data">
        <?php
          if (isset($_SESSION["user"])) 
          {
            $query_reserved_dates = "SELECT DATEDEBSEM FROM resa WHERE NOHEB = :noheb";
            $stmt_reserved_dates = $bdd->prepare($query_reserved_dates);
            $stmt_reserved_dates->bindParam(':noheb', $code, PDO::PARAM_INT);
            $stmt_reserved_dates->execute();
            $reserved_dates = $stmt_reserved_dates->fetchAll(PDO::FETCH_COLUMN);

            $query_all_dates = "SELECT datedebsem, datefinsem FROM semaine";
            $result = $bdd->query($query_all_dates);

            echo "<select name='semaine'>";
            while ($semaine = $result->fetch(PDO::FETCH_ASSOC)) {
                $datedeb = $semaine['datedebsem'];
                $datefin = $semaine['datefinsem'];

                // Vérifie si la date est déjà réservée
                if (!in_array($datedeb, $reserved_dates)) {
                    echo '<option value="' . $datedeb . '">' . $datedeb . ' - ' . $datefin . '</option>';
                }
            }
            echo "</select>";
            echo "<p>Combien serez-vous ?</p>";
            echo '<input type="number" id="NBOCCUPANT" name="NBOCCUPANT" required><br>';
            echo "<button type='submit' name='resa'>Réserver</button>";
          } else {
              echo ("Vous devez être connecté pour réserver cette hébergement !");
          }
        ?>
    </form>

    <?php
    if (isset($_POST['resa'])) {
        include('bdd.php');


        $user = $_SESSION["user"];
        $selectedDate = $_POST['semaine']; 

        $noheb = $hebergement['NOHEB'];
        $CODEETATRESA = "bl";
        $DATERESA = date('Y-m-d');
        $DATEARRHES = date('Y-m-d');
        $MONTANTARRHES = 5;
        $NBOCCUPANT = $_POST['NBOCCUPANT'];
        $TARIFSEMRESA = 6;

        // Correction de la requête
        // Correction de la requête SQL pour la table resa
        $sql = "INSERT INTO resa (USER, DATEDEBSEM, noheb, CODEETATRESA, DATERESA, DATEARRHES, MONTANTARRHES, NBOCCUPANT, TARIFSEMRESA) 
                VALUES (:user, :selectedDate, :noheb, :CODEETATRESA, :DATERESA, :DATEARRHES, :MONTANTARRHES, :NBOCCUPANT, :TARIFSEMRESA)";

        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
        $stmt->bindParam(':noheb', $noheb, PDO::PARAM_INT);
        $stmt->bindParam(':CODEETATRESA', $CODEETATRESA, PDO::PARAM_STR);
        $stmt->bindParam(':DATERESA', $DATERESA, PDO::PARAM_STR);
        $stmt->bindParam(':DATEARRHES', $DATEARRHES, PDO::PARAM_STR);
        $stmt->bindParam(':MONTANTARRHES', $MONTANTARRHES, PDO::PARAM_INT);
        $stmt->bindParam(':NBOCCUPANT', $NBOCCUPANT, PDO::PARAM_INT);
        $stmt->bindParam(':TARIFSEMRESA', $TARIFSEMRESA, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<center> Réservation réussie !</center>";
            $last_id = $bdd->lastInsertId();
            echo "<center> Numéro de réservation : " . $last_id . "</center>";
        } else {
            // Erreur lors de l'insertion
            $errorInfo = $stmt->errorInfo();
            printf("Erreur : %s\n", $errorInfo[2]);
        }
    }
    ?>
</section>
</main>
<?php include('footer.php'); ?>
</body>
</html>
