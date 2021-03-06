<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Result page where the user's score is showed
 */
require_once './dao/dao.php';

if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

// Initialize var
$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$paramData = Get_parameters($userData['user_id']);
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
                <legend>Résultat</legend>
                <p>Vous avez obtenu <?= $_SESSION['score']; ?> point(s) sur <?= $paramData['parameters_questions_number']; ?>.</p>
                <a class="btn btn-primary" href="play.php">Retour</a>
            </fieldset>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
