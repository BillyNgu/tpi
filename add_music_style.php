<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Add style into the database 
 */
require_once './dao/dao.php';

if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$crud = TRUE;

if (filter_has_var(INPUT_POST, "add_style")) {
    $style = trim(filter_input(INPUT_POST, 'music_style', FILTER_SANITIZE_STRING));

    $errors_add_style = [];

    if (empty($style)) {
        $errors_add_style['music_style'] = "Le style ne peut pas être vide.";
    }

    if (empty($errors_add_style)) {
        Add_music_style($style);
    }
}
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
            <h2>Ajout d'un style de musique</h2>
            <form method="post" action="">
                <div class="form-group">      
                    <div class="row">
                        <div class="col">
                            <label>Style de musique : <input type="text" name="music_style" class="form-control"></label>
                            <?php
                            if (!empty($errors_add_style['music_style'])) {
                                echo $errors_add_style['music_style'];
                            }
                            ?>
                        </div>
                    </div>
                    <a class="btn btn-primary" href="add_music.php">Retour</a>
                    <input class="btn btn-primary" name="add_style" type="submit" value="Ajouter"/>
                    <?= GetFlashMessage(); ?>
                </div>
            </form>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
