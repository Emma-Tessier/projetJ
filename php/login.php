<?php
// Vérif et sécurisation des variables $_POST isset : existe & empty : vide
if (isset($_POST['pass']) && !empty($_POST['pass'])) {
    //Reccuperation de la donnée en la protégeant des failles XSS avec htmlspecialchars
    $pass = htmlspecialchars($_POST['pass']);
}
if (isset($_POST['mail']) && !empty($_POST['mail'])) {
    //Reccuperation de la donnée en la protégeant des failles XSS avec htmlspecialchars
    $mail = htmlspecialchars($_POST['mail']);
}

// Crypter l'adresse mail et le mot de passe
$pass = hash('sha512', $pass);

try {
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $requete = $bdd->prepare('SELECT * FROM test.visiteurs WHERE email = ? AND pass = ?');
    $requete->execute([$mail, $pass]);
    echo "<script>console.log('pass:" . $requete->rowCount() . "')</script>";
    if ($requete->rowCount() == 1) {
        // Démarre le système de sessions
        session_start();
        // $_SESSION : lit la base de données && fetch() : Récupère la ligne suivante
        $row = $requete->fetch();
        $_SESSION['connected'] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['sexe'] = $row['sexe'];
        $_SESSION['mail'] = $row['mail'];
        session_commit();
        header("location:menu.php");
    } else {
        // Route vers index.php
        header('location:index.php');
        // login ou pass faux
    }
} catch (PDOException $err) {
    echo $err->getMessage();
}
