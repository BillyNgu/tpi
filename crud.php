<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : CRUD admin
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
$crud = TRUE;
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
            <h2>Configuration des questions</h2>
            <form action="crud.php" method="post" enctype="multipart/form-data">
                <div class="form-group">      
                    <label class="">Nom de la question : <input class="form-control" name="question" type="text"></label>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label>Proposition 1 : <input class="form-control" name="choice1" type="text"></label>
                            <label><input type="radio" name="choice" value="1" checked="checked" /> Make the answer.</label>
                        </div>
                        <div class="col">
                            <label>Proposition 2 : <input class="form-control" name="choice2" type="text"></label>
                            <label><input type="radio" name="choice" value="1" /> Make the answer.</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label>Proposition 3 : <input class="form-control" name="choice3" type="text"></label>
                            <label><input type="radio" name="choice" value="1" /> Make the answer.</label>
                        </div>
                        <div class="col">
                            <label>Proposition 4 : <input class="form-control" name="choice4" type="text"></label>
                            <label><input type="radio" name="choice" value="1" /> Make the answer.</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Le morceau : <input class="form-control-file" type="file" accept="audio/*"></label>
                    <label>Le cover (optionnel) : <input class="form-control-file" type="file" accept="image/*"></label>
                </div>
                <button class="btn btn-primary" type="submit">Ajouter</button>
            </form>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
