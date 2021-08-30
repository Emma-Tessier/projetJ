<?php
session_start();
$connected = false;
if (isset($_SESSION['connected']) && $_SESSION['connected']) {
    $connected = $_SESSION['connected'];
}

$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//Condition pour que l'utilisateur connecté n'apparaisse pas dans la liste des membres
if (isset($_SESSION['id'])) {
    $afficher_membres = $bdd->prepare("SELECT * FROM test.visiteurs WHERE id != ? AND sexe != ?");
    $afficher_membres->execute(array($_SESSION['id'], $_SESSION['sexe']));
} else {
    $afficher_membres = $bdd->prepare("SELECT * FROM test.visiteurs");
    $afficher_membres->execute();
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../../ProjetJ/css/menu.css" type="text/css">
</head>

<body>
    <header>
        <ul class="topnav">
            <li style="float:left">
                <div class="d-flex bd-highlight"><img src="../pics/heart.png" class="heart">
                    <p class="ser">SeriousDate</p><?php 
            echo '<h4 class="hello"> Bonjour <strong>' . $_SESSION['fname'] . ' </strong>! </h4>'; 
            ?>
            <a class="menu" href="#" role="button" data-toggle="modal" data-target="#tchat"><img src="../pics/chat.png" class="tchat" alt="tchat"></a>
                </div>
            </li>
            <li class="nav-item"><a class="nav-link menu" data-toggle="modal" data-target="#staticBackdrop"><img src="../pics/profil.png" class="profil" alt="profil"></a> </li>
            <span>
                <li style="float:right"><a class="btn btn-link btn-lg btn6" href="logout.php" role="button">Deconnexion</a></li>
            </span>
            <!-- Modal Profil -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Paramètres</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <li class="myProfil"><a href="myProfil.php">Mon profil</a></li>
                        </div>
                        <div class="modal-body">
                            <li class="editProfil"><a href="edit-profil.php">Editer mon profil</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </ul>
    </header>
    <?php
    if (isset($_GET['user']) && !empty($_GET['user'])) {
        if ($_GET['user'] == 'ok') {
            echo '<div class="alert alert-success" role="alert">
                Bienvenue <strong>' . $_SESSION['fname'] . ' </strong> sur le site SeriousDate ! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>';
        }
    }

    ?>
 <!-- Modal tchat -->
 <div class="modal fade" id="tchat" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="menu.php" method="post">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="form-group">
                            <label class="tchat2" for="tchat">Le tchat est en construction</label>
                            <img class="img2" src="../pics/maintenance.png.png">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php
            foreach ($afficher_membres as $am) {
            ?>
                <div class="col-sm-3">
                    <div class='membres'>
                        <div>
                            <?php
                            if (isset($am['avatar'])) {
                            ?>
                                <img class="pix2" src="<?= '../upload/' . $am['id'] . '/' . $am['avatar']; ?>" alt="">
                            <?php } else {
                            ?>
                                <div class="avatar"></div>
                            <?php } ?>
                        </div>
                        <div>
                            <?= $am['fname'] ?>
                        </div>
                        <div class="membres-btn">
                            <a href="profil.php?id=<?= $am['id']?>" class="voir"><button type="button" class="btn btn-outline-primary">Profil</button></a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>