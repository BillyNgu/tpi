<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : Jouer
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['pseudo'];
$play = TRUE;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <title>Blindtest</title>
        <?php require_once './css/css_js.php'; ?>
    </head>
    <body>
        <div class="container">
            <?php require_once './navbar.php'; ?>
        </div>
    </body>
</html>
