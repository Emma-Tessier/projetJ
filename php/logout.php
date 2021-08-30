<?php
session_start();
// Détruit les variables de session
session_unset();
// Détruit la session
session_destroy();
header('location:index.php');
