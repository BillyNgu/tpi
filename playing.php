<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : En jeu
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
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
            <fieldset>
                <legend>Jouer</legend>
                <p>Vous avez choisi un quizz de <?php ?> questions sur <?php ?></p>
                <p>Quelle est cette musique ?</p>
                <audio>
                    <source src="">
                </audio>
            </fieldset>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
