<?php
session_start();

if (isset($_POST['yeux']) && !empty($_POST['yeux'])) {
    //Reccuperation de la donnée en la protégeant des failles XSS avec htmlspecialchars
    $yeux = htmlspecialchars($_POST['yeux']);
}
if (isset($_POST['hair']) && !empty($_POST['hair'])) {
    $hair = htmlspecialchars($_POST['hair']);
}
if (isset($_POST['size']) && !empty($_POST['size'])) {
    $size = htmlspecialchars($_POST['size']);
}

if (isset($_POST['body']) && !empty($_POST['body'])) {
    $body = htmlspecialchars($_POST['body']);
}
if (isset($_POST['hobbies']) && !empty($_POST['hobbies'])) {
    $hobbies = htmlspecialchars($_POST['hobbies']);
}
if (isset($_POST['story']) && !empty($_POST['story'])) {
    $story = htmlspecialchars($_POST['story']);
}
$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', 
[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        // On ajout d\'une entrée dans la table visiteurs
        $requete = $bdd->prepare('INSERT INTO caracteristiques
        (id, yeux, hair, size, body, hobbies, story) 
        VALUES(?,?,?,?,?,?,?)');
        $requete->execute
        ([ $_SESSION['id'],$yeux, $hair, $size, $body, $hobbies, $story]);
        session_start();
         // $_SESSION : lit la base de données
         $_SESSION['connected'] = true;
         $_SESSION['id'] = $bdd->lastInsertId();
         $_SESSION['yeux'] = $yeux;
         $_SESSION['hair'] = $hair;
         $_SESSION['size'] = $size;
         $_SESSION['body'] = $body;
         $_SESSION['hobbies'] = $hobbies;
         $_SESSION['story'] = $story;
         session_commit();
        header('location:menu.php');

?>