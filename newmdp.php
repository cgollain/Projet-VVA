<?php
session_start();
$_SESSION['message'] = '';

include('bdd.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mdp = md5($_POST['mdp']); 
    $user = $_SESSION['user']; 

  
    $sql = "UPDATE compte SET ANCIENMDP = MDP WHERE USER = :user";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array(':user' => $user));


    $sql = "UPDATE compte SET MDP = :mdp WHERE USER = :user";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array(':mdp' => $mdp, ':user' => $user));

    $_SESSION['message'] = 'Mot de passe créé avec succès!';
    header('Location: deconnexion.php');
    exit;
}
?>
<center>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un mot de passe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Créer un mot de passe</h1>
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="mdp">Nouveau mot de passe :</label>
        <input type="password" name="mdp" required><br><br>

        <label for="rgpd">Politique de Confidentialité :</label>
        <input type="checkbox" id="rgpd" name="rgpd" required>
        <label for="rgpd"><a href="politique_confidentialite.php" target="_blank">J'accepte la Politique de Confidentialité</a></label><br>
        
        <label for="cgu">Conditions Générales d'Utilisation (CGU) :</label>
        <input type="checkbox" id="cgu" name="cgu" required>
        <label for="cgu"><a href="cgu.php" target="_blank">J'accepte les Conditions Générales d'Utilisation (CGU)</a></label><br>

        <label for="charte">Charte de Responsabilité :</label>
        <input type="checkbox" id="charte" name="charte" required>
        <label for="charte"><a href="charte_responsabilite.php" target="_blank">J'accepte la Charte de Responsabilité</a></label><br><br>





        <button type="submit">Créer le mot de passe</button>
        
    </form>
</main>
<?php include('footer.php'); ?>
</body>
</html>
