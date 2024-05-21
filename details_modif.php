<?php
session_start();
include("bdd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['NOHEB'])) {
        $NOHEB = $_POST['NOHEB'];
        $NOMHEB = $_POST['NOMHEB'];
        $NBPLACEHEB = $_POST['NBPLACEHEB'];
        $SURFACEHEB = $_POST['SURFACEHEB'];
        $INTERNET = $_POST['INTERNET'];
        $ANNEEHEB = $_POST['ANNEEHEB'];
        $SECTEURHEB = $_POST['SECTEURHEB'];
        $ORIENTATIONHEB = $_POST['ORIENTATIONHEB'];
        $ETATHEB = $_POST['ETATHEB'];
        $DESCRIHEB = $_POST['DESCRIHEB'];
        $TARIFSEMHEB = $_POST['TARIFSEMHEB'];

        $query = "UPDATE hebergement 
        SET NOMHEB = :NOMHEB, 
            NBPLACEHEB = :NBPLACEHEB, 
            SURFACEHEB = :SURFACEHEB, 
            INTERNET = :INTERNET, 
            ANNEEHEB = :ANNEEHEB, 
            SECTEURHEB = :SECTEURHEB, 
            ORIENTATIONHEB = :ORIENTATIONHEB, 
            ETATHEB = :ETATHEB, 
            DESCRIHEB = :DESCRIHEB,
            TARIFSEMHEB = :TARIFSEMHEB
        WHERE NOHEB = :NOHEB";

        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':NOHEB', $NOHEB, PDO::PARAM_INT);
        $stmt->bindParam(':NOMHEB', $NOMHEB, PDO::PARAM_STR);
        $stmt->bindParam(':NBPLACEHEB', $NBPLACEHEB, PDO::PARAM_INT);
        $stmt->bindParam(':SURFACEHEB', $SURFACEHEB, PDO::PARAM_INT);
        $stmt->bindParam(':INTERNET', $INTERNET, PDO::PARAM_STR);
        $stmt->bindParam(':ANNEEHEB', $ANNEEHEB, PDO::PARAM_INT);
        $stmt->bindParam(':SECTEURHEB', $SECTEURHEB, PDO::PARAM_STR);
        $stmt->bindParam(':ORIENTATIONHEB', $ORIENTATIONHEB, PDO::PARAM_STR);
        $stmt->bindParam(':ETATHEB', $ETATHEB, PDO::PARAM_STR);
        $stmt->bindParam(':DESCRIHEB', $DESCRIHEB, PDO::PARAM_STR);
        $stmt->bindParam(':TARIFSEMHEB', $TARIFSEMHEB, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success_message = "Mise à jour réussie !";
        } else {
            echo "Échec de la mise à jour";
        }
    }
}

if (isset($_GET['id'])) {
    $code = $_GET['id'];
    $query = "SELECT * FROM hebergement WHERE NOHEB = :code";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':code', $code, PDO::PARAM_INT);
    $stmt->execute();

    $hebergement = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <?php include("header.php"); ?>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <main>
            <section class="annonces">
                <div class="annonce">
                    <form method="post" action="">
                        <input type="hidden" name="NOHEB" value="<?php echo $hebergement['NOHEB']; ?>">
                        <img src='img/<?php echo $hebergement['PHOTOHEB']; ?>'><br>
                        <h3><input type="text" name="NOMHEB" value="<?php echo $hebergement['NOMHEB']; ?>"></h3>
                        <p>Pour <input type="text" name="NBPLACEHEB" value="<?php echo $hebergement['NBPLACEHEB']; ?>"> personnes</p>
                        <p>Surface (m²) : <input type="text" name="SURFACEHEB" value="<?php echo $hebergement['SURFACEHEB']; ?>"></p>
                        <p>Internet : <input type="text" name="INTERNET" value="<?php echo $hebergement['INTERNET']; ?>"></p>
                        <p>Année : <input type="text" name="ANNEEHEB" value="<?php echo $hebergement['ANNEEHEB']; ?>"></p>
                        <p>Orientation : <input type="text" name="ORIENTATIONHEB" value="<?php echo $hebergement['ORIENTATIONHEB']; ?>"></p>
                        <p>État : <input type="text" name="ETATHEB" value="<?php echo $hebergement['ETATHEB']; ?>"></p>
                        <p>Secteur : <input type="text" name="SECTEURHEB" value="<?php echo $hebergement['SECTEURHEB']; ?>"></p>
                        <p>Description : <textarea name="DESCRIHEB"><?php echo $hebergement['DESCRIHEB']; ?></textarea></p>
                        <p>Tarif : <input type="text" name="TARIFSEMHEB" value="<?php echo $hebergement['TARIFSEMHEB']; ?>"> € par nuit</p>
                        <input type="submit" value="Mettre à jour">
                        <?php
                            if (isset($success_message)) {
                                echo $success_message;
                            }
                        ?>
                    </form>
                </div>
            </section>
        </main>
        <?php include('footer.php'); ?>
    </body>
    </html>
    <?php
    $stmt->closeCursor();
}
?>
