<?php
session_start();
include("bdd.php");
include("header.php");

if (isset($_GET['search'])) {
    $orientation = isset($_GET['orientation']) ? $_GET['orientation'] : '';
    $secteur = isset($_GET['secteur']) ? $_GET['secteur'] : '';
    $internet = isset($_GET['internet']) ? 1 : 0; // 1 si coché, sinon 0
    
    $query = "SELECT * FROM hebergement WHERE 1=1";

    if (!empty($orientation)) {
        $query .= " AND ORIENTATIONHEB = :orientation";
    }

    if (!empty($secteur)) {
        $query .= " AND SECTEURHEB = :secteur";
    }

    if (isset($internet)) {
        $query .= " AND INTERNET = :internet";
    }

    $stmt = $bdd->prepare($query);

    if (!empty($orientation)) {
        $stmt->bindValue(':orientation', $orientation, PDO::PARAM_STR);
    }

    if (!empty($secteur)) {
        $stmt->bindValue(':secteur', $secteur, PDO::PARAM_STR);
    }

    if (isset($internet)) {
        $stmt->bindValue(':internet', $internet, PDO::PARAM_INT);
    }

    $stmt->execute();
if ($stmt->errorCode() !== '00000') {
    print_r($stmt->errorInfo());
}


    $stmt->execute();
} else {
    // Afficher tous les hébergements si aucun critère n'est spécifié
    $query = "SELECT * FROM hebergement";
    $stmt = $bdd->query($query);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<main>

        <h2>Recherche d'hébergements</h2>
        <form method="GET" action="hebergement.php">
            <label for="orientation">Orientation :</label>
            <select name="orientation" id="orientation">
                <option value="">Tous</option>
                <option value="Nord">Nord</option>
                <option value="Sud">Sud</option>
                <option value="Ouest">Ouest</option>
                <option value="Est">Est</option>
            </select>

            <label for="secteur">Secteur :</label>
            <select name="secteur" id="secteur">
                <option value="">Tous</option>
                <option value="Chalets Alpins">Chalets Alpins</option>
                <option value="Parc Montagnard">Parc Montagnard</option>
                <option value="Vielle Canbane">Vielle Canbane</option>
                <option value="HauteVue">HauteVue</option>
            </select>

            <label for="internet">Avec Internet:</label>
            <input type="checkbox" name="internet" id="internet" value="1"> 

            <button type="submit" name="search">Rechercher</button>
        </form>
        <section class="annonces">
        <?php
        while ($donnees = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="annonce">';
            echo "<img src='img/" . $donnees['PHOTOHEB'] . "'><br>";
            echo "<h3>" . $donnees['NOMHEB'] . "</h3>";
            echo "<p>Secteur : <span class='secteur'>" . $donnees['SECTEURHEB'] . "</span></p>";
            echo "<p>Tarif : " . $donnees['TARIFSEMHEB'] . " € par semaine</p>";
            echo "<a href='details_hebergement.php?id=" . $donnees['NOHEB'] . "' class='lien-details'>Voir les détails</a>";
            echo '</div>';
        }
        $stmt->closeCursor();
        ?>
        </section>
</main>
<?php include('footer.php'); ?>
</body>
</html>
