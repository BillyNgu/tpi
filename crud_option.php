<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : Page d'affichage des différentes possibilités
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
$crud = TRUE;
$music = Get_all_music();
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
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Morceau</th>
                    <th>Pochette d'album</th>
                    <th>Modifier</th>
                    <th>Supprimer / <a class="btn btn-outline-primary" href="crud.php">Ajouter</a></th>
                </tr>
                <tr>
                    <?php foreach ($music as $value):?>
                    <td><?= $value; ?></td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
