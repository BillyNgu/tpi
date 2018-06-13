<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Page before playing
 */
require_once './dao/dao.php';

if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$paramData = Get_parameters($userData['user_id']);
$music_style = Get_music_style_by_id($paramData['music_style_id']);
$play = TRUE;
$_SESSION['cpt'] = 0;
$_SESSION['score'] = 0;
$_SESSION['played'] = [];
unset($_SESSION['game_id']);
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
                <p>
                    Vous allez jouer à un quizz de <?= $paramData['parameters_questions_number']; ?> 
                    questions sur les musiques du style <?= strtolower($music_style); ?>.
                </p>
                <p>
                    Vous aurez 
                    <?= $paramData['parameters_time']; ?> 
                    secondes par question.
                </p>
                <a class="btn btn-primary" href="playing.php">Commencer</a>
            </fieldset>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
