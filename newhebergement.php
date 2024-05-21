<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    include("bdd.php");
    include("header.php");
    ?>
</head>
<body>
<main>
    <center>
        <h1>Nouveaux Hébergement</h1>
        <br>
        <form method="post" action="newhebergement.php" enctype="multipart/form-data">
            <label for="text">Type d'hébergement :</label>

            <?php
            $query = "SELECT codetypeheb, nomtypeheb FROM type_heb";

            $result = $bdd->query($query);

            echo "<select name='type_heb'>";
            while ($donnees = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $donnees['codetypeheb'] . '">' . $donnees['nomtypeheb'] . '</option>';
            }
            echo "</select>";
            ?>
            <br> 
            <label for="text">Nom hébergement</label>
            <input type="text" id="nom" name="nom" required>   
            <br> 
            <label for="text">Nombre de place :</label>
            <input type="text" id="nbplace" name="nbplace" required>
            <br>
            <label for="text">Surface :</label>
            <input type="text" id="surface" name="surface" required>
            <br>
            Internet ? :
            <select name="internet" id="internet" >
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
            <br>
            <label for="text">Année :</label>
            <input type="text" id="annee" name="annee" required>
            <br>
            <label for="secteur">Secteur :</label>
            <select name="secteur" id="secteur" required>
                <option value="Chalets Alpins">Chalets Alpins</option>
                <option value="Parc Montagnard">Parc Montagnard</option>
                <option value="Vielle Canbane">Vielle Canbane</option>
                <option value="HauteVue">HauteVue</option>
            </select>
            <br>
            <label for="orientation">Orientation :</label>
            <select name="orientation" id="orientation" required>
                <option value="Sud">Sud</option>
                <option value="Nord">Nord</option>
                <option value="Ouest">Ouest</option>
                <option value="Est">Est</option>
            </select>
            <br>
            <label for="etat">Etat :</label>
            <select name="etat" id="etat" required>
                <option value="Neuf">Neuf</option>
                <option value="Bonne état">Bonne état</option>
                <option value="Correcte">Correcte</option>
                <option value="Mauvais état">Mauvais état</option>
                <option value="Très mauvais état">Terrible état</option>
            </select>
            <br>
            <label for="text">Description :</label>
            <input type="text" id="description" name="description" required>
            <br>
            <label for="image">Photos :</label>
            <input type="file" name="photo" id="photo" required>
            <br>
            <label for="text">Tarif :</label>
            <input type="text" id="tarif" name="tarif" required>
            <br>
            <br>
            <button type="submit" name="inscription">Enregistré</button>
        </form>
    </center>
</main>
</body>
</html>

<?php
if (isset($_POST['inscription'])) {
   
    $uploadDirectory = "img/";
    $targetFile = $uploadDirectory . basename($_FILES['photo']['name']);

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        include('bdd.php');

        $type_heb = $_POST['type_heb'];
        $nom = $_POST['nom'];
        $nbplace = $_POST['nbplace'];
        $surface = $_POST['surface'];
        $internet = $_POST['internet'];
        $annee = $_POST['annee'];
        $secteur = $_POST['secteur'];
        $orientation = $_POST['orientation'];
        $etat = $_POST['etat'];
        $description = $_POST['description'];
        $photo = $_FILES['photo']['name'];
        $tarif = $_POST['tarif'];

        $sql = "INSERT INTO hebergement (codetypeheb, nomheb, nbplaceheb, surfaceheb, internet, anneeheb, secteurheb, orientationheb, etatheb, descriheb, photoheb, tarifsemheb) 
            VALUES ('$type_heb', '$nom', '$nbplace', '$surface', '$internet', '$annee', '$secteur', '$orientation', '$etat', '$description', '$photo', '$tarif')";

        $resultat = $bdd->query($sql);

        if ($resultat) {
            // Insertion réussie
            echo "<center> Inscription réussie !</center>";
        } else {
            // Erreur lors de l'insertion
            $errorInfo = $bdd->errorInfo();
            printf("Erreur : %s\n", $errorInfo[2]);
        }
    } else {
        // Erreur lors du téléchargement du fichier
        echo "Erreur lors du téléchargement du fichier.";
    }
}
?>
<?php include('footer.php'); ?>