<?php
session_start();
// Vérif et sécurisation des variables $_POST isset : existe & empty : vide
if (isset($_POST['fname']) && !empty($_POST['fname'])) {
    //Reccuperation de la donnée en la protégeant des failles XSS avec htmlspecialchars
    $fname = htmlspecialchars($_POST['fname']);
}
if (isset($_POST['age']) && !empty($_POST['age'])) {
    $age = htmlspecialchars($_POST['age']);
}
if (isset($_POST['sexe']) && !empty($_POST['sexe'])) {
    $sexe = htmlspecialchars($_POST['sexe']);
}
if (isset($_POST['pass']) && !empty($_POST['pass'])) {
    $pass = hash('sha512', htmlspecialchars($_POST['pass']));
}
if (isset($_POST['mail']) && !empty($_POST['mail'])) {
    $mail = htmlspecialchars($_POST['mail']);
}
if (isset($_POST['verifmp']) && !empty($_POST['verifmp'])) {
    $verifmp = hash('sha512', htmlspecialchars($_POST['verifmp']));
}
if (isset($_POST['dateNais']) && !empty($_POST['dateNais'])) {
    $dateNais = htmlspecialchars($_POST['dateNais']);
}
if (isset($_POST['ville']) && !empty($_POST['ville'])) {
    $ville = htmlspecialchars($_POST['ville']);
}


// Vérification que le mail existe déjà dans la base de données
$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$reqmail = $bdd->prepare("SELECT * FROM test.visiteurs WHERE email = ?");
$reqmail->execute(array($mail));
// rowcount : Compte le nombre de colonne qui existe 
$mailexist = $reqmail->rowCount();
if ($mailexist == 0) {
    // Vérification que le deuxiéme mot de pass est bien le même que le premier
    if ($pass == $verifmp) {
        $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        // On ajout d\'une entrée dans la table visiteurs
        $requete = $bdd->prepare('INSERT INTO test.visiteurs(fname, age, sexe, email,pass,verifmp, dateNais, ville) VALUES(?,?,?,?,?,?,?,?)');
        $requete->execute([$fname, $age, $sexe, $mail, $pass, $verifmp, $dateNais, $ville]);
        // echo "Vous êtes bien enregistré";
         // Démarre le système de sessions
         session_start();
         // $_SESSION : lit la base de données && fetch() : Récupère la ligne suivante
         var_dump($_SESSION);
         $_SESSION['connected'] = true;
         $_SESSION['id'] = $bdd->lastInsertId();
         $_SESSION['fname'] = $fname;
         $_SESSION['sexe'] = $sexe;
         $_SESSION['mail'] = $mail;
         session_commit();
        header('location:menu.php?user=ok');
    } else {
        echo "Votre deuxiéme mot de passe n'est pas valide";
    }
} else {
    echo "Adresse mail déjà utilisée";
}
