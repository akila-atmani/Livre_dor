<?php
$host = "localhost"; 
$dbname = "livreor"; 
$username = "root"; 
$password = ""; 
session_start();
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    die("<p>Vous devez être connecté pour poster un commentaire.</p>");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le commentaire
    $message_recupere = htmlspecialchars($_POST['commentaire'], ENT_QUOTES, 'UTF-8');
    $username = $_SESSION['username']; // Récupérer le nom d'utilisateur depuis la session
    // Préparer et exécuter la requête d'insertion
  
    if (!empty($message_recupere)) {
        $sql = "INSERT INTO messages (name, message ) VALUES (:nom, :var_commentaire)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom', $username, PDO::PARAM_STR);
        $stmt->bindParam(':var_commentaire', $message_recupere, PDO::PARAM_STR);
        
        // Exécuter la requête
        if ($stmt->execute()) {
            echo "<p>Merci pour votre commentaire !</p>";
        } else {
            echo "<p>Une erreur est survenue lors de l'ajout de votre commentaire.</p>";
        }
    } else {
        echo "<p>Le commentaire ne peut pas être vide.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/commentaire.css"> 
    <title>Ajouter un commentaire</title>
</head>
<body>
<nav>
        <ul>
            <li><a href="livre_or.php">Accueil</a></li>
            <li><a href="connexion.php">Deconnexion</a></li>
            <li><a href="profil.php">Modifier ton profil</a></li>
        </ul>
    </nav>
    <h1>Ajouter un commentaire</h1>
    
    <form action="commentaire.php" method="POST">
        <label for="commentaire">Votre commentaire :</label><br>
        <textarea name="commentaire" id="commentaire" rows="5" cols="40" required></textarea><br><br>
        <button type="submit">Envoyer</button>
    </form>
</body>
<footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> Livre d'Or. Tous droits réservés.</p>
           
        </div>
    </footer>
</html>

