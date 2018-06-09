<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Title : Jouer
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
$paramData = Get_parameters($userData['user_id']);
$play = TRUE;

$_SESSION['cpt'] = 1;
$_SESSION['score'] = 0;
$_SESSION['played'] = [];
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
                <p>Vous allez jouer à un quizz de <?php echo $paramData['parameters_questions_number']; ?> questions sur les <?php
                    if ($paramData['parameters_type'] == 1) {
                        echo "chansons.";
                    } else {
                        echo "pochettes d'album.";
                    }
                    ?></p>
                <p>Vous aurez <?= $paramData['parameters_time']; ?> secondes par question.</p>
                <a class="btn btn-primary" href="playing.php">Commencer</a>
            </fieldset>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
