
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Village Vacance - Connexion</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include('header.php'); ?>
        <main>
            <h1>Connexion</h1>
            <?php if (isset($_SESSION['erreur'])): ?>
                <div class="erreur"><?php echo $_SESSION['erreur']; ?></div>
            <?php endif; ?>
            <form method="post" action="connexion.php">
                <label for="user">Nom du compte :</label>
                <input type="text" name="user" required>
                <label for="password">Mot de passe :</label>
                <input type="password" name="mdp" required>
                <button type="submit" name="connexion">Connexion</button>
            </form>
        </main>
  
    </body>
    </html>
    <center>
    <?php
session_start();
$_SESSION['erreur'] = ""; 

if (isset($_POST['connexion'])) {
    include('bdd.php'); 

    if (isset($_POST['user']) && isset($_POST['mdp'])) {
        $user = $_POST['user'];
        $mdp = md5($_POST['mdp']);

        $sql = "SELECT * FROM compte WHERE USER = :user AND (MDP = :mdp)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute(array(':user' => $user, ':mdp' => $mdp));
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user['USER'];

            if ($user['TYPECOMPTE'] == "adm") {
                $_SESSION['typecompte'] = "admin";
            } else if ($user['TYPECOMPTE'] == "vac") {
                $_SESSION['typecompte'] = "vacancier";
            } else if ($user['TYPECOMPTE'] == "ges") {
                $_SESSION['typecompte'] = "gestionnaire";
            }

     
            if (empty($user['ANCIENMDP'])) {
                header('Location: newmdp.php'); 
                exit;
            } else {
                header('Location: index.php'); 
                exit;
            }
        } else {
            $_SESSION['erreur'] = 'Mot de passe ou compte incorrect';
            header('Location: connexion.php'); 
            exit;
        }
    }
}
?>
     <?php include('footer.php'); ?>