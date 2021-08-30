<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
//trim enléve les espaces avant et après
$utilisateur_id = (int) $_SESSION['id'];
if (empty($utilisateur_id)) {
    header('location:menu.php');
    // permet de ne plus accéder à cette page
    exit;
}
$req = $bdd->prepare("SELECT * FROM test.visiteurs WHERE id= ?");
$req->execute(array($utilisateur_id));
$voir = $req->fetch();
// Si on ne trouve rien sur la page profil de l'utilisateur alors on redirige l'utilisateur vers la page menu.php
if (!isset($voir['id'])) {
    header('location:myprofil.php');
    exit;
}
//Création d'un avatar
if (isset($_POST['envoyer'])) {
    $dossier = "../upload/" . $_SESSION['id'] . "/";
    // is_dir c'est pour savoir si le dossier existe
    if (!is_dir($dossier)) {
        //mkdir crée le dossier
        mkdir($dossier);
    }
    // basename reccupére uniquement le nom du fichier
    $fichier = basename($_FILES['avatar']['name']);
    //move_uploaded_file fonction booleen qui dit si oui ou non on a pu déplacer le fichier
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) {
        // supprimer l'image d'avant 
        // file_exists verifie si un fichier existe 
        if (file_exists("../upload/" . $_SESSION['id'] . '/' . $_SESSION['avatar']) && isset($_SESSION['avatar'])) {
            //unlink supprime l'image
            unlink("../upload/" . $_SESSION['id'] . '/' . $_SESSION['avatar']);
        }
        $req = $bdd->prepare("UPDATE test.visiteurs SET avatar = ? WHERE id = ?");
        $req->execute(array($fichier, $_SESSION['id']));
        // Si c'est mis à jour ma variable $_SESSION va se mettre a jour avec $fichier (le nom de l'image)
        $_SESSION['avatar'] = $fichier;
        header('location:edit-profil.php?id=' . $voir['id']);
        exit;
    } else {
        header('location:/');
        exit;
    }
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
    <title>Editer mon profil</title>
</head>
<header>
    <ul class="topnav">
        <li style="float:left">
            <div class="d-flex flex-nowrap bd-highlight"><img src="../pics/heart.png" class="heart">
                <p class="ser">SeriousDate</p>
            </div>
        </li>
        <li style="float:right"><a class="btn btn-link btn-lg btn2" href="menu.php">Menu</a></li></span>
    </ul>
</header>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class='membres'>
                    <div class="membres-corps">
                        <?php
                        if (isset($_SESSION['avatar'])) {
                        ?>

                            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?= '../upload/' . $voir['id'] . '/' . $voir['avatar']; ?>" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <form method="post" enctype="multipart/form-data">
                            <label for="avatar">
                                <h4>1.Ajouter une photo de profil :</h4>
                            </label>
                            fichier : <input type="file" name="avatar" id="avatar">
                            <input type="submit" name="envoyer" value="envoyer le fichier">
                        </form>
                        <form action="description-user.php" method="post">
                            <div class="form-group">
                                <label for="story">
                                    <h4>2.Décrivez-vous :</h4>
                                </label>
                                <textarea id="story" name="story" rows="5" cols="33" placeholder=" Votre description..."></textarea>
                                <label for="face">
                                    <h4>3.Votre description physique :</h4>
                                </label>
                            </div>
                            <label for="yeux" class="yeux">a) Couleur de vos yeux : </label>
                            <div class="form-group y2">
                                <input type="radio" name="yeux" id="bleu" value="bleu" checked><label for="bleu">bleu</label>
                                <input type="radio" name="yeux" id="vert" value="vert"><label for="vert">vert</label>
                                <input type="radio" name="yeux" id="marron" value="marron"><label for="marron">marron</label>
                                <input type="radio" name="yeux" id="gris" value="gris"><label for="gris">gris</label>
                            </div>
                            <label for="hair" class="hair">b) Couleur de vos cheveux : </label>
                            <div class="form-group h2">
                                <input type="radio" name="hair" id="chatain" value="chatain" checked><label for="chatain">chatain</label>
                                <input type="radio" name="hair" id="noir" value="noir"><label for="noir">noir</label>
                                <input type="radio" name="hair" id="blond" value="blond"><label for="blond">blond</label>
                                <input type="radio" name="hair" id="roux" value="roux"><label for="roux">roux</label>
                            </div>
                            <label for="size" class="size">c) Taille (m) : </label>
                            <div class="form-group s2">
                                <input type="radio" name="size" id="size" value="- 1m70" checked><label for="size">- 1m70</label>
                                <input type="radio" name="size" id="size" value="+ 1m70"><label for="size">
                                    + 1m70</label>
                            </div>
                            <label for="body" class="body">d) Morphologie: </label>
                            <div class="form-group b2">
                                <input type="radio" name="body" id="sportif" value="sportif" checked><label for="sportif">sportif.ve</label>
                                <input type="radio" name="body" id="bonVivant" value="bonVivant"><label for="bonVivant">bon.ne vivant.e</label>
                                <input type="radio" name="body" id="normal" value="normal"><label for="normal">normal</label>
                            </div>
                            <label for="hobbies">
                                <h4>4.Vos hobbies :</h4>
                            </label>
                            <div class="form-group ho2">
                                <input type="radio" name="hobbies" id="sport" value="sport" checked><label for="sport">sport</label>
                                <input type="radio" name="hobbies" id="danse" value="danse"><label for="danse">danser</label>
                                <input type="radio" name="hobbies" id="game" value="heux vidéos"><label for="game">jeux vidéos</label>
                                <input type="radio" name="hobbies" id="drink" value="apéro"><label for="drink">l'apéro</label>
                                <input type="radio" name="hobbies" id="culture" value="musée, galeries.."><label for="culture">musées, galeries...</label>
                                <input type="radio" name="hobbies" id="read" value="lecture"><label for="read">lecture</label>
                                <input type="radio" name="hobbies" id="travel" value="voyages"><label for="travel">Voyages</label>
                                <input type="radio" name="hobbies" id="human" value="voyages humanitaire"><label for="human">Voyages humanitaire</label>
                            </div>
                            <input type="submit" value="Valider" class="btn btn-info">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</html>