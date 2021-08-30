<?php
session_start();
$connected = false;
if (isset($_SESSION['connected']) && $_SESSION['connected']) {
    $connected = $_SESSION['connected'];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../../ProjetJ/css/main.css" type="text/css">
</head>
<body>
<header>
    <ul class="topnav">
        <li style="float:left">
            <div class="d-flex flex-nowrap bd-highlight"><img src="../pics/heart.png" class="heart">
                <p class="ser">SeriousDate</p>
            </div>
        </li>
        <li><a href="../savoirPlus.html">En savoir plus</a></li>
        <li><a href="../contact.html">Contact</a></li>
        <span <?php echo (!$connected ? '' : 'none'); ?>>
            <li style="float:right"><a class="btn btn-info btn-lg btn2" href="#" role="button" data-toggle="modal" data-target="#login">Connexion</a></li>
        </span>
    </ul>
</header>
    <div id="start">
        <div class="accroche">
            <h3><img src="../pics/heart.png" class="logo">SeriousDate</h3>
            <p>Connectez-vous. <br /> Rencontrez de nouvelles personnes </p>
        </div>
        <span <?php echo (!$connected ? '' : 'none'); ?>>
            <a class="btn btn-danger btn-lg btn1" href="#" role="button" data-toggle="modal" data-target="#register">Créer gratuitement un compte</a></span>
    </div>
    <!-- Modal inscription -->
    <div class="modal fade" id="register" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="register.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Inscription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fname">Prénom :</label>
                            <input type="text" name="fname" id="fname" pattern="[a-zA-Z\u00C0-\u00FF '\-]{1,30}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="dateNais">Date de naissance :</label>
                            <input type="text" name="dateNais" id="dateNais" placeholder=" jj/mm/aaaa" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" Onblur="CalculAge()">
                        </div>
                        <div class="form-group">
                            <label for="age">Age :</label>
                            <input type="text" name="age" id="age" readonly  class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="radio" name="sexe" id="F" value="F"  checked><label for="F">Féminin</label>
                            <input type="radio" name="sexe" id="M" value="M" ><label for="M">Masculin</label>
                        </div>
                        <div class="form-group">
                            <label for="ville">Département : </label>
                            <?php
                            $depts = json_decode(file_get_contents('https://geo.api.gouv.fr/departements'));
                            $html = '';
                            $html .= '<select name="ville" id="ville" class="form-control">';
                            $html .= '';
                            $html .= '<option value="00">-- Choisir un département --</option>';
                            foreach ($depts as $dept) {
                                $html .= '<option value="' . $dept->code . '">' . $dept->nom . '</option>';
                            }
                            $html .= '</select>';

                            echo $html;
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="mail">Email :</label>
                            <input type="email" name="mail" id="mail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Mot de passe :</label>
                            <input type="password" name="pass" id="pass" pattern="[A-Za-z0-9@$*!? ]{8,}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="check">Vérification mot de passe :</label>
                            <input type="password" name="verifmp" id="verifmp" pattern="[A-Za-z0-9@$*!? ]{8,}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Valider" class="btn btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Connexion -->
    <div class="modal fade" id="login" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="login.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Connexion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mail">Email :</label>
                            <input type="email" name="mail" id="mail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Mot de passe :</label>
                            <input type="password" name="pass" id="pass" pattern="[A-Za-z0-9@$*!? ]{8,}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Valider" class="btn btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer><p class="pix">Les photos ont été prises sur pixabay.com .</p></footer>
    <script src="../js/index.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>