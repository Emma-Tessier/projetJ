<?php
$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//trim enléve les espaces avant et après
$utilisateur_id = (int)trim($_GET['id']);
if (empty($utilisateur_id)) {
    header('location: menu.php');
    // permet de ne plus accéder à la page suivante
    exit;
}
$req = $bdd->prepare("SELECT * FROM visiteurs v LEFT JOIN caracteristiques c ON  v.id = c.id where v.id = ?");
$req->execute(array($utilisateur_id));
$voir = $req->fetch();

// Si on ne trouve rien sur la page profil de l'utilisateur alors on redirige l'utilisateur vers la page menu.php
if (!isset($voir['email'])) {
    header('location: menu.php');
    exit;
}
// $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// $cara_id = (int) $_SESSION['id'];
$cara_id = $utilisateur_id;
if (empty($cara_id)) {
    header('location: myProfil.php?id=' . $voir['id'] .'');
    // permet de ne plus accéder à cette page
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../../ProjetJ/css/menu.css" type="text/css">
    <title>Profil de <?= $voir['fname'] ?></title>
</head>
<body>
<header>
<ul class="topnav">
  <li style="float:left"><div class="d-flex flex-nowrap bd-highlight"><img src="../pics/heart.png" class="heart"><p class="ser">SeriousDate</p></div></li>
  <li style="float:right"><a class="btn btn-link btn-lg btn2" href="menu.php">Menu</a></li></span>
</ul>   
 </header>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class='membres'>
                        <div>
                            Prénom : <?= $voir['fname'] ?>
                        </div>
                        <div>
                            Age : <?= $voir['age']?> 
                        </div>
                        <div>
                            Département: <?= $voir['ville'] ?>
                    </div>
                    <div>
                            Couleurs des yeux : <?= $voir['yeux'] ?>
                    </div>
                    <div>
                            Couleurs des cheveux : <?= $voir['hair'] ?>
                    </div>
                    <div>
                            Taille : <?= $voir['size'] ?>
                    </div>
                    <div>
                            Morphologie : <?= $voir['body'] ?>
                    </div>
                    <div>
                            Hobbies : <?= $voir['hobbies'] ?>
                    </div>
                    <div>
                            Description : <?= $voir['story'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>