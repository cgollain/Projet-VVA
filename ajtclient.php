<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include("header.php");
    ?>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
function generatePassword() {
    $length = 12;
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialChars = '!@#$%^&*()_+{}|:<>?-=[];\',./';
    $password = '';

    $allChars = $uppercase . $lowercase . $numbers . $specialChars;

    // Ajoute au moins un caractère de chaque type
    $password .= $uppercase[mt_rand(0, strlen($uppercase) - 1)];
    $password .= $lowercase[mt_rand(0, strlen($lowercase) - 1)];
    $password .= $numbers[mt_rand(0, strlen($numbers) - 1)];
    $password .= $specialChars[mt_rand(0, strlen($specialChars) - 1)];

    // Complète le reste du mot de passe avec des caractères aléatoires
    for ($i = 0; $i < ($length - 4); $i++) {
        $password .= $allChars[mt_rand(0, strlen($allChars) - 1)];
    }

    // Mélange les caractères pour plus de sécurité
    $password = str_shuffle($password);

    return $password;
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('bdd.php');
    if (isset($_POST['USER']) && isset($_POST['NOMCPTE']) && isset($_POST['PRENOMCPTE']) && isset($_POST['TYPECOMPTE'])) {
        $mdp = generatePassword();
        $mdp_hash = md5($mdp);
        

        $user = $_POST['USER'];
        $nom = $_POST['NOMCPTE'];
        $prenom = $_POST['PRENOMCPTE'];
        $type_compte = $_POST['TYPECOMPTE'];
        $date_inscrip = date("Y-m-d");
        $date_ferme = $date_inscrip; 
        $adr_mail = isset($_POST['ADRMAILCPTE']) ? $_POST['ADRMAILCPTE'] : null;
        $no_tel = isset($_POST['NOTELCPTE']) ? $_POST['NOTELCPTE'] : null;
        $no_port = isset($_POST['NOPORTCPTE']) ? $_POST['NOPORTCPTE'] : null;
        
        
        $stmt = $bdd->prepare("INSERT INTO compte (USER, MDP, NOMCPTE, PRENOMCPTE, DATEINSCRIP, DATEFERME, TYPECOMPTE, ADRMAILCPTE, NOTELCPTE, NOPORTCPTE, ANCIENMDP) 
                              VALUES (:user, :mdp, :nom, :prenom, :date_inscrip, :date_ferme, :type_compte, :adr_mail, :no_tel, :no_port, NULL)");
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':mdp', $mdp_hash);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':date_inscrip', $date_inscrip);
        $stmt->bindParam(':date_ferme', $date_ferme);
        $stmt->bindParam(':type_compte', $type_compte);
        $stmt->bindParam(':adr_mail', $adr_mail);
        $stmt->bindParam(':no_tel', $no_tel);
        $stmt->bindParam(':no_port', $no_port);
        $stmt->execute();

        echo "<center>";
        echo "<p>Le client $nom $prenom a été créé avec succès!</p>";
        echo "<p>Nom d'utilisateur : $user</p>";
        echo "<p>Mot de passe : $mdp</p>";  
    } else {
        echo "<p>Tous les champs obligatoires doivent être remplis.</p>";
    }
}
?>


<center>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <label for="user">Utilisateur :</label>
    <input type="text" id="user" name="USER" required><br><br>

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="NOMCPTE" required><br><br>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="PRENOMCPTE" required><br><br>

    <label for="type_compte">Type de compte :</label>
    <select id="type_compte" name="TYPECOMPTE">
        <option value="admin">Admin</option>
        <option value="gestionnaire">Gestionnaire</option>
        <option value="vacancier">Vacancier</option>
    </select><br><br>

    <label for="adr_mail">Adresse mail :</label>
    <input type="email" id="adr_mail" name="ADRMAILCPTE"><br><br>

    <label for="no_tel">Numéro de téléphone :</label>
    <input type="tel" id="no_tel" name="NOTELCPTE"><br><br>

    <label for="no_port">Numéro de portable :</label>
    <input type="tel" id="no_port" name="NOPORTCPTE"><br><br>

    <input type="submit" value="Créer le client">
</form>
</center>
</body>
</html>
<?php include('footer.php'); ?>
